<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'read roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit companies']);
        Permission::create(['name' => 'delete companies']);
        Permission::create(['name' => 'read companies']);
        Permission::create(['name' => 'create companies']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'visitor']);
        $role1->givePermissionTo('read roles');
        $role1->givePermissionTo('read users');
        $role1->givePermissionTo('read companies');

        $role2 = Role::create(['name' => 'company-admin']);
        // $role2->givePermissionTo('publish articles');
        // $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
            'phone'=> '01XXXXXXXXX',
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role1);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Example Admin User',
        //     'email' => 'admin@example.com',
        // ]);
        // $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
            'phone'=> '01XXXXXXXXY',
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role3);
    }
}
