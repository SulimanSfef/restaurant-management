<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\RefreshToken;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepo->create($data);
    }



    public function login(array $data)
    {
        if (!auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return null;
        }

        $user = auth()->user();
        $accessToken = $user->createToken('api-token')->plainTextToken;

        // إنشاء Refresh Token
        $refreshToken = Str::random(64);
        RefreshToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $refreshToken),
            'expires_at' => Carbon::now()->addDays(30),
        ]);

        return [
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];}



public function sendResetLink(array $data)
{
    $status = Password::sendResetLink([
        'email' => $data['email']
    ]);

    return $status;
}

public function resetPassword(array $data)
{
    $status = Password::reset(
        $data,
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        }
    );

    return $status;
}


public function getAllUsers()
{
    return $this->userRepo->getAll();
}
    }
