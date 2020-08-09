<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class LoginTest extends DuskTestCase
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
                ->press('#login-btn')
                ->assertPathIs('/')
                ->assertAuthenticated();
        });
    }
}
