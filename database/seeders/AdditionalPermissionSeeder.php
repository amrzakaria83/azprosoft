<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdditionalPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newPermissions = [
            ['name' => 'role delete', 'guard_name' => 'admin'],
            ['name' => 'role new', 'guard_name' => 'admin'],
            ['name' => 'role edit', 'guard_name' => 'admin'],
            ['name' => 'all role', 'guard_name' => 'admin'],
        ];

        foreach ($newPermissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Optionally assign to roles
        if ($role = Role::where('name', 'super admin')->first()) {
            $role->givePermissionTo(collect($newPermissions)->pluck('name')->toArray());
        }
    }
}