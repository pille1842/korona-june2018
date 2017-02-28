<?php

namespace Korona\Http\Controllers\Auth;

use Korona\User;
use Validator;
use Korona\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;

    protected $redirectTo = '/';
    protected $username = 'login';

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
}
