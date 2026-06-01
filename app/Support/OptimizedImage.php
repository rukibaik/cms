<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class OptimizedImage
{
    private const VARIANT_WIDTHS = [360, 480, 640, 768, 960, 1280];

    private static array $srcsetCache = [];

    public static function storeHeroBackground(UploadedFile $image): string
    {
        return self::store($image, 'hero', 1920, 1080, 76, [480, 640, 768, 960, 1280]);
    }

    public static function storeServiceItem(UploadedFile $image): string
    {
        return self::store($image, 'services/items', 1200, 800, 76, [360, 480, 640, 768]);
    }

    public static function srcset(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (array_key_exists($path, self::$srcsetCache)) {
            return self::$srcsetCache[$path];
        }

        $disk = Storage::disk('public');
        $candidates = [];

        foreach (self::variantPaths($path) as $width => $candidate) {
            if (! $disk->exists($candidate)) {
                continue;
            }

            $candidates[$width] = asset('storage/'.$candidate).' '.$width.'w';
        }

        if ($disk->exists($path)) {
            $size = @getimagesize($disk->path($path));

            if ($size && ! empty($size[0])) {
                $candidates[(int) $size[0]] = asset('storage/'.$path).' '.(int) $size[0].'w';
            }
        }

        if ($candidates === []) {
            return self::$srcsetCache[$path] = null;
        }

        ksort($candidates);

        return self::$srcsetCache[$path] = implode(', ', $candidates);
    }

    public static function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        Storage::disk('public')->delete([$path, ...self::variantPaths($path)]);
    }

    private static function store(
        UploadedFile $image,
        string $directory,
        int $maxWidth,
        int $maxHeight,
        int $quality,
        array $variantWidths = []
    ): string
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

        foreach ($variantWidths as $variantWidth) {
            if ($variantWidth < $targetWidth) {
                self::storeVariant($source, $path, $variantWidth, $quality);
            }
        }

        @unlink($temporaryPath);
        imagedestroy($source);
        imagedestroy($target);

        return $path;
    }

    private static function storeVariant(\GdImage $source, string $originalPath, int $targetWidth, int $quality): void
    {
        $width = imagesx($source);
        $height = imagesy($source);
        $scale = min($targetWidth / $width, 1);
        $variantWidth = max(1, (int) round($width * $scale));
        $variantHeight = max(1, (int) round($height * $scale));
        $target = imagecreatetruecolor($variantWidth, $variantHeight);

        if (! $target) {
            return;
        }

        imagealphablending($target, false);
        imagesavealpha($target, true);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $variantWidth, $variantHeight, $width, $height);

        $temporaryPath = tempnam(sys_get_temp_dir(), 'optimized-image-variant-');

        if ($temporaryPath && imagewebp($target, $temporaryPath, $quality)) {
            Storage::disk('public')->put(self::variantPath($originalPath, $variantWidth), (string) file_get_contents($temporaryPath));
        }

        if ($temporaryPath) {
            @unlink($temporaryPath);
        }

        imagedestroy($target);
    }

    private static function variantPaths(string $path): array
    {
        return array_combine(
            self::VARIANT_WIDTHS,
            array_map(fn (int $width) => self::variantPath($path, $width), self::VARIANT_WIDTHS)
        );
    }

    private static function variantPath(string $path, int $width): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $pathWithoutExtension = substr($path, 0, -1 * (strlen($extension) + 1));

        return $pathWithoutExtension.'-'.$width.'.'.$extension;
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
