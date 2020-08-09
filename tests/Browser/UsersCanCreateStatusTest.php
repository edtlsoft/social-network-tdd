<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class UsersCanCreateStatusTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws Throwable
     */
    public function users_can_create_statuses()
    {
        $user = factory(User::class)->create(['email' => 'edward@edtlsoft.com']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->type('#body', 'My first status')
                ->press('#create-status')
                ->assertSee('My first status');
        });
    }
}
