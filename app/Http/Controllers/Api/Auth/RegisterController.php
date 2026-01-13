<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Services\SqidsService;

class RegisterController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function __invoke(RegisterRequest $request, SqidsService $sqids)
    {
        $user = $this->authService->register($request->validated());

        $encoded = $sqids->rec_encode_ids_in_list($user);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data'    => $encoded,
        ], 201);
    }
}
