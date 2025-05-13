<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
    public function getAll()
    {
        return User::all();

    }
    public function deleteUser($id)
   {
       $user = User::findOrFail($id);
       return $user->delete();
   }

}