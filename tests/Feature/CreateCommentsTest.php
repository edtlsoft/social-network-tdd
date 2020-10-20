<?php

namespace Tests\Feature;

use App\Events\CommentCreated;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Status;
use App\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_comment_statuses()
    {
        // Given
        $comment = ['body' => 'My first comment'];
        $status  = factory(Status::class)->create();
        $user    = factory(User::class)->create();

        $this->actingAs($user);

        // When
        $response = $this->postJson(route('statuses.comments.store', $status), $comment);

        $response->assertJson([
            'data' => ['body' => $comment['body']]
        ]);

        // Then
        $this->assertDatabaseHas('comments', [
            'user_id'   => $user->id,
            'status_id' => $status->id,
            'body'      => $comment['body'],
        ]);
    }

    /**
     * @test
     */
    public function an_event_is_fired_when_comment_is_created()
    {
        Event::fake([CommentCreated::class]);
        Broadcast::shouldReceive('socket')->andReturn('socket-id');

        // 1. Given => Given a authenticated user
        $comment = ['body' => 'My first comment'];
        $status  = factory(Status::class)->create();
        $user    = factory(User::class)->create();

        // 2. When  => When you make a post request to status
        $response = $this->actingAs($user)->postJson(route('statuses.comments.store', $status), $comment);

        // 3. Then
        // Assert Event was dispatched
        Event::assertDispatched(CommentCreated::class, function($CommentCratedEvent) {
            $this->assertInstanceOf(ShouldBroadcast::class, $CommentCratedEvent);
            $this->assertInstanceOf(CommentResource::class, $CommentCratedEvent->comment);
            $this->assertInstanceOf(Comment::class, $CommentCratedEvent->comment->resource);

            $this->assertEquals(Comment::first()->id, $CommentCratedEvent->comment->id);
            $this->assertEquals(
                'socket-id',
                $CommentCratedEvent->socket,
                'The event '. get_class($CommentCratedEvent) .' must call the method "dontBroadcastToCurrentUser" in the constructor'
            );

            return true;
        });
    }

    /** @test */
    public function guest_users_can_not_comment_statuses()
    {
        // Given
        $status  = factory(Status::class)->create();
        $comment = 'My first comment';

        // When
        $response = $this->postJson(route('statuses.comments.store', $status), [
            'body' => $comment,
        ]);

        // Then
        $response->assertStatus(401);
    }

    /** @test */
    public function a_comment_requires_a_body()
    {
        // Given
        $this->actingAs(factory(User::class)->create());

        $status  = factory(Status::class)->create();

        // When
        $response = $this->postJson(route('statuses.comments.store', $status), [
            'body' => '',
        ]);

        // Then
        $response->assertStatus(422);
    }
}
