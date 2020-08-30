<?php

namespace Tests\Unit\Traits;

use App\Models\Like;
use App\Traits\HasLikesTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasLikesTraitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_model_morphs_many_likes()
    {
        $model = new ModelWithLikes(['id' => 1]);

        factory(Like::class)->create([
            'likeable_id' => $model->id,
            'likeable_type' => get_class($model)
        ]);

        // Then
        $this->assertInstanceOf(Like::class, $model->likes->first());
    }

    /** @test */
    public function a_model_can_be_liked()
    {
        // Given
        $model = new ModelWithLikes(['id' => 1]);
        $user  = factory(User::class)->create();

        // When
        $this->actingAs($user);

        $model->like();

        // Then
        $this->assertEquals(1, $model->likes()->count());
    }

    /** @test */
    public function a_model_can_be_liked_once()
    {
        // Given
        $model = new ModelWithLikes(['id' => 1]);
        $user  = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $model->like();

        // Then
        $this->assertEquals(1, $model->likes()->count());

        // When
        $model->like();

        // Then
        $this->assertEquals(1, $model->likes()->count());
    }

    /** @test */
    public function a_model_knows_if_has_been_liked()
    {
        $model = new ModelWithLikes(['id' => 1]);
        $user  = factory(User::class)->create();

        $this->assertFalse($model->isLiked());

        $this->actingAs($user);

        $model->like();

        $this->assertTrue($model->isLiked());
    }

    /** @test */
    public function a_model_can_be_unliked()
    {
        // Given
        $model = new ModelWithLikes(['id' => 1]);
        $user  = factory(User::class)->create();
        $this->actingAs($user);

        // When
        $model->like();
        $model->unlike();

        // Then
        $this->assertEquals(0, $model->likes()->count());
    }

    /** @test */
    public function a_model_knows_how_many_likes_it_has()
    {
        // Given
        $model = new ModelWithLikes(['id' => 1]);

        $this->assertEquals(0, $model->likesCount());

        factory(Like::class, 2)->create([
            'likeable_id'   => $model->id,
            'likeable_type' => get_class($model)
        ]);

        $this->assertEquals(2, $model->likesCount());
    }
}

class ModelWithLikes extends Model
{
    use HasLikesTrait;

    protected $fillable = ['id'];
}
