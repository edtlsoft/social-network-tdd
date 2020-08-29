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
    public function an_authenticated_user_can_like_and_unlike_comments()
    {
        $this->withoutExceptionHandling();
        // Given
        $comment = factory(Comment::class)->create();
        $user    = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $response = $this->postJson(route('comments.like.store', $comment));

        // Then
        $this->assertCount(1, $comment->fresh()->likes);
        $this->assertDatabaseHas('likes', ['user_id' => $user->id]);

        // When
        $response = $this->deleteJson(route('comments.like.destroy', $comment));

        // Then
        $this->assertCount(0, $comment->fresh()->likes);
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id]);
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
}
