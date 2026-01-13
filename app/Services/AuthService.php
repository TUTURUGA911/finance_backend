<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $data): array
    {
        // login via email
        if (isset($data['email'])) {
            $user = User::where('email', $data['email'])->first();
        }

        // login via decoded user_id
        if (isset($data['user_id'])) {
            $user = User::find($data['user_id']);
        }

        if (!isset($user) || ! $user->password || ! Hash::check($data['password'], $user->password)) {
            throw new \Exception('Invalid credentials');
        }

        // authenticate user for current request (optional)
        Auth::login($user);

        // return both user & token
        return [
            'user' => $user,
            'token' => $user->createToken('api-token')->plainTextToken,
        ];
    }
}
