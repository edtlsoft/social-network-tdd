<?php

namespace Tests\Unit\Models;

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
}
