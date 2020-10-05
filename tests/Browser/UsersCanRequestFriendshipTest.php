<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class UsersCanRequestFriendshipTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test
     * @throws Throwable
     */
    public function senders_can_create_and_delete_friendship_requests()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->press('@request-friendship')
                ->waitForText('Cancel')
                ->assertSee('Cancel')

                ->visit(route('users.show', $recipient))
                ->assertSee('Cancel')

                ->press('@request-friendship')
                ->waitForText('Add friend')
                ->assertSee('Add friend');
        });
    }
}
