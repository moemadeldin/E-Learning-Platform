<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UpdateProfileAction;
use App\DTOs\Auth\UpdateProfileDTO;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ProfileController extends Controller
{
    public function index(): View
    {
        return view('pages.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function edit(): View
    {
        return view('pages.update-profile', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request, UpdateProfileAction $action): RedirectResponse
    {
        $action->execute(auth()->user(), $request->validated(), UpdateProfileDTO::fromArray($request->validated()));

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(): RedirectResponse
    {
        auth()->user()->delete();

        return redirect()->route('login')->with('success', 'User has been deleted successfully.');
    }
}
