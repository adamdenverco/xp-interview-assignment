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

// model factory usage adapted from: https://laravel-news.com/learn-to-use-model-factories-in-laravel-5-1

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Address::class, function (Faker\Generator $faker) {
    return [
        'street' => (string) $faker->streetAddress,
        'city' => (string) $faker->city,
        'state' => (string) $faker->stateAbbr,
        'postal_code' => (string) $faker->postcode,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});

$factory->define(App\Person::class, function (Faker\Generator $faker) {
    $firstName = (string) $faker->firstName;
    $lastName = (string) $faker->lastName;

    // we could use faker's email or safe email generator,
    // but then the email address wouldn't match the person's name
    // so let's create an email with the users first and last name
    $emailPrefix = strtolower( preg_replace("/[^A-Za-z0-9\.]/", '', $firstName.".".$lastName) );

    // pick a random domain extenstion
    $emailDomainExtensions = ['com','net','org'];
    $key = array_rand($emailDomainExtensions, 1);
    $emailDomainExtension = $emailDomainExtensions[$key];

    // construct our email address
    $email = $emailPrefix . "@example.". $emailDomainExtension;    

    // return the person array
    return [
        // address_id will be passed from the Database Seeder
        'first_name' => (string) $firstName,
        'last_name' => (string) $lastName,
        'email' => (string) $email,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
});
