<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\AuthServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class AuthController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $authService) {}

    public function registerForm(): View
    {
        return view('pages.auth.register');
    }

    public function register(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->authService->register(RegisterDTO::fromArray($request->validated()));

        Auth::login($user);

        return redirect()->route('home')->with('success', 'registered, logged in successfully');
    }

    public function loginForm(): View
    {
        return view('pages.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $dto = LoginDTO::fromArray($request->validated());
        try {
            $user = $this->authService->login($dto);
            if ($user->isActive()) {
                Auth::login($user);

                return redirect()->route('home')->with('success', 'logged in successfully');
            }

            return redirect()->route('login')->with('error', 'Login failed');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'logged out successfully');
    }
}
