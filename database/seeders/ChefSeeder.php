<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ChefSeeder extends Seeder
{
public function run()
{


     User::create([
            'name' => 'Chef 1',
            'email' => 'Chef1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'), // تأكد من تغيير كلمة المرور
            'role' => 'chef'
        ]);
}

//php artisan db:seed --class=ChefSeeder
}
