<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Enums\Roles;
use App\Interfaces\AuthServiceInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class AuthService implements AuthServiceInterface
{
    public function register(RegisterDTO $dto): User
    {
        return DB::transaction(function () use ($dto): User {
            $user = User::create($dto->toArray());

            $roleId = Role::roleByName(Roles::USER->value)->value('id');
            $user->roles()->attach($roleId);

            return $user;
        });
    }

    public function login(LoginDTO $dto): User|bool
    {
        $user = User::getUserByEmail($dto->email)->first();

        if (! Hash::check($dto->password, $user->password)) {
            return false;
        }
        if (! $user->isActive()) {
            return false;
        }

        return $user;
    }
}
