<?php

namespace Korona\Http\Controllers\Internal;

use Illuminate\Http\Request;

use Korona\Http\Controllers\Controller;
use Korona\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        return view('internal.home');
    }
}
