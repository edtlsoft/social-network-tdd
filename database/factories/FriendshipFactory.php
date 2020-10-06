<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Friendship;
use Faker\Generator as Faker;

$factory->define(Friendship::class, function (Faker $faker) {
    return [
        'sender_id' => function() {
            return factory(User::class)->create();
        },
        'recipient_id' => function() {
            return factory(User::class)->create();
        },
    ];
});
