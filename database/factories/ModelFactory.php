<?php
$factory->define(App\Collection::class, function (Faker\Generator $faker)
{
	$faker = Faker\Factory::create('fa_IR');
	return [
		'name' => $faker->name,
		'description' => $faker->realText(),
		'type' => $faker->numberBetween(1, 255),
		'city_id' => 1,
		'active' => 1,
		'starts_at' => $faker->dateTimeThisMonth,
		'ends_at' => $faker->dateTimeThisMonth,
	];

});
$factory->define(App\Venue::class, function (Faker\Generator $faker)
{
	$faker = Faker\Factory::create('fa_IR');
	return [
		'name' => $faker->name,
		'score' => $faker->numberBetween(1, 5),
		'cost' => $faker->numberBetween(1, 5),
		'instagram' => $faker->url,
		'url' => $faker->url,
		'phone' => $faker->phoneNumber,
		'mobile' => $faker->phoneNumber,
		'status' => 1,
		'created_at' => $faker->date(),
		'updated_at' => $faker->date()
	];

});
$factory->define(App\Location::class, function (Faker\Generator $faker)
{
    $faker = Faker\Factory::create('fa_IR');
    return [
        'address' => $faker->address,
        'city_id' => 1,
        'country_id' => 1,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'created_at' => $faker->date(),
        'updated_at' => $faker->date()
    ];

});
$factory->define(App\City::class, function (Faker\Generator $faker)
{
	$faker = Faker\Factory::create('fa_IR');
	return [
		'name' => $faker->city,
		'status' => 1,
		'lat' => $faker->latitude,
		'lng' => $faker->longitude
	];
});