<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('#username', 'EdwardLopez')
                ->type('#first_name', 'Edward')
                ->type('#last_name', 'Lopez')
                ->type('#email', 'edward@edtlsoft.com')
                ->type('#password', '12345678')
                ->type('#password_confirmation', '12345678')
                ->press('@register-btn')
                ->assertPathIs('/')
                ->assertAuthenticated()
                ;
        });
    }

    /** @test */
    public function users_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('#username', 'Ana')
                ->type('#first_name', 'Edward')
                ->type('#last_name', 'Lopez')
                ->type('#email', 'edward@edtlsoft.com')
                ->type('#password', '12345678')
                ->type('#password_confirmation', '12345678')
                ->press('@register-btn')
                ->assertPathIs('/register')
                ->waitForText('The username must be at least 5 characters.')
                ->assertSee('The username must be at least 5 characters.')
            ;
        });
    }
}
