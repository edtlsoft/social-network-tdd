<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Like;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_belogns_to_user()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(
            \App\User::class,
            $comment->user
        );
    }

    /** @test */
    public function a_comment_has_many_likes()
    {
        $comment = factory(Comment::class)->create();

        factory(Like::class)->create([
            'likeable_id' => $comment->id,
            'likeable_type' => \get_class($comment)
            ]);

        // Then
        $this->assertInstanceOf(Like::class, $comment->likes->first());
    }

    /** @test */
    public function a_comment_can_be_liked()
    {
        // Given
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();

        // When
        $this->actingAs($user);

        $comment->like();

        // Then
        $this->assertEquals(1, $comment->likes()->count());
    }

    /** @test */
    public function a_status_can_be_liked_once()
    {
        // Given
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $comment->like();

        // Then
        $this->assertEquals(1, $comment->likes()->count());

        // When
        $comment->like();

        // Then
        $this->assertEquals(1, $comment->likes()->count());
    }

    /** @test */
    public function a_status_knows_if_has_been_liked()
    {
        $user    = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->assertFalse($comment->isLiked());

        $this->actingAs($user);

        $comment->like();

        $this->assertTrue($comment->isLiked());
    }

    /** @test */
    public function a_status_can_be_unliked()
    {
        // Given
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $comment->like();
        $comment->unlike();

        // Then
        $this->assertEquals(0, $comment->likes()->count());
    }

    /** @test */
    public function a_status_knows_how_many_likes_it_has()
    {
        // Given
        $comment = factory(Comment::class)->create();

        $this->assertEquals(0, $comment->likesCount());

        factory(Like::class, 2)->create([
            'likeable_id'   => $comment->id,
            'likeable_type' => get_class($comment)
        ]);

        $this->assertEquals(2, $comment->likesCount());
    }
}
