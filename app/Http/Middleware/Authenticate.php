<?php

namespace Korona\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        // If the user account is inactive, deny access to all internal areas.
        // Note that this does not prevent users from accessing the backend, so
        // as not to accidentally lock out the superuser, for example. If a
        // user with access to the backend needs to be locked out, their backend
        // access privileges should be revoked first.
        if (! Auth::user()->active) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->to('/')->with('error', trans('auth.account_inactive'));
            }
        }

        // If there is no member associated with the user account, deny access.
        // Some features in the internal and backend areas depend on a working
        // relationship between user and member.
        if (Auth::user()->member === null) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Internal Server Error', 500);
            } else {
                return redirect()->to('/')->with('error', trans('auth.account_has_no_member'));
            }
        }

        return $next($request);
    }
}
