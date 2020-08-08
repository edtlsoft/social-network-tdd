<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_authenticated_user_can_create_statuses()
    {
        $this->withoutExceptionHandling();

        // 1. Given => Given a authenticated user
        $user = factory(User::class)->create(['email' => 'edward@edtlsoft.com']);
        $this->actingAs($user);

        // 2. When  => When you make a post request to status
        $this->post(route('statuses.store'), ['body' => 'My first status']);

        // 3. Then  => Then I see a new status in the database
        $this->assertDatabaseHas('statuses', ['body' => 'My first status']);
    }
}
