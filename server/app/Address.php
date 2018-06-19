<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // setting table name manually to avoid Laravel guessing it wrong
    // adapted from: https://stackoverflow.com/questions/30159257/base-table-or-view-not-found-1146-table-laravel-5
    public $table = "address";

    public function person()
    {
        return $this->hasOne('App\Person');
    }



}
