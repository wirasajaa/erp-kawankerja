<?php

namespace Database\Seeders;

use App\Models\Employee;
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
        $admin = User::create([
            'id' => Str::ulid()->toBase32(),
            'username' => 'MR.Admin',
            'email' => "admin@exm.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        $employee = Employee::factory()->count(1)->create();
        $admin->update(['employee_id' => $employee->first()->id,]);

        $employee = Employee::factory()->count(1)->create();
        $admin = User::create([
            'id' => Str::ulid()->toBase32(),
            'username' => 'MR.HumanResources',
            'employee_id' => $employee->first()->id,
            'email' => "hr@exm.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('human-resources');
    }
}
