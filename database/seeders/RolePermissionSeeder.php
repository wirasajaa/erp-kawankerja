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
            ['id' => Str::ulid()->toBase32(), 'name' => 'fullstack-webdev', 'guard_name' => 'web'],
            ['id' => Str::ulid()->toBase32(), 'name' => 'frontend-webdev', 'guard_name' => 'web'],
            ['id' => Str::ulid()->toBase32(), 'name' => 'backend-webdev', 'guard_name' => 'web'],
            ['id' => Str::ulid()->toBase32(), 'name' => 'ui/ux', 'guard_name' => 'web'],
            ['id' => Str::ulid()->toBase32(), 'name' => 'system-analys', 'guard_name' => 'web'],
        ]);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(
            'super-admin'
        );

        $hr = Role::findByName('human-resources');
        $hr->givePermissionTo('view-user', 'create-user', 'update-user', 'delete-user', 'detail-user');

        $users = Role::where('name', '!=', 'admin')->orWhere('name', '!=', 'human-resources')->get();
        foreach ($users as $user) {
            $user->givePermissionTo(
                'report-project',
                'view-project',

                'view-meeting',
                'preview-meeting',

                'view-family',
                'create-family',
                'update-family',
                'delete-family',

                'view-education',
                'create-education',
                'update-education',
                'delete-education',

                'view-cartificate',
                'create-cartificate',
                'update-cartificate',
                'delete-cartificate',
            );
        }
    }
}
