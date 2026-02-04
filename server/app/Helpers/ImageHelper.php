<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    /**
     * Upload and resize image
     */
    public static function uploadImage(UploadedFile $file, string $folder = 'images', int $maxWidth = 1200, int $maxHeight = 800): string
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $folder . '/' . $filename;

        // Get file content
        $imageContent = $file->get();

        // Resize image if needed (requires intervention/image package)
        if (class_exists('Intervention\Image\Facades\Image')) {
            $image = Image::make($imageContent);
            
            // Resize if image is larger than max dimensions
            if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
                $image->resize($maxWidth, $maxHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Convert to JPEG for better compression
            $imageContent = $image->encode('jpg', 85)->__toString();
        }

        // Store the image
        Storage::disk('public')->put($path, $imageContent);

        return $path;
    }

    /**
     * Delete image
     */
    public static function deleteImage(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Get image URL
     */
    public static function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return asset('storage/' . $path);
    }

    /**
     * Validate image file
     */
    public static function validateImage(UploadedFile $file, int $maxSize = 2048): array
    {
        $errors = [];

        // Check file type
        $allowedTypes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedTypes)) {
            $errors[] = 'File phải có định dạng: ' . implode(', ', $allowedTypes);
        }

        // Check file size (in KB)
        if ($file->getSize() > $maxSize * 1024) {
            $errors[] = 'Kích thước file không được vượt quá ' . $maxSize . 'KB';
        }

        // Check if it's actually an image
        $imageInfo = getimagesize($file->getPathname());
        if (!$imageInfo) {
            $errors[] = 'File không phải là hình ảnh hợp lệ';
        }

        return $errors;
    }
}