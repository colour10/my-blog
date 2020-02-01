<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ModelsChannel;
use Faker\Generator as Faker;

$factory->define(\App\Models\Channel::class, function (Faker $faker) {
    // 频道类型从数据库中随机取出一个
    $channeltype = \App\Models\Channeltype::query()->inRandomOrder()->first();
    return [
        'name'           => 'Channel-' . $faker->word,
        'pid'            => 0,
        'channeltype_id' => $channeltype ? $channeltype->id : null,
    ];
});
