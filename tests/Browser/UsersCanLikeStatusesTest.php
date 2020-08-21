<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test
     * @throws \Throwable
     */
    public function user_can_like_statuses()
    {
        $user   = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->press('@like-btn')
                    ->waitForText('Unlike')
                    ->assertSee('Unlike')
                    ;
        });
    }

    /** @test
     * @throws \Throwable
     */
    public function user_can_like_and_unlike_statuses()
    {
        $user   = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->waitForText('Unlike')
                ->assertSee('Unlike')

                ->press('@unlike-btn')
                ->waitForText('Like')
                ->assertSee('Like')
            ;
        });
    }

    /** @test
     * @throws \Throwable
     */
    public function guest_can_not_like_statuses()
    {
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($status) {
            $browser->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->assertPathIs('/login')
                ;
        });
    }
}