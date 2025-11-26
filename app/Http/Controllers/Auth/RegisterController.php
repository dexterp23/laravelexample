<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\UserController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserController $UserController)
    {
        $this->middleware('guest');
		
		$this->UserController = $UserController;
		
    }
	
	
	public function showRegistrationForm()
    {
		$iframe_chk = false;
		if (isset($_GET['iframe_chk'])) $iframe_chk = $_GET['iframe_chk'];
		
		if (env('APP_ENV') == 'dev') {
			return redirect(route('login'));
		} else {
			return view('auth.register', ['iframe_chk' => $iframe_chk]);
		}
		//return view('auth.register');
    }
	
	
	public function register(Request $request)
    {
		
		/* \vendor\laravel\ui\auth-backend\RegistersUsers.php */

        $this->validator($request->all())->validate();
		
		//member_id
		$member_id = strtolower (preg_replace('/[^a-z]/i', '', $request->get('name'))) . rand(1,99999);

		//add users
		$request->request->add(['member_id' => $member_id, 'digi_id' => $request->get('digi_id')]);
		event(new Registered($user = $this->create($request->all())));
		
		$this->guard()->login($user);

		if ($response = $this->registered($request, $user)) {
			return $response;
		}

		return $request->wantsJson()
					? new JsonResponse([], 201)
					: redirect($this->redirectPath());
					
    }
	
	
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		
		return Validator::make($data, [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
		
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
			'member_id' => $data['member_id'],
			'digi_id' => $data['digi_id'],
		]);
        
    }
}
