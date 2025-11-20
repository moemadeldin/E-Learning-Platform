<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

use Illuminate\Http\UploadedFile;

final readonly class UpdateProfileDTO
{
    public function __construct(
        public ?string $email,
        public ?string $bio,
        public ?string $national_id,
        public ?UploadedFile $avatar,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['email'],
            $data['bio'],
            $data['national_id'],
            array_key_exists('avatar', $data) ? $data['avatar'] : null
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'bio' => $this->bio,
            'national_id' => $this->national_id,
            'avatar' => $this->avatar,
        ];
    }
}
