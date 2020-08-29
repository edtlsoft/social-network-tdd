<?php

namespace Tests\Feature;

use App\User;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanLikeCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_like_comments()
    {
        // Given
        $comment = factory(Comment::class)->create();
        $user   = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $response = $this->postJson(route('comments.like.store', $comment));

        // Then
        $this->assertDatabaseHas('likes', [
            'user_id'   => $user->id,
            'status_id' => $comment->id,
        ]);
    }

    /** @test */
    public function guests_user_can_not_like_comments()
    {
        // Given
        $comment = factory(Comment::class)->create();

        // When
        $response = $this->postJson(route('comments.like.store', $comment));

        // Then
        $response->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_unlike_comments()
    {
        $this->withoutExceptionHandling();
        // Given
        $status = factory(Comment::class)->create();
        $user   = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $response = $this->postJson(route('comments.like.store', $status));
        $response = $this->deleteJson(route('comments.like.destroy', $status));

        // Then
        $this->assertDatabaseMissing('likes', [
            'user_id'   => $user->id,
            'status_id' => $status->id,
        ]);
    }
}
