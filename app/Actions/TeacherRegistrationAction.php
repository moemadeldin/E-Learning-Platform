<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\Auth\TeacherRegistrationDTO;
use App\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class TeacherRegistrationAction
{
    public function execute(TeacherRegistrationDTO $dto): User
    {
        return DB::transaction(function () use ($dto): User {
            $user = User::create($dto->toArray());
            $user->teacher()->create($dto->toArray());

            $roleId = Role::roleByName(Roles::TEACHER->value)->value('id');
            $user->roles()->attach($roleId);
            $user->profile()->create([
                'first_name' => $dto->first_name,
                'last_name' => $dto->last_name,
            ]);

            return $user;
        });
    }
}
