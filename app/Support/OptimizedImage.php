<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class OptimizedImage
{
    public static function storeHeroBackground(UploadedFile $image): string
    {
        return self::store($image, 'hero', 1920, 1080, 82);
    }

    public static function storeServiceItem(UploadedFile $image): string
    {
        return self::store($image, 'services/items', 1200, 800, 82);
    }

    private static function store(UploadedFile $image, string $directory, int $maxWidth, int $maxHeight, int $quality): string
    {
        $source = @imagecreatefromstring((string) file_get_contents($image->getRealPath()));

        if (! $source) {
            throw new RuntimeException('Unable to process the uploaded image.');
        }

        $source = self::orientImage($source, $image);

        $width = imagesx($source);
        $height = imagesy($source);
        $scale = min($maxWidth / $width, $maxHeight / $height, 1);
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));

        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        if (! $target) {
            imagedestroy($source);

            throw new RuntimeException('Unable to prepare the optimized image.');
        }

        imagealphablending($target, false);
        imagesavealpha($target, true);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $temporaryPath = tempnam(sys_get_temp_dir(), 'optimized-image-');

        if (! $temporaryPath || ! imagewebp($target, $temporaryPath, $quality)) {
            imagedestroy($source);
            imagedestroy($target);

            throw new RuntimeException('Unable to save the optimized image.');
        }

        $path = trim($directory, '/').'/'.Str::uuid().'.webp';
        Storage::disk('public')->put($path, (string) file_get_contents($temporaryPath));

        @unlink($temporaryPath);
        imagedestroy($source);
        imagedestroy($target);

        return $path;
    }

    private static function orientImage(\GdImage $image, UploadedFile $upload): \GdImage
    {
        if (! function_exists('exif_read_data') || ! in_array($upload->getMimeType(), ['image/jpeg', 'image/jpg'], true)) {
            return $image;
        }

        $exif = @exif_read_data($upload->getRealPath());
        $orientation = (int) ($exif['Orientation'] ?? 1);

        return match ($orientation) {
            3 => imagerotate($image, 180, 0) ?: $image,
            6 => imagerotate($image, -90, 0) ?: $image,
            8 => imagerotate($image, 90, 0) ?: $image,
            default => $image,
        };
    }
}
