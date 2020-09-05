<?php

namespace Tests\Unit\Http\Resources;

use App\User;
use Tests\TestCase;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_user_resource_must_have_the_necessary_fields()
    {
        // Given
        $user = factory(User::class)->create();
        $userResource = UserResource::make($user)->resolve();

        // Then
        $this->assertEquals(
            $user->username,
            $userResource['username']
        );
        $this->assertEquals(
            $user->avatar(),
            $userResource['avatar']
        );
        $this->assertEquals(
            $user->link(),
            $userResource['link']
        );
    }
}
