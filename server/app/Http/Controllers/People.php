<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class People extends Controller
{
    /**
     * List people
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('people/index');
    }

    /**
     * Show person
     *
     * @param Request $request
     * @param string  $id
     * @return mixed
     */
    public function show(Request $request, $id)
    {
        return view('people/show');
    }
}
