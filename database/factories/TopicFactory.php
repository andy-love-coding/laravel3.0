<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {

    $sentence = $faker->sentence();
    
    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();

    // 传参为：生成最大时间不超过，因为创建时间永远比更改时间早
    $created_at = $faker->dateTimethisMonth($updated_at);

    return [
        'title' => $sentence,
        'body'  => $faker->text(),
        'excerpt' => $sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});