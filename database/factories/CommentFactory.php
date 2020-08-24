<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(\App\User::class)->create();
        },
        'status_id' => function() {
            return factory(\App\Models\Status::class)->create();
        },
        'body' => $faker->text
    ];
});
