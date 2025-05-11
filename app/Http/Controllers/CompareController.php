<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CompareController extends Controller
{
    // Display the comparison page with the item's image
    public function viewCompare(Item $item)
    {
        return view('view-compare', ['item' => $item]);
    }

    // Handle image comparison
    public function compareItem(Request $request, Item $item)
{
    $request->validate([
        'compare_img' => 'required|image|mimes:jpg,jpeg,png|max:5120' // 5MB limit
    ]);

    $uploadedImage = $request->file('compare_img');

    // ✅ Construct the correct image path from `public/storage/photo_img/`
    $itemImagePath = public_path('storage/' . $item->photo_img);

    // ✅ Check if the item image exists
    if (!file_exists($itemImagePath)) {
        return back()->with('error', 'Item image not found.');
    }

    // ✅ Flask API URL
    $flaskUrl = 'https://algo-production-c395.up.railway.app/compare';

    // ✅ Send images as multipart/form-data
    $response = Http::attach(
        'img1', file_get_contents($itemImagePath), 'item.jpg'
    )->attach(
        'img2', file_get_contents($uploadedImage->path()), $uploadedImage->getClientOriginalName()
    )->post($flaskUrl);

    // ✅ Check response
    if ($response->failed()) {
        return back()->with('error', 'Error communicating with the Flask API. Response: ' . $response->body());
    }

    // ✅ Redirect with result
    $result = $response->json();
    return redirect('/compare-result/' . $item->id)->with('result', $result);
}


    // Show comparison result
    public function compareResult(Item $item)
    {
        return view('compare-result', [
            'item' => $item,
            'result' => session('result')
        ]);
    }
}
