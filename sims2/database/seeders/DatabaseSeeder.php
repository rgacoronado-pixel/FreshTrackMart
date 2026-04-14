<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@freshmart.com',
                'password' => 'admin123',
                'role' => 'Admin',
            ],
            [
                'name' => 'staff',
                'email' => 'staff@freshmart.com',
                'password' => 'staff123',
                'role' => 'Staff',
            ],
            [
                'name' => 'jelo',
                'email' => 'jeloveme@gmail.com',
                'password' => '$2y$10$tiLyCN7z5kMY1y0aauGm4uEBBc.hxqcZh6C0A1ESvjTndwrm054F6',
                'role' => 'Staff',
            ],
            [
                'name' => 'jelo1',
                'email' => 'jeloveme@gmail.com',
                'password' => '$2y$10$gRlHmsoKybpfPU2/7.S9We6H5cTpreeKIedvkLQ5u/W4eNgCFn/CO',
                'role' => 'Admin',
            ],
            [
                'name' => 'demo',
                'email' => 'demo@freshmart.com',
                'password' => 'demo123',
                'role' => 'Staff',
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::needsRehash($userData['password']) ? Hash::make($userData['password']) : $userData['password'],
                'role' => $userData['role'],
                'status' => 'active',
            ]);
        }
    }
}
