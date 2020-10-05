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
    public function users_can_request_friendship()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->press('@request-friendship')
                ->waitForText('Cancel')
                ->assertSee('Cancel');
        });
    }
}
