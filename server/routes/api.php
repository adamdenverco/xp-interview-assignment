<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Add API Chapter 2 routes here.

Route::get('/people', function () {
    $persons = App\Person::getAllApiFormat();
    echo $persons;
    // return view('people.index', array('persons'=>$persons) );
});

Route::get('/people/{id}', function (int $id = 0) {
    $person = App\Person::getOnePersonApiFormat($id);
    echo $person;
    // return view('people.show', array('person'=>$person) );    
});
