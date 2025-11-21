<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\TeacherRegistrationAction;
use App\DTOs\Auth\TeacherRegistrationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreTeacherRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class TeacherRegistrationController extends Controller
{
    public function __construct(
        private readonly TeacherRegistrationAction $teacherRegistrationAction
    ) {}

    public function registerForm(): View
    {
        return view('pages.auth.teacher-register');
    }

    public function register(StoreTeacherRequest $request): RedirectResponse
    {
        $user = $this->teacherRegistrationAction->execute(TeacherRegistrationDTO::fromArray($request->validated()));
        Auth::login($user);

        return redirect()->route('home')->with('success', 'registered, logged in successfully');
    }
}
