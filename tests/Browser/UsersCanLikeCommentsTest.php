<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikeCommentsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
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
                ->waitFor('@comment-unlike-btn')
                ->assertSeeIn('@comment-unlike-btn', 'Unlike')
                ->assertSeeIn('@comment-likes-count', 1)

                ->press('@comment-unlike-btn')
                ->waitFor('@comment-like-btn')
                ->assertSeeIn('@comment-like-btn', 'Like')
                ->assertSeeIn('@comment-likes-count', 0)
            ;
        });
    }
}
