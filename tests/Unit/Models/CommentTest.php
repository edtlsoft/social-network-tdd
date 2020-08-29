<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Like;
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
}
