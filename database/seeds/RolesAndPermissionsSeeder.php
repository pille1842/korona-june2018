<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Korona\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create all necessary permissions
        $accessBackendPermission = Permission::create([
            'name' => 'Kann auf das Backend zugreifen',
            'slug' => 'access.backend'
        ]);
        $backendManageUsersPermission = Permission::create([
            'name' => 'Kann Benutzerzugänge verwalten',
            'slug' => 'backend.manage.users'
        ]);

        // Create some pre-defined sensible roles
        $memberRole = Role::create([
            'name'        => 'Mitglied',
            'slug'        => 'member',
            'description' => 'Verbindungsmitglied',
            'level'       => 1
        ]);
        $adminRole = Role::create([
            'name'        => 'Administrator',
            'slug'        => 'admin',
            'description' => 'Benutzer mit (fast) allen Rechten',
            'level'       => 5
        ]);
        $superuserRole = Role::create([
            'name'        => 'Superuser',
            'slug'        => 'root',
            'description' => 'Benutzer mit allen Rechten',
            'level'       => 10
        ]);

        // Attach permissions to roles
        $adminRole->attachPermission($accessBackendPermission);
        $adminRole->attachPermission($backendManageUsersPermission);

        // Create the first user to be a superuser
        $user = User::create([
            'login'     => 'Superuser',
            'email'     => 'test@example.com',
            'password'  => Hash::make('12345'),
            'firstname' => 'Max',
            'lastname'  => 'Mustermann',
            'active'    => true,
            'slug'      => 'superuser'
        ]);
        $user->attachRole($superuserRole);
    }
}
