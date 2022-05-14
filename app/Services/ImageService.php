<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image as Intervention;

class ImageService
{
    /**
     * Compress an image.
     *
     * @param Image $image
     * @return void
     */
    public function compressImage(Image $image): void
    {
        $intervention = Intervention::make($image->getFilePath());

        $intervention->resize(1080, 1080, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        DB::transaction(function () use ($image, $intervention) {
            $originalPath = $image->getFilePath();

            $this->changeFileExtension($image, 'webp');
            $intervention->save($image->getFilePath(), 60, 'webp');

            // Delete original file after compression
            if ($originalPath !== $image->getFilePath()) {
                File::delete($originalPath);
            }
        });
    }

    /**
     * Change the file extension of an image's filename (only affects the database).
     *
     * @param Image $image
     * @param string $extension The new file extension
     * @return void
     */
    public function changeFileExtension(Image $image, string $extension): void
    {
        $filename = pathinfo($image->getFilePath(), PATHINFO_FILENAME);

        $image->update([
            'filename' => "{$filename}.{$extension}",
        ]);
    }
}
