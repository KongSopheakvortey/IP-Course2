<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('document');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // Store uploaded image locally and on MinIO
        $uploadedPath = 'uploads/' . $fileName;
        Storage::disk('public')->put($uploadedPath, file_get_contents($file));
        Storage::disk('minio')->put($uploadedPath, file_get_contents($file));

        // Create thumbnail
        $thumbnailName = 'thumb_' . $fileName;
        $thumbnail = Image::make($file->getRealPath());
        $thumbnail->fit(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->encode($file->getClientOriginalExtension());

        // Store thumbnail locally and on MinIO
        $thumbnailPath = 'thumbnails/' . $thumbnailName;
        Storage::disk('public')->put($thumbnailPath, $thumbnail);
        Storage::disk('minio')->put($thumbnailPath, $thumbnail);

        return redirect()->route('gallery.index')->with('success', 'Image upload successfully');
    }
}