<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create Roles
        $roleAdmin = Role::create(['name' => 'Admin']);

        //Create Permissions
        $PermissionDelAnyArticle = Permission::create(['name' => 'delete any article']);

        //Assign a Permission to a Role
        $roleAdmin->givePermissionTo($PermissionDelAnyArticle);
    }
}
