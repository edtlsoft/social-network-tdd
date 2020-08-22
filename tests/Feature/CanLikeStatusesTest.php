<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_like_statuses()
    {
        // Given
        $status = factory(Status::class)->create();
        $user   = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $response = $this->postJson(route('statuses.like.store', $status));

        // Then
        $this->assertDatabaseHas('likes', [
            'user_id'   => $user->id,
            'status_id' => $status->id,
        ]);
    }

    /** @test */
    public function guests_user_can_not_like_statuses()
    {
        // Given
        $status = factory(Status::class)->create();

        // When
        $response = $this->postJson(route('statuses.like.store', $status));

        // Then
        $response->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_unlike_statuses()
    {
        $this->withoutExceptionHandling();
        // Given
        $status = factory(Status::class)->create();
        $user   = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $response = $this->postJson(route('statuses.like.store', $status));
        $response = $this->deleteJson(route('statuses.like.destroy', $status));

        // Then
        $this->assertDatabaseMissing('likes', [
            'user_id'   => $user->id,
            'status_id' => $status->id,
        ]);
    }
}
