<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CommentResource;
use App\Http\Resources\StatusResource;
use App\Models\Comment;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_status_resource_must_have_the_necessary_fields()
    {
        // $this->withoutExceptionHandling();
        // Given
        $status = factory(Status::class)->create();
        factory(Comment::class, 3)->create(['status_id' => $status->id]);

        // When
        $statusResource = StatusResource::make($status)->resolve();

        // Then
        $this->assertEquals(
            $status->id,
            $statusResource['id']
        );
        $this->assertEquals(
            $status->body,
            $statusResource['body']
        );
        $this->assertEquals(
            $status->user->name,
            $statusResource['user_name']
        );
        $this->assertEquals(
            '/images/default-avatar.jpg',
            $statusResource['user_avatar']
        );
        $this->assertEquals(
            $status->created_at->diffForHumans(),
            $statusResource['ago']
        );
        $this->assertEquals(
           false,
            $statusResource['is_liked']
        );
        $this->assertEquals(
            0,
            $statusResource['likes_count']
        );
        //dd($statusResource['comments']->first()->resource);
        $this->assertEquals(
            CommentResource::class,
            $statusResource['comments']->collects
        );

        $this->assertInstanceOf(
            Comment::class,
            $statusResource['comments']->first()->resource
        );
    }
}
