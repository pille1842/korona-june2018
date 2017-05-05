<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that creating a user really inserts it into the database.
     *
     * @return void
     */
    public function testCreatedUserAppearsInDatabase()
    {
        $user = factory(Korona\User::class)->create();

        $this->seeInDatabase('users', [
            'login' => $user->login,
            'email' => $user->email,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
            'active' => true,
            'force_password_change' => false
        ]);
    }

    /**
     * Test that the user's date fields are correctly initialized and instances
     * of Carbon.
     *
     * @return void
     */
    public function testUserDatesAreInitializedAndCarbonInstances()
    {
        $user = factory(Korona\User::class)->create();

        $this->assertInstanceOf(Carbon\Carbon::class, $user->created_at);
        $this->assertInstanceOf(Carbon\Carbon::class, $user->updated_at);
    }

    /**
     * Test that soft-deleting users works and correctly initializes the
     * deleted_at field.
     *
     * @return void
     */
    public function testSoftDeletingTrashesUserAndSetsDeletedDate()
    {
        $user = factory(Korona\User::class)->create();
        $user->delete();

        $this->assertEquals(true, $user->trashed());
        $this->assertInstanceOf(Carbon\Carbon::class, $user->deleted_at);
    }

    /**
     * Test that restoring a soft-deleted user untrashes it and resets the
     * deleted_at field.
     *
     * @return void
     */
    public function testRestoringSoftDeletedUserUntrashesAndResetsDeletedDate()
    {
        $user = factory(Korona\User::class)->create();
        $user->delete();
        $user->restore();

        $this->assertEquals(false, $user->trashed());
        $this->assertEquals(null, $user->deleted_at);
    }

    /**
     * Test that force-deleting a user removes it from the database.
     *
     * @return void
     */
    public function testForceDeletingUserRemovesItFromDatabase()
    {
        $user = factory(Korona\User::class)->create();
        $user->forceDelete();

        $this->dontSeeInDatabase('users', [
            'login' => $user->login,
            'email' => $user->email,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
            'active' => true,
            'force_password_change' => false
        ]);
    }
}
