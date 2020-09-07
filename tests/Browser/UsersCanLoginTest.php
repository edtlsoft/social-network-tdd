<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class UsersCanLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws Throwable
     */
    public function registered_users_can_login()
    {
        $user = factory(User::class)->create(['email' => 'edward@edtlsoft.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'edward@edtlsoft.com')
                ->type('password', 'password')
                ->press('@login-btn')
                ->assertPathIs('/')
                ->assertAuthenticated();
        });
    }

    /** @test */
    public function users_cannot_login_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'email@email')
                ->type('password', 'password')
                ->press('@login-btn')
                ->assertPathIs('/login')
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.')
            ;
        });
    }
}
