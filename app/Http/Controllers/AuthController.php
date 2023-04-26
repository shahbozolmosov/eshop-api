<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        //
    }

    public function login(LoginUserRequest $request, AuthService $authService): JsonResponse
    {
        // Check User Credentials
        $authService->checkCredentials($request);

        //Get Authenticated User
        $user = auth()->user();

        $role = $user->role->name;
        // Create a token by ability
        if ($role === 'admin') $token = $user->createToken($user->name)->plainTextToken;
        else $token = $user->createToken($user->name, ['abilities:customer'])->plainTextToken;

        return $this->return_success([
            'role' => $role,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => ''
        ], 'Login success');
    }

    public function updateUser()
    {
        //
    }

    public function updatePassword()
    {
        //
    }

    public function account(): JsonResponse
    {

        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return $this->return_success('', 'Log out success!');
    }
}
