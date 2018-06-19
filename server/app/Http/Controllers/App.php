<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class App extends Controller
{
    /**
     * App entry point.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('app');
    }
}
