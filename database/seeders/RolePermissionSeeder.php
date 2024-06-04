<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = config('authorization.permissions');
        $new_permission = [];
        foreach ($permissions as $key => $value) {
            $value['id'] = Str::ulid()->toBase32();
            $value['guard_name'] = 'web';
            array_push($new_permission, $value);
        }
        Permission::insert($new_permission);
        Role::insert([
            ['id' => Str::ulid()->toBase32(), 'name' => 'admin', 'guard_name' => 'web'],
            ['id' => Str::ulid()->toBase32(), 'name' => 'human-resources', 'guard_name' => 'web'],
        ]);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('view-user', 'create-user', 'update-user', 'delete-user', 'detail-user', 'delete-permanent-user', 'manage-trash-user');

        $hr = Role::findByName('human-resources');
        $hr->givePermissionTo('view-user', 'create-user', 'update-user', 'delete-user', 'detail-user');
    }
}
