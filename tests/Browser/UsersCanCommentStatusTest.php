<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authenticated_users_can_comment_a_status()
    {
        $user   = factory(\App\User::class)->create();
        $status = factory(\App\Models\Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $comment = 'Mi first comment';

            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->type('@comment', $comment)
                    ->press('@comment-btn')
                    ->waitForText($comment)
                    ->assertSee($comment)
                    ;
        });
    }

    /** @test */
    public function authenticated_users_can_see_all_comments()
    {
        $status   = factory(\App\Models\Status::class)->create();
        $comments = factory(\App\Models\Comment::class, 3)->create();

        $this->browse(function (Browser $browser) use ($status, $comments) {
            $browser->visit('/')->waitForText($status->body);

                foreach($comments as $comment) {
                    $browser->assertSee($comment->user->name)
                            ->assertSee($comment->body);
                }
            ;
        });
    }
}
