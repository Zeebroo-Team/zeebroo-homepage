<?php

namespace App\Services;

use App\Models\SeoPage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Turns an uploaded picture into a share image: centre-cropped to 1200x630 and
 * re-encoded as JPEG with GD, which also drops anything hidden in the original file.
 */
class SocialImageService
{
    private const JPEG_QUALITY = 85;

    /**
     * Crop, resize and save the upload on the public disk; returns its path there.
     */
    public function store(UploadedFile $file, string $directory = 'seo'): string
    {
        $source = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));

        if ($source === false) {
            throw new RuntimeException('The uploaded file could not be read as an image.');
        }

        $width = SeoPage::OG_IMAGE_WIDTH;
        $height = SeoPage::OG_IMAGE_HEIGHT;
        [$cropX, $cropY, $cropWidth, $cropHeight] = $this->coverArea(imagesx($source), imagesy($source), $width, $height);

        $canvas = imagecreatetruecolor($width, $height);
        imagefill($canvas, 0, 0, (int) imagecolorallocate($canvas, 255, 255, 255));
        imagecopyresampled($canvas, $source, 0, 0, $cropX, $cropY, $width, $height, $cropWidth, $cropHeight);

        ob_start();
        imagejpeg($canvas, null, self::JPEG_QUALITY);
        $jpeg = (string) ob_get_clean();

        $path = trim($directory, '/').'/'.Str::uuid().'.jpg';
        Storage::disk('public')->put($path, $jpeg);

        return $path;
    }

    /**
     * The largest centred part of the source with the target's shape.
     *
     * @return array{int, int, int, int} x, y, width and height of the area to copy
     */
    private function coverArea(int $sourceWidth, int $sourceHeight, int $targetWidth, int $targetHeight): array
    {
        $targetRatio = $targetWidth / $targetHeight;

        if ($sourceWidth / $sourceHeight > $targetRatio) {
            $cropWidth = (int) round($sourceHeight * $targetRatio);

            return [intdiv($sourceWidth - $cropWidth, 2), 0, $cropWidth, $sourceHeight];
        }

        $cropHeight = (int) round($sourceWidth / $targetRatio);

        return [0, intdiv($sourceHeight - $cropHeight, 2), $sourceWidth, $cropHeight];
    }
}
