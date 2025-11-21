<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

final class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    public const MIN_VERIFICATION_CODE = 100_000;

    public const MAX_VERIFICATION_CODE = 999_999;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function course(): HasOne
    {
        return $this->hasOne(Course::class);
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->contains(fn ($r): bool => in_array($r->name->value, $roles, true));
    }

    public function isAdmin(): bool
    {
        return $this->roles()->first()?->name->value === Roles::ADMIN->value;
    }

    public function isTeacher(): bool
    {
        return $this->roles()->first()?->name->value === Roles::TEACHER->value && $this->teacher?->is_approved;
    }

    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    public function scopeActiveUsersCount(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeActiveTeachers(Builder $query): Builder
    {
        return $query->whereHas('roles', function (Builder $q): void {
            $q->where('name', Roles::TEACHER->value)
                ->where('is_active', true);
        });
    }

    public function scopeGetUserByEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        if (! $status) {
            return $query;
        }
        if ($status === 'active') {
            return $query->where('is_active', true);
        }
        if ($status === 'inactive') {
            return $query->where('is_active', false);
        }

        return $query;
    }

    public function scopeFilterRole(Builder $query, ?string $role): Builder
    {
        if (! $role) {
            return $query;
        }

        return $query->whereHas('roles', function (Builder $query) use ($role): void {
            $query->where('name', $role);
        });
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'verification_code' => 'string',
        ];
    }
}
