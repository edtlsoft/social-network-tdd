<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function route_key_name_is_set_to_name()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('name', $user->getRouteKeyName());
    }

    /** @test */
    public function an_user_has_a_avatar()
    {
        $user = factory(User::class)->make();

        $this->assertEquals(
            '/images/default-avatar.jpg',
            $user->avatar()
        );
    }

    /** @test */
    public function an_user_has_a_link()
    {
        $user = factory(User::class)->make();

        $this->assertEquals(
            route('users.show', $user),
            $user->link()
        );
    }
}
