<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        try {
            // Check if item has a valid photo_img path
            if (empty($item->photo_img)) {
                return back()->with('error', 'The item does not have an associated image.');
            }

            // Determine the correct path for the item image
            $itemImagePath = '';

            // First try loading from storage (for Backblaze)
            if (Storage::disk('s3')->exists($item->photo_img)) {
                // Create a temporary file to store the S3 image
                $tempItemFile = tempnam(sys_get_temp_dir(), 'item_img_');
                file_put_contents($tempItemFile, Storage::disk('s3')->get($item->photo_img));
                $itemImagePath = $tempItemFile;
                Log::info("Using S3 image path for comparison: " . $item->photo_img);
            }
            // Fallback to local storage
            else {
                $localPath = public_path('storage/' . $item->photo_img);
                if (file_exists($localPath)) {
                    $itemImagePath = $localPath;
                    Log::info("Using local image path for comparison: " . $localPath);
                } else {
                    return back()->with('error', 'Item image not found in storage.');
                }
            }

            // Create a temporary file for the uploaded image
            $tempUploadedFile = tempnam(sys_get_temp_dir(), 'uploaded_img_');
            file_put_contents($tempUploadedFile, file_get_contents($uploadedImage->path()));

            // Flask API URL
            $flaskUrl = 'https://algo-production-c395.up.railway.app/compare';

            // Send images as multipart/form-data
            $response = Http::attach(
                'img1', file_get_contents($itemImagePath), 'item.jpg'
            )->attach(
                'img2', file_get_contents($tempUploadedFile), $uploadedImage->getClientOriginalName()
            )->timeout(60)->post($flaskUrl);

            // Clean up temp files
            if (isset($tempItemFile) && file_exists($tempItemFile)) {
                unlink($tempItemFile);
            }
            if (file_exists($tempUploadedFile)) {
                unlink($tempUploadedFile);
            }

            // Check response
            if ($response->failed()) {
                Log::error('API error: ' . $response->body());
                return back()->with('error', 'Error communicating with the Flask API. Please try again.');
            }

            // Redirect with result
            $result = $response->json();
            return redirect('/compare-result/' . $item->id)->with('result', $result);

        } catch (\Exception $e) {
            Log::error('Comparison error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred during comparison. ' . $e->getMessage());
        }
    }

    // Show comparison result
    public function compareResult(Item $item)
    {
        if (!session()->has('result')) {
            return redirect('/compare/' . $item->id)->with('error', 'No comparison results available.');
        }

        return view('compare-result', [
            'item' => $item,
            'result' => session('result')
        ]);
    }
}
