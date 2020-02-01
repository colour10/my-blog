<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use App\Models\Info;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Info::class, function (Faker $faker) {
    // 频道ID随机抽选一个
    $channel = Channel::query()->inRandomOrder()->first();
    return [
        'title'      => 'Info-' . $faker->word,
        'channel_id' => $channel ? $channel->id : null,
        'content'    => $faker->sentence,
    ];
});
