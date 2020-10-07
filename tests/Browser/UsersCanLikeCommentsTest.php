<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class UsersCanLikeCommentsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test
     * @throws Throwable
     */
    public function authenticated_users_can_like_and_unlike_comments()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser) use ($user, $comment) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($comment->body)
                ->assertSee($comment->body)
                ->assertSeeIn('@comment-likes-count', 0)

                ->press('@comment-like-btn')
                ->pause(500)
                ->assertSeeIn('@comment-like-btn', 'Unlike')
                ->assertSeeIn('@comment-likes-count', 1)

                ->press('@comment-like-btn')
                ->pause(500)
                ->assertSeeIn('@comment-like-btn', 'Like')
                ->assertSeeIn('@comment-likes-count', 0)
            ;
        });
    }
}
