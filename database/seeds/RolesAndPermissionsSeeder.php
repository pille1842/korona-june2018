<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Korona\User;
use Korona\Member;
use Carbon\Carbon;

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
        $backendManageMembersPermission = Permission::create([
            'name' => 'Kann Mitglieder verwalten',
            'slug' => 'backend.manage.members'
        ]);
        $backendManageRolesPermission = Permission::create([
            'name' => 'Kann Seitenrollen verwalten',
            'slug' => 'backend.manage.roles'
        ]);
        $backendManageSettingsPermission = Permission::create([
            'name' => 'Kann Systemeinstellungen verwalten',
            'slug' => 'backend.manage.settings'
        ]);
        $backendSeeLogsPermission = Permission::create([
            'name' => 'Kann Systemlogs einsehen',
            'slug' => 'backend.see.logs'
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
        $adminRole->attachPermission($backendManageMembersPermission);
        $adminRole->attachPermission($backendManageRolesPermission);
        $adminRole->attachPermission($backendManageSettingsPermission);
        $adminRole->attachPermission($backendSeeLogsPermission);

        // Create the first user to be a superuser
        $user = User::create([
            'login'     => 'Superuser',
            'email'     => 'test@example.com',
            'password'  => Hash::make('12345'),
            'active'    => true
        ]);
        $user->attachRole($superuserRole);

        // Create a member so that the superuser can login
        $member = Member::create([
            'user_id' => $user->id,
            'slug' => 'superuser',
            'nickname' => 'Superuser',
            'firstname' => 'Super',
            'lastname' => 'User',
            'birthday' => Carbon::create(1970, 01, 01),
            'status' => 'AH',
            'active' => true
        ]);
    }
}
