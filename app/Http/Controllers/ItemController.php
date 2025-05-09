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
            'photo_img' => ['required', 'image', 'max:3000'],
            'location' => 'required'
        ]);

        $incomingFields['user_id'] = auth()->id();
        $incomingFields['postedby'] = auth()->user()->username;

        // Prepare incoming fields with authenticated user ID
        $incomingFields['user_id'] = auth()->id(); // Ensure user_id is present
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['markings'] = strip_tags($incomingFields['markings']);

        // Create the item first to get the item ID
        $newItem = Item::create($incomingFields);

        // Handle the image upload only if a file was uploaded
        if ($request->hasFile('photo_img')) {
            $filename = $newItem->id . "-" . uniqid() . ".jpg";

            $manager = new ImageManager(new Driver()); // Instantiate ImageManager
            $image = $manager->read($request->file('photo_img')->getRealPath()); // Read the uploaded image
            $imgData = $image->cover(960, 1280)->toJpeg(); // Resize and encode to jpg

            // Store the image in the 'public' disk
            Storage::disk('s3')->put('photo_img/' . $filename, $imgData);

            // Update the item with the image path
            $newItem->photo_img = 'photo_img/' . $filename;
            $newItem->save();

        }

        // Redirect to the new item's page with a success message
        return redirect("/item/{$newItem->id}")->with('success', 'New Lost Item Posted');
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

        // (Optional) Handle image update...

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

    $image = $request->file('image');
    $filename = uniqid() . '-' . $image->getClientOriginalName();
    $destinationPath = public_path('storage/photo_img');
    $image->move($destinationPath, $filename);
    $fullUploadedPath = $destinationPath . '/' . $filename;

    \Log::info("File moved to: {$fullUploadedPath}");

    if (!file_exists($fullUploadedPath)) {
        \Log::error("Uploaded image not found at path: {$fullUploadedPath}");
        return view('search-comparison-results', [
            'items' => collect(), // empty collection
            'results' => [],
        ])->withErrors(['image' => 'No Match Found']);
    }

    $results = [];
    $validItemIds = [];

    foreach ($request->matched_items as $itemId => $imgPath) {
        $itemImagePath = public_path("storage/" . $imgPath);

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
                        'uploaded' => asset("storage/photo_img/{$filename}"),
                        'matched' => asset("storage/{$imgPath}"),
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

    $items = Item::whereIn('id', $validItemIds)->with('user')->get();

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


