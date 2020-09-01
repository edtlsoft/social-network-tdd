<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Concerns\InteractsWithAuthentication;
use Tests\DuskTestCase;
use Throwable;

class UsersCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations, InteractsWithAuthentication;

    /** @test
     * @throws Throwable
     */
    public function user_can_like_and_unlike_statuses()
    {
        $user   = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->assertSeeIn('@likes-count', '0')
                ->press('@status-like-btn')
                ->waitForText('Unlike')
                ->assertSee('Unlike')
                ->assertSeeIn('@likes-count', '1')

                ->press('@status-like-btn')
                ->waitForText('Like')
                ->assertSee('Like')
                ->assertSeeIn('@likes-count', '0')
            ;
        });
    }

    /** @test
     * @throws Throwable
     */
    public function guest_can_not_like_statuses()
    {
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($status) {
            // Logout Dusk
            $browser->visit('_dusk/logout');

            $browser->visit('/')
                ->waitForText($status->body)
                ->press('@status-like-btn')
                ->assertPathIs('/login')
                ;
        });
    }
}
