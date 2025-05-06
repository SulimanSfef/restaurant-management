<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\RefreshToken;

class AuthController extends Controller
{
    use ApiResponseTrait;
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());
        return $this->successResponse([
            'user' => $user,
            'token' => $user->createToken('api-token')->plainTextToken
        ], 'User registered successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->successResponse(['token' => $token], 'Login successful',200);
    }

    public function user(Request $request)
    {
        return $this->successResponse($request->user(), 'User fetched successfully');
    }

    public function refreshToken(Request $request)
{
    $request->validate([
        'refresh_token' => 'required'
    ]);

    $hashed = hash('sha256', $request->refresh_token);

    $record = RefreshToken::where('token', $hashed)
        ->where('expires_at', '>', now())
        ->first();

    if (!$record) {
        return $this->errorResponse('Invalid or expired refresh token', 401);
    }

    // إنشاء Access Token جديد
    $accessToken = $record->user->createToken('api-token')->plainTextToken;

    return $this->successResponse([
        'access_token' => $accessToken
    ], 'Access token refreshed');
}

}

