<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\StatusResource;
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

        // When
        $statusResource = StatusResource::make($status)->resolve();

        // Then
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
    }
}
