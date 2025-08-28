<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * حذف مستخدم باستخدام الـ ID
     */
    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }

    /**
     * تغيير الدور للمستخدم
     */
    public function changeUserRole(int $userId, string $role)
    {
        $validRoles = ['admin', 'waiter', 'cashier', 'chef', 'client'];

        if (!in_array($role, $validRoles)) {
            throw ValidationException::withMessages([
                'role' => 'Invalid role provided.',
            ]);
        }

        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw ValidationException::withMessages([
                'user' => 'User not found.',
            ]);
        }

        return $this->userRepository->updateRole($user, $role);
    }

    /**
     * تعديل معلومات المستخدم (الاسم، البريد، كلمة المرور، الصورة الشخصية)
     */
    public function updateProfile($id, array $data)
    {
        // جلب المستخدم من الريبو
        $user = $this->userRepository->findById($id);

        // تحديث كلمة المرور إن وُجدت
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // تحديث الصورة الشخصية إن وُجدت
        if (isset($data['profile_image'])) {
            // حذف الصورة القديمة إن كانت موجودة
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // رفع الصورة الجديدة
            $path = $data['profile_image']->store('profile_images', 'public');
            $data['profile_image'] = $path;
        }

        // التحديث في قاعدة البيانات عبر الريبو
        return $this->userRepository->updateUser($id, $data);
    }
}
