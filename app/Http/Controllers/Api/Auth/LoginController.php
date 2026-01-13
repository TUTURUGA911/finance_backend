<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Services\SqidsService;

class LoginController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function __invoke(LoginRequest $request, SqidsService $sqids)
    {
        $result = $this->authService->login($request->validated());

        $encodedUser = $sqids->rec_encode_ids_in_list($result['user']);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $encodedUser,
                'token' => $result['token'],
                'token_type' => 'Bearer',
            ],
        ]);
    }
}
