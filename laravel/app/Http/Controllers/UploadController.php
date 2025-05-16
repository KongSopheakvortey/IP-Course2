<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // 1. Validate uploaded image
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Prepare file
        $file = $request->file('document');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $thumbnailName = 'thumb_' . $fileName;

        // 3. Create thumbnail 
        $thumbnail = Image::make($file->getRealPath());
        $thumbnail->fit(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->encode($file->getClientOriginalExtension());

        // 4. Store original image on MinIO
        $minioPath = 'uploads/' . $fileName;
        $uploaded = Storage::disk('minio')->put($minioPath, file_get_contents($file));

        // 5. Store thumbnail on MinIO 
        $thumbnailPath = 'thumbnails/' . $thumbnailName;
        $uploadedThumbnail = Storage::disk('minio')->put($thumbnailPath, $thumbnail);

        // 6. Check upload success
        if (!$uploaded || !$uploadedThumbnail) {
            \Log::error("Upload failed. Original: " . ($uploaded ? 'success' : 'failed') . 
                       ", Thumbnail: " . ($uploadedThumbnail ? 'success' : 'failed'));
            return response()->json(['error' => 'Upload to MinIO failed.'], 500);
        }

        // 7. Generate public URLs
        $minioUrl = env('MINIO_ENDPOINT') . '/' . env('MINIO_BUCKET') . '/' . $minioPath;
        $thumbnailUrl = env('MINIO_ENDPOINT') . '/' . env('MINIO_BUCKET') . '/' . $thumbnailPath;

        // 8. Return response
        return response()->json([
            'original_path' => $minioPath,
            'original_url' => $minioUrl,
            'thumbnail_path' => $thumbnailPath,
            'thumbnail_url' => $thumbnailUrl,
        ], 201);
    }
}