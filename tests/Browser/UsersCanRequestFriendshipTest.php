<?php

namespace Tests\Browser;

use App\Models\Friendship;
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
    public function guests_cannot_create_friendship_requests()
    {
        $recipient = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ( $recipient) {
            $browser->visit(route('users.show', $recipient))
                ->assertSee($recipient->username)
                ->press('@request-friendship')
                ->assertPathIs('/login');
        });
    }

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
                ->assertSee($sender->username)
                ->press('@request-friendship')
                ->waitForText('Cancel')
                ->assertSee('Cancel')
                ->visit(route('users.show', $recipient))
                ->assertSee('Cancel')
                ->press('@request-friendship')
                ->waitForText('Add friend', 10)
                ->assertSee('Add friend');
        });
    }

    /** @test
     * @throws Throwable
     */
    public function a_user_cannot_send_friendship_requests_to_itself()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(route('users.show', $user))
                ->assertSee($user->username)
                ->assertMissing('@request-friendship')
                ->assertSee("It's you");
        });
    }

    /** @test
     * @throws Throwable
     */
    public function senders_can_delete_accepted_friendship_requests()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'accepted'
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->assertSee($sender->username)
                ->press('@request-friendship')
                ->waitForText('Add friend')
                ->assertSee('Add friend')
                ->visit(route('users.show', $recipient))
                ->assertSee('Add friend');
        });
    }

    /** @test
     * @throws Throwable
     */
    public function senders_cannot_delete_deny_friendship_requests()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'denied'
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                ->visit(route('users.show', $recipient))
                ->assertSee($sender->username)
                ->assertSee('Request denied')
                ->press('@request-friendship')
                ->assertSee('Request denied')
                ->visit(route('users.show', $recipient))
                ->assertSee('Request denied');
        });
    }

    /** @test
     * @throws Throwable
     */
    public function recipients_can_accept_friendship_requests()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendship.index'))
                ->press('@accept-friendship')
                ->waitForText('Friends')
                ->assertSee('Friends')
                ->visit(route('accept-friendship.index'))
                ->assertSee('Friends');
        });
    }

    /** @test
     * @throws Throwable
     */
    public function recipients_can_deny_friendship_requests()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendship.index'))
                ->assertSee($sender->username)
                ->press('@deny-friendship')
                ->waitForText('Request denied')
                ->assertSee('Request denied')
                ->visit(route('accept-friendship.index'))
                ->assertSee('Request denied');
        });
    }

    /** @test
     * @throws Throwable
     */
    public function recipients_can_delete_friendship_requests()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendship.index'))
                ->assertSee($sender->username)
                ->press('@delete-friendship')
                ->waitForText('Request removed')
                ->assertSee('Request removed')
                ->visit(route('accept-friendship.index'))
                ->assertDontSee($sender->username)
                ->assertDontSee('Request removed');
        });
    }
}
