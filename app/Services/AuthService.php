<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * @throws ValidationException
     */
    public function checkCredentials($user, $request): void
    {
        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'The provided credentials are incorrect.'
            ]);
        }
    }
}
