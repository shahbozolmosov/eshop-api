<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function checkCredentials($request): void
    {
        $credentials = $request->only(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            abort(422, 'The provided credentials are incorrect.');
        }
    }

    public function checkPassword($currentPassword, $requestPassword): void
    {
        if (!Hash::check($requestPassword, $currentPassword)) {
            throw ValidationException::withMessages([
                "password"=>'The provided password is incorrect'
            ]);
        }
    }
}
