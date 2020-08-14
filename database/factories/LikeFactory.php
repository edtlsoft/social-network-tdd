<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Like::class, function (Faker $faker) {
    return [
        'status_id' => function() {
            return factory(\App\Models\Status::class)->create();
        },
        'user_id' => function() {
            return factory(\App\User::class)->create();
        }
    ];
});
