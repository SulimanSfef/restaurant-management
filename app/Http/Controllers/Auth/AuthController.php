<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgetRequest;
use App\Http\Requests\ForgetRequest;
use App\Models\RefreshToken;
use Illuminate\Support\Facades\Password;

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
        $data = $this->authService->login($request->validated());

        if (!$data) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->successResponse($data, 'Login successful',200);
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

public function logout(Request $request)
{
    // حذف التوكن الحالي من العميل
    $request->user()->tokens->each(function ($token) {
        $token->delete();
    });

    return $this->successResponse(null, 'User logged out successfully');
}



//////////////////////////////////////////////////////////////




public function forgotPassword(ForgetRequest $request)
{

    // إرسال رابط إعادة تعيين كلمة المرور
    $status = Password::sendResetLink(
        $request->validated()->only('email')
    );

    // إذا كانت العملية ناجحة
    if ($status == Password::RESET_LINK_SENT) {
        return $this->successResponse(null, 'Reset password link sent to your email');
    }

    // في حالة فشل العملية
    return $this->errorResponse('Failed to send reset password link', 400);
}





////////              /////////////////

public function resetPassword(Request $request)
{
    // التحقق من صحة البيانات المدخلة
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
        'token' => 'required', // التوكن الذي تم إرساله للبريد الإلكتروني
    ]);

    // إعادة تعيين كلمة المرور باستخدام التوكن والبريد الإلكتروني
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    // إذا كانت العملية ناجحة
    if ($status == Password::PASSWORD_RESET) {
        return $this->successResponse(null, 'Password has been reset successfully');
    }

    // في حالة فشل العملية
    return $this->errorResponse('Failed to reset password', 400);
}



}

