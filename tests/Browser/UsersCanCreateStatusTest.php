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
                ->waitForText('My first status')
                ->assertSee('My first status')
                ->assertSee($user->username)
                ;
        });
    }

    /**
     * @test
     * @throws Throwable
     */
    public function users_can_see_statuses_in_real_time()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($user1, $user2) {
            $browser1->loginAs($user1)->visit('/');

            $browser2->loginAs($user2)
                ->visit('/')
                ->type('#body', 'My first status')
                ->press('#create-status')
                ->waitForText('My first status')
                ->assertSee('My first status')
                ->assertSee($user2->username);

            $browser1->waitForText('My first status')
                ->assertSee('My first status')
                ->assertSee($user2->username);
        });
    }
}
