<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that creating a member really inserts it into the database.
     *
     * @return void
     */
    public function testCreatedMemberAppearsInDatabase()
    {
        $member = factory(Korona\Member::class)->create();

        $this->seeInDatabase('members', [
            'slug' => $member->slug,
            'nickname' => $member->nickname,
            'firstname' => $member->firstname,
            'lastname' => $member->lastname,
            'birthname' => $member->birthname,
            'title' => $member->title,
            'profession' => $member->profession,
            'birthday' => $member->birthday->format('Y-m-d'),
            'status' => $member->status,
            'active' => true
        ]);
    }

    /**
     * Test that the member's date fields are correctly initialized and instances
     * of Carbon.
     *
     * @return void
     */
    public function testUserDatesAreInitializedAndCarbonInstances()
    {
        $member = factory(Korona\Member::class)->create();

        $this->assertInstanceOf(Carbon\Carbon::class, $member->created_at);
        $this->assertInstanceOf(Carbon\Carbon::class, $member->updated_at);
        $this->assertInstanceOf(Carbon\Carbon::class, $member->birthday);
    }

    /**
     * Test that soft-deleting members works and correctly initializes the
     * deleted_at field.
     *
     * @return void
     */
    public function testSoftDeletingTrashesMemberAndSetsDeletedDate()
    {
        $member = factory(Korona\Member::class)->create();
        $member->delete();

        $this->assertEquals(true, $member->trashed());
        $this->assertInstanceOf(Carbon\Carbon::class, $member->deleted_at);
    }

    /**
     * Test that restoring a soft-deleted member untrashes it and resets the
     * deleted_at field.
     *
     * @return void
     */
    public function testRestoringSoftDeletedUserUntrashesAndResetsDeletedDate()
    {
        $member = factory(Korona\Member::class)->create();
        $member->delete();
        $member->restore();

        $this->assertEquals(false, $member->trashed());
        $this->assertEquals(null, $member->deleted_at);
    }

    /**
     * Test that force-deleting a member removes it from the database.
     *
     * @return void
     */
    public function testForceDeletingUserRemovesItFromDatabase()
    {
        $member = factory(Korona\Member::class)->create();
        $member->forceDelete();

        $this->dontSeeInDatabase('members', [
            'slug' => $member->slug,
            'nickname' => $member->nickname,
            'firstname' => $member->firstname,
            'lastname' => $member->lastname,
            'birthname' => $member->birthname,
            'title' => $member->title,
            'profession' => $member->profession,
            'birthday' => $member->birthday,
            'status' => $member->status,
            'active' => $member->active
        ]);
    }
}
