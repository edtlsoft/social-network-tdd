<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
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
}
