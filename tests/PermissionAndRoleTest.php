<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;

class PermissionAndRoleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that a permission actually appears in the database.
     *
     * @return void
     */
    public function testCreatedPermissionsAndRolesAppearInDatabase()
    {
        $permission = factory(Bican\Roles\Models\Permission::class)->create();
        $role = factory(Bican\Roles\Models\Role::class)->create();

        $this->seeInDatabase('permissions', [
            'name' => $permission->name,
            'slug' => $permission->slug,
            'description' => $permission->description
        ]);
        $this->seeInDatabase('roles', [
            'name' => $role->name,
            'slug' => $role->slug,
            'description' => $role->description,
            'level' => $role->level
        ]);
    }

    /**
     * Test that a user has all permissions attached to a role
     *
     * @return void
     */
    public function testPermissionsAttachedToRoleAreEffective()
    {
        $role        = factory(Bican\Roles\Models\Role::class)->create();
        $permissions = factory(Bican\Roles\Models\Permission::class, 10)->create();
        $user        = factory(Korona\User::class)->create();

        foreach ($permissions as $permission) {
            $role->attachPermission($permission);
        }

        $user->attachRole($role);

        // Start fresh from the database because permissions are cached like hell
        $user        = Korona\User::first();
        $role        = Bican\Roles\Models\Role::first();
        $permissions = Bican\Roles\Models\Permission::all();

        $this->assertTrue($user->is($role->slug));

        $permissionString = '';
        foreach ($permissions as $permission) {
            $this->assertTrue($user->can($permission->slug));
            $permissionString .= $permission->slug . '|';
        }

        // Also test that we can use a |-separated string of all permissions
        // to see if the user has them
        $permissionString = trim($permissionString, '|');
        $this->assertTrue($user->can($permissionString, true));
    }
}
