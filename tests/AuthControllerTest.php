<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that a guest cannot access the internal area and gets redirected
     * to the login page if he tries to go to an internal route.
     *
     * @return void
     */
    public function testGuestAccessToInternalRoutesIsRedirectedToLogin()
    {
        $response = $this->call('GET', 'home');

        $this->assertRedirectedTo('login');
    }

    /**
     * Test that a guest cannot access the backend and gets an error message
     * when he tries to go to a backend route.
     *
     * @return void
     */
    public function testGuestAccessToBackendGetsErrorMessage()
    {
        $this->visit('backend')
             ->see(trans('auth.permission_denied'));
    }

    /**
     * Test that a failed login attempt shows the login form with an error
     * message.
     *
     * @return void
     */
    public function testFailedLoginAttemptShowsLoginFormAndErrorMessage()
    {
        $user = factory(Korona\User::class)->create([
            'password' => bcrypt('12345')
        ]);

        $member = factory(Korona\Member::class)->create();

        $member->user()->associate($user);

        $member->save();

        $this->visit('login')
             ->type($user->login, 'login')
             ->type('abcde', 'password')
             ->press(trans('auth.login'))
             ->seePageIs('login')
             ->see(trans('auth.failed'));
    }

    /**
     * Test that a successfully authenticated user gets redirected to the
     * home page.
     *
     * @return void
     */
    public function testUserGetsRedirectedToHomeAfterLogin()
    {
        $user = factory(Korona\User::class)->create([
            'password' => bcrypt('12345')
        ]);

        $member = factory(Korona\Member::class)->create();

        $member->user()->associate($user);

        $member->save();

        $this->visit('login')
             ->type($user->login, 'login')
             ->type('12345', 'password')
             ->press(trans('auth.login'))
             ->seePageIs('home');
    }

    /**
     * Test that the username (login) is case-insensitive and still allows
     * logging in.
     *
     * @return void
     */
    public function testUsernameIsCaseInsensitive()
    {
        $user = factory(Korona\User::class)->create([
            'password' => bcrypt('12345')
        ]);

        $member = factory(Korona\Member::class)->create();

        $member->user()->associate($user);

        $member->save();

        $this->visit('login')
             ->type(strtoupper($user->login), 'login')
             ->type('12345', 'password')
             ->press(trans('auth.login'))
             ->seePageIs('home');
    }

    /**
     * Test that logging out the authenticated user redirects him to the
     * index page.
     *
     * @return void
     */
    public function testLogoutLinkRedirectsToIndex()
    {
        $user = factory(Korona\User::class)->create([
            'password' => bcrypt('12345')
        ]);

        $member = factory(Korona\Member::class)->create();

        $member->user()->associate($user);

        $member->save();

        $this->actingAs($user)
             ->visit('home')
             ->click(trans('internal.logout'))
             ->seePageIs('/');
    }
}
