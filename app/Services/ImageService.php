<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Upload an image to the specified path.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param string|null $oldImage
     * @return string
     */
    public function upload(UploadedFile $file, string $path, ?string $oldImage = null): string
    {
        // Delete old image if exists
        if ($oldImage) {
            $this->delete($oldImage);
        }

        // Store new image
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($path, $filename, 'public');

        return $filePath;
    }

    /**
     * Delete an image from storage.
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
