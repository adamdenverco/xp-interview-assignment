<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{

    /**
     * Laravel Migration class properties and methods
     * from: https://github.com/laravel/framework/blob/4.2/src/Illuminate/Database/Migrations/Migration.php
     * 
     * var string
     * protected $connection;
     * 
     * return string
     * public function getConnection()
     * 
     * Migrations purpose: 
     * - create tables in a database
     * - easily create and modify the database schema
     * - easily share database schema
     * - database agnostic ()
     * (as opposed to seeders to seed the table with data)
     * from: https://laravel.com/docs/5.6/migrations#introduction
     */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // adapted from: https://laravel.com/docs/5.6/migrations#introduction

        // create 'address' table
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('postal_code', 10);
            $table->timestamps(); # Laravel adds 'created_at' and 'updated_at' timestamp columns
        });

        // create 'address' table
        // with 'address_id' foreign constraint
        Schema::create('person', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('address_id');
            $table->foreign('address_id')->references('id')->on('address');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 63);
            $table->timestamps(); # Laravel adds 'created_at' and 'updated_at' timestamp columns
        });

        // create 'workplace_connection' table
        // with 'person_id' and 'colleague_id' foreign constraints
        Schema::create('workplace_connection', function (Blueprint $table) {
            $table->unsignedInteger('person_id');
            $table->foreign('person_id')->references('id')->on('person');
            $table->unsignedInteger('colleague_id');
            $table->foreign('colleague_id')->references('id')->on('person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop tables if they exist
        // adapted from: https://laravel.com/docs/5.6/migrations#introduction

        // drop 'workplace_connection' first as it has no key constraints 
        Schema::dropIfExists('workplace_connection');

        // now drop 'person' because it's foreign key constraints 
        // have been deleted from 'workplace_connection'
        Schema::dropIfExists('person');

        // now drop 'address' because all foreign key constraints
        // have been deleted from 'person'
        Schema::dropIfExists('address');
    }
}
