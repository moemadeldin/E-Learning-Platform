<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\Auth\UpdateProfileDTO;
use App\Interfaces\ImageManagerInterface;
use App\Models\User;
use Illuminate\Http\UploadedFile;

final class UpdateProfileAction
{
    public function __construct(private readonly ImageManagerInterface $imageManager) {}
    public function execute(User $user, array $data, UpdateProfileDTO $dto): void
    {
        if (isset($data['email'])) {
            $user->update([
                'email' => $dto->email,
            ]);
        }
        if (isset($data['bio'])) {
            $user->profile()->update([
                'bio' => $dto->bio,
            ]);
        }
        if (isset($data['national_id'])) {
            $user->teacher()->update([
                'national_id' => $dto->national_id,
            ]);
        }
        if(isset($data['avatar'])) {
            $this->updateAvatar($user, $dto->avatar);
        }
    }
    private function updateAvatar(User $user, UploadedFile $avatar): void
    {
        $this->imageManager->delete($user->avatar);

        $avatarPath = $this->imageManager->upload(
            $avatar,
            "avatars/{$user->id}"
        );

        $user->profile()->update(['avatar' => $avatarPath]);
    }

}
