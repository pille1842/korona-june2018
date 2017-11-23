<?php

namespace Korona\Http\Middleware;

use Auth;
use Closure;
use Route;

class CheckPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Route::currentRouteAction() != 'Korona\Http\Controllers\Internal\PasswordController@getForm'
                && Route::currentRouteAction() != 'Korona\Http\Controllers\Internal\PasswordController@changePassword'
                && Auth::user()->force_password_change) {
            return redirect()->action('Internal\PasswordController@changePassword')
                    ->with('warning', trans('internal.please_change_password'));
        }

        return $next($request);
    }
}
