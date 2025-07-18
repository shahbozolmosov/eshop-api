<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::find(2);
        $token = $user->createToken($user->name, ['ability:customer'])->plainTextToken;

        return $this->return_success([
            'role' => $role->name,
            'token' => $token,
        ], 'Register successfully');
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
        else $token = $user->createToken($user->name, ['ability:customer'])->plainTextToken;

        return $this->return_success([
            'role' => $role,
            'token' => $token,
        ], 'Login successfully');
    }

    public function updateUser(UpdateUserRequest $request, AuthService $authService): JsonResponse
    {
        // Check User Credentials
        $authService->checkPassword(auth()->user()->password, $request->password);

        // Update User data
        auth()->user()->update([
            'name' => $request->name,
            'email'=> $request->email,
            'updated_at' => now()
        ]);


        return $this->return_success(
            new UserResource(auth()->user()),
            'Profile updated successfully'
        );
    }

    public function updatePassword(UpdateUserPasswordRequest $request, AuthService $authService): JsonResponse
    {
        // Check User Credentials
        $authService->checkPassword(auth()->user()->password, $request->password);

        // Update User data
        auth()->user()->update([
            'password' => Hash::make($request->new_password),
            'updated_at' => now()
        ]);

        // Remove all access token
        auth()->user()->tokens()->delete();

        return $this->return_success('', 'Profile password updated successfully');
    }

    public function account(): JsonResponse
    {
        return $this->return_success(new UserResource(auth()->user()));
    }

    public function logout(Request $request): JsonResponse
    {
        // Remove user current access token
        $request->user()->currentAccessToken()->delete();
        return $this->return_success('', 'Logout successfully!');
    }
}
