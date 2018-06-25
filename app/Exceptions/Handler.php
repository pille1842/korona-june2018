<?php

namespace Korona\Exceptions;

use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Session;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $error = null;

        if ($e instanceof \Bican\Roles\Exceptions\RoleDeniedException) {
            $error = trans('auth.role_denied');
        }

        if ($e instanceof \Bican\Roles\Exceptions\PermissionDeniedException) {
            $error = trans('auth.permission_denied');
        }

        if ($e instanceof \Bican\Roles\Exceptions\LevelDeniedException) {
            $error = trans('auth.level_denied');
        }

        if ($error !== null) {
            // If the user is simply logged out, we'll redirect him to the login
            // page and keep his intended location intact. Otherwise we'll show
            // him an error.
            if (Auth::check()) {
                return redirect()->to('/')->with('error', $error);
            } else {
                // Flash the intended location to the session
                Session::put('url.intended', $request->fullUrl());
                return redirect()->to('/login')->with('error', trans('auth.login_required'));
            }
        }

        return parent::render($request, $e);
    }
}
