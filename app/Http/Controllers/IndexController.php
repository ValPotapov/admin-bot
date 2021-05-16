<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IndexController extends Controller
{
    //

    public function index()
    {
        Redirect::route('salons.index');
    }
}
