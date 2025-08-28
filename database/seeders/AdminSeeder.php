<?php
namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // تأكد من تغيير كلمة المرور
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'seef',
            'email' => 'seef@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // تأكد من تغيير كلمة المرور
            'role' => 'client'
        ]);
    }
}

