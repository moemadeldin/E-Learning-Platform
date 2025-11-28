<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

final class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = $this->promptUserData();

        $roleName = $this->choice('Role of the new user', array_map(
            fn ($role): string => $role->value, Roles::cases()
        ), 1);
        $this->info("DEBUG: Role selected: $roleName");

        $this->validateUserData($user);

        $role = Role::where('name', $roleName)->firstOrFail();

        $teacher = [];

        if ($roleName === Roles::TEACHER->value) {
            $teacher = $this->promptTeacherData();
            $this->validateTeacherData($teacher);
        }
        DB::transaction(function () use ($user, $role, $roleName, $teacher): void {
            $newUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            $newUser->roles()->attach($role->id);
            if ($roleName === Roles::TEACHER->value) {
                $newUser->teacher()->create([
                    'national_id' => $teacher['national_id'],
                    'category_id' => $teacher['category_id'],
                    'title' => $teacher['title'],
                    'is_approved' => true,
                    'is_active' => true,
                    'hire_date' => now(),
                ]);
                $newUser->profile()->create([
                    'first_name' => $teacher['first_name'],
                    'last_name' => $teacher['last_name'],
                ]);
            }
            if ($roleName === Roles::USER->value) {
                $newUser->profile()->create();
            }

        });
        $this->info('User '.$user['email'].' created successfully');
    }

    private function promptUserData(): array
    {
        return [
            'name' => $this->ask('Name of the new user?'),
            'email' => $this->ask('Email of the new user?'),
            'password' => $this->secret('Password of the new user?'),
        ];
    }

    private function promptTeacherData(): array
    {
        $categories = Category::getCategoriesById()->get();
        $categoryNames = $categories->pluck('name')->toArray();
        $categoryIds = $categories->pluck('id')->toArray();
        $selectedIndex = $this->choice('Which Category?', $categoryNames);
        $selectedCategoryId = $categoryIds[array_search($selectedIndex, $categoryNames)];
        $teacher = [
            'first_name' => $this->ask('First name?'),
            'last_name' => $this->ask('Last name?'),
            'national_id' => $this->ask('National ID?'),
            'category_id' => $selectedCategoryId,
            'title' => $this->ask('Title?'),
        ];

        return $teacher;
    }

    private function validateUserData(array $data): void
    {
        Validator::make($data, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:15'],
        ])->validate();
    }

    private function validateTeacherData(array $data): void
    {
        Validator::make($data, [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'national_id' => ['required', 'digits:14'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string'],
        ])->validate();
    }
}
