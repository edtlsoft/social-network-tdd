<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListStatusesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_get_all_statuses()
    {
        // Given
        $statuses   = factory(Status::class, 8)->create();
        $statuses9  = factory(Status::class)->create(['created_at' => now()->addMinute(1)]);
        $statuses10 = factory(Status::class)->create(['created_at' => now()->addMinute(2)]);

        $user = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $response = $this->getJson(route('statuses.index'));

        // Then
        //dd($response->getContent());
        $response->assertStatus(200);

        $response->assertJson(['total' => 10]);

        $response->assertJsonStructure([
            'data', 'total', 'first_page_url', 'last_page_url'
        ]);

        //dd($response->json());

        $this->assertEquals(
            $statuses10->id,
            $response->json('data.0.id')
        );
    }
}
