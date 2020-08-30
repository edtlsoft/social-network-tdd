<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Traits\HasLikesTrait;
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
            User::class,
            $comment->user
        );
    }

    /** @test */
    public function a_comment_model_must_use_the_triat_has_likes_trait()
    {
        $this->assertClassUseTrait(Comment::class, HasLikesTrait::class);
    }
}
