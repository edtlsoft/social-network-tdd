<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_user_has_a_avatar()
    {
        $user = factory(User::class)->create(['name' => 'Edward']);

        $this->assertEquals(
            '/images/default-avatar.jpg',
            $user->avatar()
        );
    }

    /** @test */
    public function an_user_has_a_link()
    {
        $user = factory(User::class)->create(['name' => 'Edward']);

        $this->assertEquals(
            route('users.show', $user),
            $user->link()
        );
    }
}
