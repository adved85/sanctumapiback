<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        # -------- permissions ---------
        // category possible permissions
        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'update category']);
        Permission::create(['name' => 'delete category']);

        // workshop possible permissions
        Permission::create(['name' => 'create workshop']);
        Permission::create(['name' => 'update workshop']);
        Permission::create(['name' => 'delete workshop']);

        // courses possible permissions
        Permission::create(['name' => 'create course']);
        Permission::create(['name' => 'update course']);
        Permission::create(['name' => 'delete course']);


        # ------- roles --------
        // 1. $admin->categories
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('create category');
        $admin->givePermissionTo('update category');
        $admin->givePermissionTo('delete category');

        // 1. $coach->workshops
        $coach = Role::create(['name' => 'coach']);
        $coach->givePermissionTo('create workshop');
        $coach->givePermissionTo('update workshop');
        $coach->givePermissionTo('delete workshop');

        // 2. $coach->courses
        $coach->givePermissionTo('create course');
        $coach->givePermissionTo('update course');
        $coach->givePermissionTo('delete course');


        // $student
        $student = Role::create(['name' => 'student']);
    }
}
