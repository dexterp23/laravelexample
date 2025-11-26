<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		if ( isAdmin() ) {
			 return redirect(route('admin_dashboard'));
		} else  {
			return view('home');
		}
        
    }
	
	public function admin()
    {
        return view('admin');
    }
}
