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
    public function guest_cannot_send_friendship_request()
    {
        $recipient = factory(User::class)->create();

        $response = $this->postJson(route('friendship.store', $recipient));

        $response->assertStatus(401);
    }

    /** @test */
    public function can_send_friendship_request()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $response = $this->actingAs($sender)->postJson(route('friendship.store', $recipient));

        $response->assertJson([
            'friendship_status' => 'pending'
        ]);

        $this->assertDatabaseHas('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'pending',
        ]);

        $this->actingAs($sender)->postJson(route('friendship.store', $recipient));
        $this->assertCount(1, Friendship::all());
    }

    /** @test */
    public function guest_cannot_delete_friendship_request()
    {
        $recipient = factory(User::class)->create();

        $response = $this->deleteJson(route('friendship.destroy', $recipient));

        $response->assertStatus(401);
    }

    /** @test */
    public function senders_can_delete_sent_friendship_request()
    {
        $this->withoutExceptionHandling();

        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $response = $this->actingAs($sender)->deleteJson(route('friendship.destroy', $recipient));

        $response->assertJson([
            'friendship_status' => 'deleted'
        ]);

        $this->assertDatabaseMissing('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'accepted'     => false,
        ]);
    }

    /** @test */
    public function recipients_can_delete_received_friendship_request()
    {
        $this->withoutExceptionHandling();

        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        Friendship::create([
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $response = $this->actingAs($recipient)->deleteJson(route('friendship.destroy', $recipient));

        $response->assertJson(['friendship_status' => 'deleted']);

        $this->assertDatabaseMissing('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'accepted'     => false,
        ]);
    }

    /** @test */
    public function guest_cannot_accept_friendship_request()
    {
        $sender = factory(User::class)->create();

        $response = $this->postJson(route('accept-friendship.store', $sender));

        $response->assertStatus(401);
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

        $response = $this->actingAs($recipient)->postJson(route('accept-friendship.store', $sender));

        $response->assertJson(['friendship_status' => 'accepted']);

        $this->assertDatabaseHas('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'accepted',
        ]);
    }

    /** @test */
    public function guest_cannot_deny_friendship_request()
    {
        $sender = factory(User::class)->create();

        $response = $this->deleteJson(route('accept-friendship.destroy', $sender));

        $response->assertStatus(401);
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

        $response = $this->actingAs($recipient)->deleteJson(route('accept-friendship.destroy', $sender));

        $response->assertJson(['friendship_status' => 'denied']);

        $this->assertDatabaseHas('friendships', [
            'sender_id'    => $sender->id,
            'recipient_id' => $recipient->id,
            'status'       => 'denied',
        ]);
    }
}
