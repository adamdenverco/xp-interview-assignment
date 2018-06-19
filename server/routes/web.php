<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Chapter 1 routes.

Route::get('/ch1', function () {
    return redirect('/ch1/people');
});

// Route::get('/ch1/people')->uses('People@index')->name('people.index');
Route::get('/ch1/people', function () {
    $persons = App\Person::all()->toArray();
    return view('people.index', array('persons'=>$persons) );
});

// Route::get('/ch1/people/{id}')->uses('People@show')->name('people.show');
Route::get('/ch1/people/{id}', function (int $id = 0) {
    $person = App\Person::getOnePerson($id);
    echo "<pre>";
    print_r($person);
    echo "</pre>";
    return view('people.show', array('person'=>$person) );    
});

// Chapter 2 routes.

Route::get('ch2/')->uses('App@index');
Route::get('ch2/{all}')->where('all', '.*')->uses('App@index');

// Adam's testing: /info
Route::get('/info', function () {

    # let's make php info available for understanding the environment
    # from: https://stackoverflow.com/questions/32927134/symfony2-phpinfo-using-a-twig-template-for-layout
    ob_start();
    phpinfo();
    $phpinfo = ob_get_clean();
    return view('info', array('phpinfo'=>$phpinfo) );

});

// Adam's testing: /fakepersons
Route::get('/fakepersons', function () {

    # testing how to make faker data in Laravel
    # from: https://tutorials.kode-blog.com/laravel-5-faker-tutorial
    $faker = Faker\Factory::create();
    $limit = 25;
    ob_start();
    echo '<table>';
    for ($i = 0; $i < $limit; $i++) {
        echo '<tr>' . 
        '<td>'. $faker->firstName . '</td>' . 
        '<td>'. $faker->lastName . '</td>' . 
        '<td>'. $faker->unique()->safeEmail . '</td>' . 
        '<td>'. $faker->streetAddress . '</td>' . 
        '<td>'. $faker->city. '</td>' . 
        '<td>'. $faker->postcode. '</td>' . 
        '</tr>'; 
    }
    echo '</table>';
    $fakepersons = ob_get_clean();
    return view('fakepersons', array('fakepersons'=>$fakepersons) );
});

// Adam's testing: /testdatabase
Route::get('/testdatabase', function () {
    try {
        DB::connection()->getPdo();
        die("Congrats! You connected to the database.");
    } catch (\Exception $e) {
        die("Could not connect to the database. Please check your configuration.");
    }
});