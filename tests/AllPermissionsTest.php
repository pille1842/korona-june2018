<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AllPermissionsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that an authenticated user with no additional permissions cannot
     * see a link to the backend.
     *
     * @return void
     */
    public function testUserCannotSeeBackendLink()
    {
        $user = factory(Korona\User::class)->create([
            'password' => bcrypt('12345')
        ]);

        $this->actingAs($user)
             ->visit('home')
             ->dontSee(trans('internal.go_to_backend'));
    }

    /**
     * Test that an authenticated user with permission access.backend can see
     * a link to the backend on an internal route.
     *
     * @return void
     */
    public function testAdminUserSeesBackendLink()
    {
        $user = factory(Korona\User::class)->create([
            'password' => bcrypt('12345')
        ]);

        $permission = Bican\Roles\Models\Permission::create([
            'name' => 'Backend Access',
            'slug' => 'access.backend'
        ]);

        $user->attachPermission($permission);

        // Get user fresh from the database to avoid cached permissions
        $user = Korona\User::first();

        $this->actingAs($user)
             ->visit('home')
             ->see(trans('internal.go_to_backend'));
    }

    /**
     * Test that an authenticated user with permission access.backend can
     * actually go to the backend.
     *
     * @return void
     */
    public function testAdminUserCanVisitBackend()
    {
        $user = factory(Korona\User::class)->create([
            'password' => bcrypt('12345')
        ]);

        $permission = Bican\Roles\Models\Permission::create([
            'name' => 'Backend Access',
            'slug' => 'access.backend'
        ]);

        $user->attachPermission($permission);

        // Get user fresh from the database to avoid cached permissions
        $user = Korona\User::first();

        $this->actingAs($user)
             ->visit('backend')
             ->seePageIs('backend');
    }
}
