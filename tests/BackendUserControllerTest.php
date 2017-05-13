<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BackendUserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that there is a button in the index view which, when clicked,
     * brings the user to the creation form.
     *
     * @return void
     */
    public function testClickingOnButtonToCreateNewUserDisplaysForm()
    {
        $this->createUserWithPermission();
        $user = Korona\User::first();

        $this->actingAs($user)
             ->visit('backend/user')
             ->click('btn-create-user')
             ->seePageIs('backend/user/create');
    }

    /**
     * Test the creation form with some example data and verify that the
     * user actually appears in the database.
     *
     * @return void
     */
    public function testCreatedUserAppearsInDatabase()
    {
        $this->expectsEvents(Korona\Events\UserCreated::class);

        $this->createUserWithPermission();
        $user = Korona\User::first();

        $this->actingAs($user)
             ->visit('backend/user/create')
             ->type('John Doe', 'login')
             ->type('test@example.com', 'email')
             ->type('12345678', 'password')
             ->type('12345678', 'password_confirmation')
             ->uncheck('send_newaccount_email')
             ->press(trans('backend.save'));

        $this->seeInDatabase('users', [
            'login' => 'John Doe',
            'email' => 'test@example.com',
            'active' => true,
            'force_password_change' => true
        ]);
    }

    /**
     * Create a user with all the necessary permissions to manage users in the
     * backend (namely, access.backend and backend.manage.users).
     *
     * @return void
     */
    private function createUserWithPermission()
    {
        $user = factory(Korona\User::class)->create();

        $member = factory(Korona\Member::class)->create();

        $member->user()->associate($user);

        $member->save();

        $backendPermission = Bican\Roles\Models\Permission::create([
            'name' => 'Backend Access',
            'slug' => 'access.backend'
        ]);

        $manageUsersPermission = Bican\Roles\Models\Permission::create([
            'name' => 'Manage Users',
            'slug' => 'backend.manage.users'
        ]);

        $user->attachPermission($backendPermission);
        $user->attachPermission($manageUsersPermission);
    }
}
