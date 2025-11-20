<?php

declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Http\UploadedFile;

interface ImageManagerInterface
{
    public function upload(UploadedFile $file, string $directory, ?string $filename = null): string;
    public function delete(?string $path): bool;
}