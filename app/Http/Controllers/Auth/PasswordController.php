<?php

namespace Korona\Http\Controllers\Auth;

use Korona\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = 'home';
    protected $subject = 'Dein Passwort wurde zurückgesetzt';

    public function __construct()
    {
        $this->middleware('guest');
    }
}
