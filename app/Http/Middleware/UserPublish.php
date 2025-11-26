<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserPublish
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
        if ( isPublish() ) {
            return $next($request);
        } else {
			Auth::logout();
			return redirect(route('welcome'))->withErrors(['error' => 'Please contact administration to login.']);
		}

        return abort(404);
    }
}
