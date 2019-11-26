<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */
//faker은 아무의미 없음

//유저 팩토리
$factory->define(App\User::class, function (Faker $faker) {
    return [
        // 'name' => $faker->name,
        'name' => $faker->name . Str::random(3) . '영진',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'password' => bcrypt('password'), // password
        'remember_token' => Str::random(10),
    ];
});

//게시글 팩토리
$factory->define(App\Article::class, function (Faker $faker) {
    $date = $faker->dateTimeThisMonth;
    $userId = App\User::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($userId),
        'title' => $faker->sentence(),
        'content' => $faker->paragraph(),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

//첨부파일 팩토리
$factory->define(App\Attachment::class, function (Faker $faker) {
    return [
        'filename' => sprintf("%s.%s",
            Str::random(),
            $faker->randomElement(config('project.mimes'))
        ),
    ];
});

//댓글 팩토리
$factory->define(App\Comment::class, function (Faker $faker) {
    $articleIds = App\Article::pluck('id')->toArray();
    $userIds = App\User::pluck('id')->toArray();
    return [
        'content' => $faker->paragraph,
        'commentable_type' => App\Article::class,
        'commentable_id' => function () use ($faker, $articleIds) {
            return $faker->randomElement($articleIds);
        },
        'user_id' => function () use ($faker, $userIds) {
            return $faker->randomElement($userIds);
        },
    ];
});

//투표 팩토리
$factory->define(App\Vote::class, function (Faker $faker) {
    $up = $faker->randomElement([true, false]);
    $down = ! $up;
    $userIds = App\User::pluck('id')->toArray();
    return [
        'up' => $up ? 1 : null,
        'down' => $down ? 1 : null,
        'user_id' => function () use($faker, $userIds) {
            return $faker->randomElement($userIds);
        },
    ];
});