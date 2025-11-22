<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\UpdateProfileAction;
use App\DTOs\Auth\UpdateProfileDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ProfileController extends Controller
{
    public function index(#[CurrentUser] User $user): View
    {
        $user->loadCount('courses');

        return view('pages.profile', [
            'user' => $user,
        ]);
    }

    public function edit(#[CurrentUser] User $user): View
    {
        return view('pages.update-profile', [
            'user' => $user,
        ]);
    }

    public function update(#[CurrentUser] User $user, UpdateProfileRequest $request, UpdateProfileAction $action): RedirectResponse
    {
        $action->execute($user, $request->validated(), UpdateProfileDTO::fromArray($request->validated()));

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(#[CurrentUser] User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('login')->with('success', 'User has been deleted successfully.');
    }
}
