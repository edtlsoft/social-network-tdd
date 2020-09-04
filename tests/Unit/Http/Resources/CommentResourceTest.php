<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_resource_must_have_the_necessary_fields()
    {
        // $this->withoutExceptionHandling();
        // Given
        $comment = factory(Comment::class)->create();

        // When
        $commentResource = CommentResource::make($comment)->resolve();

        // Then
        $this->assertEquals(
            $comment->id,
            $commentResource['id']
        );

        $this->assertEquals(
            $comment->body,
            $commentResource['body']
        );

        $this->assertEquals(
            $comment->user->name,
            $commentResource['user_name']
        );

        $this->assertEquals(
            $comment->user->avatar(),
            $commentResource['user_avatar']
        );

        $this->assertEquals(
            0,
            $commentResource['likes_count']
        );

        $this->assertEquals(
            false,
            $commentResource['is_liked']
        );

        $this->assertEquals(
            route('users.show', $comment->user),
            $commentResource['user_link']
        );

        $this->assertInstanceOf(
            UserResource::class,
            $commentResource['user']
        );
        $this->assertInstanceOf(
            User::class,
            $commentResource['user']->resource
        );
    }
}
