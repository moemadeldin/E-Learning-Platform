<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

final readonly class TeacherRegistrationDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $first_name,
        public string $last_name,
        public string $national_id,
        public string $category_id,
        public string $title,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['first_name'],
            $data['last_name'],
            $data['national_id'],
            $data['category_id'],
            $data['title'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'national_id' => $this->national_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
        ];
    }
}
