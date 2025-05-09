<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait S3UrlHelper
{
    /**
     * Get a temporary URL for an S3 file
     *
     * @param string $path The file path in S3
     * @param int $minutes The number of minutes the URL should be valid
     * @return string|null The temporary URL or null if error
     */
    public function getTemporaryUrl($path, $minutes = 60)
    {
        if (empty($path)) {
            return null;
        }

        try {
            if (Storage::disk('s3')->exists($path)) {
                return Storage::disk('s3')->temporaryUrl($path, now()->addMinutes($minutes));
            }

            Log::warning("File not found in S3: {$path}");
            return null;
        } catch (\Exception $e) {
            Log::error("Error generating temporary URL for {$path}: " . $e->getMessage());
            return null;
        }
    }
}
