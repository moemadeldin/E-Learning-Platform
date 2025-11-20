<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\ImageManagerInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class ImageManager implements ImageManagerInterface
{
    public function __construct(
        private readonly string $disk = 'public'
    ) {}

    public function upload(UploadedFile $file, string $directory, ?string $filename = null): string
    {
        $filename = $filename ?: $this->generateFilename($file);

        return $file->storeAs($directory, $filename, $this->disk);
    }

    public function delete(?string $path): bool
    {
        if ($path && Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }

    private function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        return Str::slug($name).'_'.time().'_'.Str::random(6).'.'.$extension;
    }
}