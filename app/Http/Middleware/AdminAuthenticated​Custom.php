<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class AdminAuthenticated​Custom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		
        if( Auth::check() )
        {
            // if user is not admin take him to his dashboard
			if ( isUser() ) {
                 return redirect(route('user_dashboard'));
            }

            // allow admin to proceed with request
			else if ( isAdmin() ) {
                 return $next($request);
            }
        }

        abort(404);  // for other user throw 404 error
    }
}
