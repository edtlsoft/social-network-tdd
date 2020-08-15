<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_status_belongs_to_a_user()
    {
        // Given
        $status = factory(Status::class)->create();

        // Then
        $this->assertInstanceOf(User::class, $status->user);
    }

    /** @test */
    public function a_status_has_many_like()
    {
        // Given
        $status = factory(Status::class)->create();

        factory(Like::class)->create(['status_id' => $status->id]);

        // Then
        $this->assertInstanceOf(Like::class, $status->likes->first());
    }

    /** @test */
    public function a_status_can_be_liked()
    {
        // Given
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        // When
        $this->actingAs($user);

        $status->like();

        // Then
        $this->assertEquals(1, $status->likes()->count());
    }

    /** @test */
    public function a_status_can_be_liked_once()
    {
        // Given
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $status->like();

        // Then
        $this->assertEquals(1, $status->likes()->count());

        // When
        $status->like();

        // Then
        $this->assertEquals(1, $status->likes()->count());
    }

    /** @test */
    public function a_status_knows_if_has_been_liked()
    {
        $user   = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->assertFalse($status->isLiked());

        $this->actingAs($user);

        $status->like();

        $this->assertTrue($status->isLiked());
    }
}
