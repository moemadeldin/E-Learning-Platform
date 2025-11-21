<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use Illuminate\Http\UploadedFile;

final readonly class CourseDTO
{
    public function __construct(
        public string $name,
        public UploadedFile|string $thumbnail,
        public string $description,
        public string $long_description,
        public string $price,
        public string|int $is_free,
        public string $level,
        public string $language,
        public string $category_id,
        public int|string $user_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['thumbnail'],
            $data['description'],
            $data['long_description'],
            $data['price'],
            $data['is_free'],
            $data['level'],
            $data['language'],
            $data['category_id'],
            $data['user_id'] ?? auth()->id(),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'long_description' => $this->long_description,
            'price' => $this->price,
            'is_free' => $this->is_free,
            'level' => $this->level,
            'language' => $this->language,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
        ];
    }
}
