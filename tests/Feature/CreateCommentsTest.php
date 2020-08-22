<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authenticated_users_can_comment_statuses()
    {
        $this->withoutExceptionHandling();

        // Given
        $status  = factory(Status::class)->create();
        $comment = 'My first comment';
        $user    = factory(User::class)->create();

        $this->actingAs($user);

        // When
        $response = $this->postJson(route('statuses.comments.store', $status), [
            'body' => $comment,
        ]);

        // Then
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment,
        ]);
    }
}
