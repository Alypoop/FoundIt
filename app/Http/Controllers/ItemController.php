<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\ItemHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ItemController extends Controller
{
    public function showCreateItem(User $user)
    {
        return view('post-item', ['user' => $user]);
    }

    public function postItem(Request $request)
    {
        // Validate the incoming request fields
        $incomingFields = $request->validate([
            'title' => 'required',
            'lost_date' => 'required',
            'category' => 'required',
            'markings' => 'required',
            'photo_img' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:3000'],
            'location' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->id();
        $incomingFields['postedby'] = auth()->user()->username;

        // Prepare incoming fields with authenticated user ID
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['markings'] = strip_tags($incomingFields['markings']);

        // Create the item first to get the item ID
        $newItem = Item::create($incomingFields);

        // Handle the image upload only if a file was uploaded
        if ($request->hasFile('photo_img')) {
            try {
                $filename = $newItem->id . "-" . uniqid() . ".jpg";
                $uploadedFile = $request->file('photo_img');

                // Read image with PHP's native functions to avoid WebP issues
                $imageContents = file_get_contents($uploadedFile->getRealPath());
                $sourceImage = imagecreatefromstring($imageContents);

                if ($sourceImage) {
                    // Create a new image with desired dimensions
                    $width = 960;
                    $height = 1280;

                    // Get original dimensions
                    $originalWidth = imagesx($sourceImage);
                    $originalHeight = imagesy($sourceImage);

                    // Calculate aspect ratios
                    $originalRatio = $originalWidth / $originalHeight;
                    $targetRatio = $width / $height;

                    // Determine dimensions for cropping
                    if ($originalRatio > $targetRatio) {
                        // Original image is wider
                        $newWidth = intval($originalHeight * $targetRatio);
                        $newHeight = $originalHeight;
                        $sourceX = intval(($originalWidth - $newWidth) / 2);
                        $sourceY = 0;
                    } else {
                        // Original image is taller
                        $newWidth = $originalWidth;
                        $newHeight = intval($originalWidth / $targetRatio);
                        $sourceX = 0;
                        $sourceY = intval(($originalHeight - $newHeight) / 2);
                    }

                    // Create new true color image
                    $targetImage = imagecreatetruecolor($width, $height);

                    // Copy and resize part of an image with resampling
                    imagecopyresampled(
                        $targetImage, $sourceImage,
                        0, 0, $sourceX, $sourceY,
                        $width, $height, $newWidth, $newHeight
                    );

                    // Capture the image data
                    ob_start();
                    imagejpeg($targetImage, null, 85);
                    $imgData = ob_get_contents();
                    ob_end_clean();

                    // Free up memory
                    imagedestroy($sourceImage);
                    imagedestroy($targetImage);

                    // Store the new image in the 'photo_img/' folder on S3 (Backblaze B2)
                    Storage::disk('s3')->put('photo_img/' . $filename, $imgData);

                    // Update the item with the new image path
                    $newItem->photo_img = 'photo_img/' . $filename;
                    $newItem->save();
                } else {
                    throw new \Exception("Failed to create image from string");
                }
            } catch (\Exception $e) {
                // Log error and use a simpler approach as fallback
                \Log::error('Image processing error: ' . $e->getMessage());

                // Create a simpler version using only the upload functionality
                $path = $request->file('photo_img')->store('photo_img', 's3');
                $newItem->photo_img = $path;
                $newItem->save();
            }
        }

        return back()->with('success', 'Item Created Successfully');
    }

    public function viewsingleItem(Item $item, User $user)
    {
        $item->load('user');
        return view('single-item', ['item' => $item, 'user' => $user]);
    }

    public function deleteItem(Item $item)
    {
        if(auth()->user()->cannot('delete', $item))
        {
            abort(403, 'Unauthorized action.');
        }
        else
        {
            $item->delete();
        }
        return redirect('/profile/' .auth()->user()->username)->with('success', 'Item Successfully Deleted');
    }

    public function updateItem(Item $item, User $user)
    {
        return view('edit-item', ['item' => $item, 'user' => $user, 'profile' => $user->profile]);
    }

    public function updatedItem(Item $item, Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'lost_date' => 'required',
            'category' => 'required',
            'markings' => 'required',
            'status' => 'nullable',
            'bin' => 'nullable',
            'issued_by' => 'nullable',
            'issued_date' => 'nullable',
            'received_by' => 'nullable',
            'received_date' => 'nullable',
            'location' => 'required',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['markings'] = strip_tags($incomingFields['markings']);
        $incomingFields['user_id'] = $item->user_id;

        $originalStatus = $item->status;

        $item->update($incomingFields);

        // 🔥 Save status change history
        if ($item->wasChanged('status')) {
            ItemHistory::create([
                'item_id' => $item->id,
                'changed_from' => $originalStatus,
                'changed_to' => $item->status,
                'action' => 'status update',
                'changed_by' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' (' . auth()->user()->username . ')',
            ]);
        }

        return back()->with('success', 'Item Updated');
    }

    public function search(Request $request)
    {
        $categories = $request->input('category', []);
        $locations = $request->input('location', []);
        $keyword = $request->input('keyword');

        $items = Item::with('user')
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('title', 'LIKE', "%$keyword%")
                            ->orWhere('markings', 'LIKE', "%$keyword%")
                            ->orWhere('lost_date', 'LIKE', "%$keyword%");
                });
            })
            ->when($categories, function ($query, $categories) {
                $query->whereIn('category', $categories);
            })
            ->when($locations, function ($query, $locations) {
                $query->whereIn('location', $locations);
            })
            ->whereNotIn('status', ['Claimed', 'To Be Claimed', 'Disposed']) // 👈 Exclude these statuses
            ->get();

        return view('search', compact('items'));
    }

    public function compareWithImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        'matched_items' => 'required|array',
    ]);

    // Store the uploaded image in S3
    $image = $request->file('image');
    $filename = uniqid() . '-' . $image->getClientOriginalName();
    $path = $image->storeAs('photo_img', $filename, 's3'); // Store in S3
    $fullUploadedPath = Storage::disk('s3')->url($path); // Get the public URL for the uploaded image

    \Log::info("File uploaded to S3: {$fullUploadedPath}");

    $results = [];
    $validItemIds = [];

    foreach ($request->matched_items as $itemId => $imgPath) {
        // Generate a temporary URL for the matched item image
        $itemImagePath = (new class {
            use S3UrlHelper;
        })->getTemporaryUrl($imgPath, 60); // Generate a temporary URL valid for 60 minutes

        try {
            $response = Http::attach('img1', file_get_contents($fullUploadedPath), 'uploaded.jpg')
                            ->attach('img2', file_get_contents($itemImagePath), 'item.jpg')
                            ->post('http://127.0.0.1:5050/compare');

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['final_similarity_score']) && $data['final_similarity_score'] >= 60) {
                    $validItemIds[] = $itemId;

                    $results[$itemId] = $data;

                    session()->put("comparison_{$itemId}", [
                        'uploaded' => $fullUploadedPath,
                        'matched' => $itemImagePath,
                        'result' => $data,
                        'match_image_url' => $data['match_image_url'] ?? null,
                    ]);
                }
            } else {
                \Log::error("Comparison failed for item ID {$itemId}: " . $response->body());
                $results[$itemId] = ['error' => 'Comparison failed'];
            }
        } catch (\Exception $e) {
            \Log::error("Comparison error for item ID {$itemId}: " . $e->getMessage());
            $results[$itemId] = ['error' => 'Server error during comparison'];
        }
    }

    // No match passed the threshold
    if (empty($validItemIds)) {
        return view('search-comparison-results', [
            'items' => collect(),
            'results' => [],
        ])->withErrors(['image' => 'No Match Found']);
    }

    // Fetch items with user data
    $items = Item::whereIn('id', $validItemIds)->with('user')->get();

    // Return the view with items and results
    return view('search-comparison-results', compact('items', 'results'));
}

    public function viewComparison($id)
    {
        $item = Item::with('user')->findOrFail($id);
        $sessionKey = "comparison_{$id}";

        $comparison = session()->get($sessionKey);

        return view('compare-view', compact('item', 'comparison'));
    }

    public function claimItem(Request $request, Item $item)
    {
        $originalStatus = $item->status;

        $item->update([
            'status' => 'To Be Claimed',
            'claimed_by' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' (' . auth()->user()->username . ')',
            'received_date' => now(),
        ]);

        // Save status change history
        \App\Models\ItemHistory::create([
            'item_id' => $item->id,
            'changed_from' => $originalStatus,
            'changed_to' => $item->status,
            'action' => 'claimed',
            'changed_by' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' (' . auth()->user()->username . ')',
        ]);

        return redirect('/')->with('success', 'Please claim the item at the Dean\'s Office.');
    }

    public function viewHistory(Item $item)
    {
        $histories = $item->histories()->latest()->get();
        return view('item-history', compact('item', 'histories'));
    }

    public function viewAllHistory()
    {
        $histories = \App\Models\ItemHistory::with('item')->latest()->get();
        return view('all-history', compact('histories'));
    }
}
