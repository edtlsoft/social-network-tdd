<?php

namespace Tests\Feature;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use App\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Tests\TestCase;
use App\Events\StatusCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_authenticated_user_can_create_statuses()
    {
        Event::fake([StatusCreated::class]);

        $body = 'My first status';

        // 1. Given => Given a authenticated user
        $user = factory(User::class)->create(['email' => 'edward@edtlsoft.com']);
        $this->actingAs($user);

        // 2. When  => When you make a post request to status
        $response = $this->postJson(route('statuses.store'), ['body' => $body]);

        // 3. Then
        // Assert Event was dispatched
        Event::assertDispatched(StatusCreated::class, function($e) {
            return $e->status->id === Status::first()->id
                && $e->status instanceof StatusResource
                && $e->status->resource instanceof Status
                && $e instanceof ShouldBroadcast;
        });

        // Assert see a new status in the database
        $response->assertJson([
            'data' => [
                'body' => $body,
                'user' => [
                    'username' => $user->username
                ]
            ]
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body'    => $body
        ]);
    }

    /**
     * @test
     */
    public function guests_users_can_not_create_statuses()
    {
        $response = $this->postJson(route('statuses.store'), ['body' => 'My first status']);

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function a_status_requires_a_body()
    {
        $user = factory(User::class)->create(['email' => 'edward@edtlsoft.com']);
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        //dd($response->getContent());
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => ['body']
        ]);
    }

    /**
     * @test
     */
    public function a_status_body_requires_a_minimum_length()
    {
        $user = factory(User::class)->create(['email' => 'edward@edtlsoft.com']);
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'Hey there']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => ['body']
        ]);
    }
}
