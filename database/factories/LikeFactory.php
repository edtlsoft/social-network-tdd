<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Like::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(\App\User::class)->create();
        },
    ];
});
