<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'app_notification' => 0,
        'email_notification' => 0,
        'sms_notification' => 0,
        'notification_states' => json_encode(array('')),
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});

$factory->define(App\Department::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => 1,
        'name' => $faker->company,
        'email' => $faker->safeEmail,
        'type' => $faker->randomElement( $array = array( 'career', 'volunteer', 'mostly career', 'mostly volunteer' ) ),
        'address1' => $faker->streetAddress,
        'address2' => $faker->secondaryAddress,
        'county' => 'Miami Dade',
        'city' => 'Miami', // $faker->city
        'state' => 'FL', // $faker->stateAbbr
        'zip' => 33127, // $faker->postcode
        'stations' => $faker->numberBetween($min = 1, $max = 20),
        'yearly_call_volume' => $faker->numberBetween($min = 100000, $max = 800000),
        'population_served' => $faker->numberBetween($min = 10000, $max = 100000),
        'fulltimers' => $faker->numberBetween($min = 1, $max = 20),
        'parttimers' => $faker->numberBetween($min = 1, $max = 20),
        'paid_oncallers' => $faker->numberBetween($min = 1, $max = 20),
        'volunteers' => $faker->numberBetween($min = 1, $max = 20),
        'civilians' => $faker->numberBetween($min = 1, $max = 20),
        'phone' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'website' => $faker->safeEmailDomain,
        'hq' => 1,
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});

$factory->define(App\Position::class, function (Faker\Generator $faker) {
    return [
        'department_id' => $faker->numberBetween($min = 1, $max = 50),
        'title' => $faker->sentence(6),
        'salary' => $faker->randomElement( $array = array( 'Hourly', 'Salary' ) ),
        'position_type' => $faker->randomElement( $array = array( 'full-time', 'paid-on-call', 'part-time', 'volunteer', 'contractor' ) ),
        'state' => $faker->stateAbbr,
        'application_details' => $faker->paragraph(5),
        'testing_details' => $faker->paragraph(5),
        'orientation_details' => $faker->paragraph(5),
        'requirements' => $faker->paragraph(5),
        'qualifications' => $faker->paragraph(5),
        'residency_requirements' => $faker->paragraph(5),
        'ending' => $faker->randomElement( $array = array( 'untilFilled', 'continuous' ) ),
        'publish' => Carbon\Carbon::now(),
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
        'featured' => 0,
        'active' => 1,
    ];
});

$factory->define(App\FeaturedPosition::class, function (Faker\Generator $faker) {
    return [
        'position_id' => $faker->numberBetween($min = 1, $max = 200),
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});
