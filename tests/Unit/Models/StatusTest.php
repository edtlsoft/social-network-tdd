<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Status;
use App\Traits\HasLikesTrait;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_status_belongs_to_a_user()
    {
        // Given
        $status = factory(Status::class)->create();

        // Then
        $this->assertInstanceOf(User::class, $status->user);
    }

    /** @test */
    public function a_status_has_many_comments()
    {
        // Given
        $status = factory(Status::class)->create();

        factory(Comment::class, 3)->create(['status_id' => $status->id]);

        // Then
        $this->assertInstanceOf(Comment::class, $status->comments->first());
    }

    /** @test */
    public function a_status_model_must_use_the_triat_has_likes_trait()
    {
        $this->assertClassUseTrait(Status::class, HasLikesTrait::class);
    }

}
