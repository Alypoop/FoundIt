<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\ItemHistory;
use App\Models\Category;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;


class ItemController extends Controller
{


public function showCreateItem(User $user)
{
    $categories = Category::all();
    return view('post-item', ['user' => $user, 'categories' => $categories]);
}


   public function postItem(Request $request)
{
    $incomingFields = $request->validate([
        'title' => 'required',
        'lost_date' => 'required',
        'category_id' => 'required|exists:categories,id',
        'item_type_id' => 'required|exists:item_types,id',
        'markings' => 'required',
        'photo_img' => ['required', 'image', 'max:3000'],
        'location' => 'required'
    ]);

    $incomingFields['user_id'] = auth()->id();
    $incomingFields['postedby'] = auth()->user()->username;

    $incomingFields['title'] = strip_tags($incomingFields['title']);
    $incomingFields['markings'] = strip_tags($incomingFields['markings']);

    $newItem = Item::create($incomingFields);

    if ($request->hasFile('photo_img')) {
        $filename = $newItem->id . "-" . uniqid() . ".jpg";

        $manager = new \Intervention\Image\ImageManager(['driver' => 'gd']);
        $image = $manager->make($request->file('photo_img')->getRealPath());
        $imgData = (string) $image->resize(960, 1280, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('jpg');

        \Storage::disk('public')->put('photo_img/' . $filename, $imgData);

        $newItem->photo_img = 'photo_img/' . $filename;
        $newItem->save();
    }

    return redirect("/item/{$newItem->id}")->with('success', 'New Lost Item Posted');
}

public function viewsingleItem(Item $item, User $user)
{
    // Eager load the category and itemType relationships
    $item->load(['category', 'itemType', 'user']);
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
    // Load all categories and the item's relationships
    $categories = Category::all();
    $item->load(['category', 'itemType']);
    
    // Get item types for the current item's category
    $itemTypes = [];
    if ($item->category_id) {
        $itemTypes = ItemType::where('category_id', $item->category_id)->get();
    }

    return view('edit-item', [
        'item' => $item,
        'user' => $user,
        'profile' => $user->profile,
        'categories' => $categories,
        'itemTypes' => $itemTypes
    ]);
}

public function updatedItem(Item $item, Request $request)
{
    $incomingFields = $request->validate([
        'title' => 'required|string|max:255',
        'lost_date' => 'required|date',
        'category_id' => 'required|exists:categories,id',
        'item_type_id' => 'required|exists:item_types,id,category_id,'.$request->category_id,
        'markings' => 'required|string',
        'status' => 'nullable|in:Claimed,To Be Claimed,Unclaimed,Disposed',
        'bin' => 'nullable|string|max:255',
        'issued_by' => 'nullable|string|max:255',
        'issued_date' => 'nullable|date',
        'received_by' => 'nullable|string|max:255',
        'received_date' => 'nullable|date',
        'location' => 'required|string|max:255',
        'photo_img' => 'nullable|image|max:3000',
        'remove_image' => 'nullable|boolean'
    ]);

    // Clean input fields
    $incomingFields['title'] = strip_tags($incomingFields['title']);
    $incomingFields['markings'] = strip_tags($incomingFields['markings']);
    $incomingFields['user_id'] = $item->user_id; // Maintain original owner

    // Handle image removal/update
    if (!empty($incomingFields['remove_image'])) {
        Storage::disk('public')->delete($item->photo_img);
        $incomingFields['photo_img'] = null;
    } elseif ($request->hasFile('photo_img')) {
        // Delete old image if exists
        if ($item->photo_img) {
            Storage::disk('public')->delete($item->photo_img);
        }

        // Process new image upload
        $filename = $item->id . "-" . uniqid() . ".jpg";
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('photo_img')->getRealPath());
        $imgData = (string) $image->resize(960, 1280, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('jpg');

        Storage::disk('public')->put('photo_img/' . $filename, $imgData);
        $incomingFields['photo_img'] = 'photo_img/' . $filename;
    } else {
        // Keep existing image if no changes
        unset($incomingFields['photo_img']);
    }

    // Save original status for history
    $originalStatus = $item->status;

    // Update the item
    $item->update($incomingFields);

    // Record status change if needed
    if ($item->wasChanged('status')) {
        ItemHistory::create([
            'item_id' => $item->id,
            'changed_from' => $originalStatus,
            'changed_to' => $item->status,
            'action' => 'status update',
            'changed_by' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' (' . auth()->user()->username . ')',
        ]);
    }

    return redirect("/item/{$item->id}")->with('success', 'Item updated successfully');
}

 public function search(Request $request)
    {
        // Get categories from database
        $categories = Category::all();
        $locations = ['TSU San Isidro', 'TSU Main', 'TSU Lucinda'];

        $selectedCategories = $request->input('category', []);
        $selectedLocations = $request->input('location', []);
        $selectedItemTypes = $request->input('item_type', []);
        $keyword = $request->input('keyword');

        // Split keyword into tokens for more flexible searching
        $keywords = $keyword ? preg_split('/\s+/', $keyword) : [];

        $items = Item::with(['user', 'category', 'itemType'])
            ->when(!empty($keywords), function ($query) use ($keywords) {
                $query->where(function ($subQuery) use ($keywords) {
                    foreach ($keywords as $word) {
                        $subQuery->orWhere('title', 'LIKE', "%$word%")
                                 ->orWhere('markings', 'LIKE', "%$word%");
                    }
                });
            })
            ->when($selectedCategories, function ($query, $selectedCategories) {
                $query->whereIn('category_id', $selectedCategories);
            })
            ->when($selectedItemTypes, function ($query, $selectedItemTypes) {
                $query->whereIn('item_type_id', $selectedItemTypes);
            })
            ->when($selectedLocations, function ($query, $selectedLocations) {
                $query->whereIn('location', $selectedLocations);
            })
            ->whereNotIn('status', ['Claimed', 'To Be Claimed', 'Disposed'])
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('partials.search-results', compact('items'))->render(),
                'items' => $items->map(function($item) {
                    return [
                        'id' => $item->id,
                        'photo_img' => $item->photo_img,
                        'item_type_id' => $item->item_type_id,
                        'category_id' => $item->category_id
                    ];
                })
            ]);
        }

        return view('search', compact('items', 'categories', 'locations'));
    }

 public function getItemTypes(Request $request)
{
    $request->validate([
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id'
    ]);

    \Log::debug('Requested categories:', $request->categories);
    
    $itemTypes = ItemType::whereIn('category_id', $request->categories)
        ->get(['id', 'name', 'category_id']);

    \Log::debug('Returning item types:', $itemTypes->toArray());

    return response()->json(['itemTypes' => $itemTypes]);
}

    public function compareWithImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'matched_items' => 'sometimes|array'
        ]);

        // Process uploaded image
        $image = $request->file('image');
        $filename = uniqid() . '-' . $image->getClientOriginalName();
        $image->move(public_path('storage/photo_img'), $filename);
        $uploadedImagePath = public_path("storage/photo_img/{$filename}");

        // Get items to compare (filtered or all)
        $itemsToCompare = empty($request->matched_items) 
            ? Item::query()
                ->when($request->has('filters'), function($query) use ($request) {
                    $filters = $request->input('filters');
                    if (!empty($filters['category'])) {
                        $query->whereIn('category_id', $filters['category']);
                    }
                    if (!empty($filters['item_type'])) {
                        $query->whereIn('item_type_id', $filters['item_type']);
                    }
                    if (!empty($filters['location'])) {
                        $query->whereIn('location', $filters['location']);
                    }
                })
                ->whereNotIn('status', ['Claimed', 'To Be Claimed', 'Disposed'])
                ->get()
            : Item::whereIn('id', array_keys($request->matched_items))
                ->get();

        // Compare all items
        $results = [];
        $validItemIds = [];
        
        foreach ($itemsToCompare as $item) {
            try {
                $response = Http::attach('img1', file_get_contents($uploadedImagePath), 'uploaded.jpg')
                              ->attach('img2', file_get_contents(public_path("storage/{$item->photo_img}")), 'item.jpg')
                              ->post('http://localhost:5050/compare');

                if ($response->successful()) {
                    $data = $response->json();
                    $results[$item->id] = $data;
                    
                    // Store comparison data for ALL compared items
                    session()->put("comparison_{$item->id}", [
                        'uploaded' => asset("storage/photo_img/{$filename}"),
                        'matched' => asset("storage/{$item->photo_img}"),
                        'result' => $data,
                    ]);

                    if ($data['final_similarity_score'] >= 60) {
                        $validItemIds[] = $item->id;
                    }
                }
            } catch (\Exception $e) {
                $results[$item->id] = ['error' => $e->getMessage()];
            }
        }

        // Get most common item type from results
        $topItemType = $itemsToCompare->whereIn('id', $validItemIds)
                                    ->groupBy('item_type_id')
                                    ->sortByDesc(fn($group) => $group->count())
                                    ->keys()
                                    ->first();

        // Get related items
        $relatedItems = $topItemType 
            ? Item::where('item_type_id', $topItemType)
                  ->whereNotIn('id', $validItemIds)
                  ->with(['user', 'category', 'itemType'])
                  ->latest()
                  ->take(10)
                  ->get()
            : collect();

        return view('search-comparison-results', [
            'items' => $itemsToCompare->whereIn('id', $validItemIds),
            'filteredItems' => $itemsToCompare,
            'results' => $results,
            'relatedItems' => $relatedItems,
            'appliedFilters' => $request->input('filters', []),
            'topItemType' => $topItemType ? ItemType::find($topItemType)->name : null
        ]);
    }

    public function viewComparison($id)
    {
        $item = Item::with(['user', 'category', 'itemType'])->findOrFail($id);
        $comparison = session()->get("comparison_{$id}");

        if (!$comparison) {
            return redirect()->back()->with('error', 'Comparison data not found');
        }

        return view('compare-view', [
            'item' => $item,
            'comparison' => $comparison
        ]);
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


