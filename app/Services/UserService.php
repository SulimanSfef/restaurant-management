<?php
// app/Services/UserService.php
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }


    public function changeUserRole(int $userId, string $role)
    {
        $validRoles = ['admin', 'waiter', 'cashier', 'chef', 'client'];

        if (!in_array($role, $validRoles)) {
            throw ValidationException::withMessages(['role' => 'Invalid role provided.']);
        }

        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw ValidationException::withMessages(['user' => 'User not found.']);
        }

        return $this->userRepository->updateRole($user, $role);
    }
}

