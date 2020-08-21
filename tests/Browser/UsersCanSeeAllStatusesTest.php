<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class UsersCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws Throwable
     */
    public function users_can_see_all_statuses_on_the_homepage()
    {
        // Given
        $user = factory(User::class)->create();
        $statuses = factory(Status::class, 5)->create(['created_at' => now()->subMinute()]);

        $this->browse(function (Browser $browser) use ($user, $statuses) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($statuses->first()->body)
                ->assertSee($statuses->first()->body)
                ;

            foreach ($statuses as $status) {
                $browser->assertSee($status->body)
                        ->assertSee($status->user->name)
                        ;
            }
        });
    }
}
