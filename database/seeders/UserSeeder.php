<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $adminRole = Role::first();
        $admin = User::create([
            'id' => Str::ulid()->toBase32(),
            'username' => 'MR.Admin',
            // 'role_id' => $adminRole->id,
            'email' => "admin@exm.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        $admin = User::create([
            'id' => Str::ulid()->toBase32(),
            'username' => 'MR.HumanResources',
            // 'role_id' => $adminRole->id,
            'email' => "hr@exm.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('human-resources');
    }
}
