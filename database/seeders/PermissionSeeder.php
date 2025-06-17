<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
    
        $arrayOfPermission = [
            'administrators',
            'sales',
            'bill_of_sale',
            'setting' 
        ];

        $permissions = collect($arrayOfPermission)->map(function ($permission){
            return ['name' => $permission, 'guard_name' => 'admin'];
        });

        Permission::insert($permissions->toArray());

        $role = Role::create([
            'name' => 'super admin',
            'guard_name' => 'admin'
        ])->givePermissionTo($arrayOfPermission);
    }
}
