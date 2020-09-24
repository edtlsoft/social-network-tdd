<?php

namespace Tests\Feature;

use App\Models\Friendship;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanRequestFriendshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_send_friendship_request()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $this->actingAs($sender)->postJson(route('friendship.store', $recipient));

        $this->assertDatabaseHas('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'pending',
        ]);
    }

    /** @test */
    public function can_delete_friendship_request()
    {
        $this->withoutExceptionHandling();

        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->actingAs($sender)->deleteJson(route('friendship.destroy', $recipient));

        $this->assertDatabaseMissing('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'accepted'     => false,
        ]);
    }

    /** @test */
    public function can_accept_friendship_request()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->actingAs($recipient)->postJson(route('accept-friendship.store', $sender));

        $this->assertDatabaseHas('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'accepted',
        ]);
    }

    /** @test */
    public function can_deny_friendship_request()
    {
        $this->withoutExceptionHandling();

        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->actingAs($recipient)->deleteJson(route('accept-friendship.destroy', $sender));

        $this->assertDatabaseHas('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'denied',
        ]);
    }
}
