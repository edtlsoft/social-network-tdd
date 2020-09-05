<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanSeeProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_see_your_profile_test()
    {
        $this->withoutExceptionHandling();
        // Given
        $user = factory(User::class)->create(['username' => 'Edward']);

        // When
        $response = $this->getJson('@Edward');

        // Then
        $response->assertSee('Edward');
    }
}
