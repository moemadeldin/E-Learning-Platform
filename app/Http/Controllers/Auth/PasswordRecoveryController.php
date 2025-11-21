<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\ForgotPasswordDTO;
use App\DTOs\Auth\ResetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Interfaces\PasswordRecoveryServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

final class PasswordRecoveryController extends Controller
{
    public function __construct(
        private readonly PasswordRecoveryServiceInterface $passwordRecoveryService
    ) {}

    public function forgotPasswordForm(): View
    {
        return view('pages.auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordRequest $request): RedirectResponse
    {
        $this->passwordRecoveryService->forgotPassword(ForgotPasswordDTO::fromArray($request->validated()));

        return redirect()->route('login')->with('success', 'Check your mail for reset');
    }

    public function resetPasswordForm(Request $request): View
    {
        return view('pages.auth.reset-password', [
            'email' => Crypt::decrypt($request->query('email')),
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $this->passwordRecoveryService->resetPassword(ResetPasswordDTO::fromArray($request->validated()));

        return redirect()->route('login')->with('success', 'Successfully Recovered, You may now log in.');
    }
}
