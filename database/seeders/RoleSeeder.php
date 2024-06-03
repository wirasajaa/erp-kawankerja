<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'id' => Str::ulid()->toBase32(),
                'name' => "Admin",
                'slug' => Str::slug('admin'),
                'description' => "Mengelola seluruh data yang sudah dihapus secara tidak langsung, dan mengelola data lainnya secara leluasa"

            ]
        ]);
    }
}
