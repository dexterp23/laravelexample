<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Repositories\UserRepository;


class UserController extends Controller
{
	
	const ATTRIBUTES = ['name', 'digi_id', 'member_id', 'digi_api_key'];

	public function __construct( UserRepository $UserRepository ) {

		$this->UserRepository = $UserRepository;
    }
	
    public function UsersList(Request $request)
    {
		$filter  =  $request->input('filter') ?? '';
		$users = $this->UserRepository->getAllPaginated($filter);

		return view('users.list', ['users' => $users, 'filter' => $filter]);
    }
	
	public function UsersAdd()
    {
		$user = [];
		return view('users.edit', ['data' => $user]);
    }
	
	public function UsersEdit(Request $request, $id)
    {
		$user = $this->UserRepository->getById( $id );
		return view('users.edit', ['data' => $user, 'data_user' => $user]);
    }
	
    public function UsersEditUpdate(Request $request) {
		
		$this->validate($request, [
			'name' => 'required',
			'member_id' => 'required',
		]);
		
		$id = $request->get('id');
		$publish = $request->get('publish');
		if (!$publish) $publish = 0;
		$attributes = $request->only(self::ATTRIBUTES);
		$attributes['publish'] = $publish;

		if ( $id == null ) {
			$user = $this->UserRepository->add( $attributes );
			return redirect()->route('users.edit', $user->id)->with(['success' => 'Successfully added.']);
		} else {
			$this->UserRepository->update( $id, $attributes );
			return redirect()->back()->with(['success' => 'Successfully updated.']);
		}
		
    }
	
	public function UserProfile(Request $request)
    {
		$userId = Auth::id();
		$user = $this->UserRepository->getById( $userId );
		return view('users.profile', ['data' => $user]);

    }
	
	public function UserProfileUpdate(Request $request) {
		
		if ( isUser() ) {
			$this->validate($request, [
				'name' => 'required',
				'email' => 'required',
			]);
		} else if ( isAdmin() ) {
			$this->validate($request, [
				'name' => 'required',
				'email' => 'required',
			]);
		}
		
		$userId = Auth::id();
		$password = $request->get('password');
		if ($password) {
			$attributes['password'] = Hash::make($request->get('password'));
			$this->validate($request, [
				'password' => ['required', 'string', 'min:1', 'confirmed'],
			]);
		}
		
		$attributes['name'] = $request->get('name');
		$attributes['timeZone'] = $request->get('timeZone');
		$attributes['digi_id'] = $request->get('digi_id');
		
		$this->UserRepository->updateUser( $userId, $attributes );
		return redirect()->back()->with(['success' => 'Successfully updated.']);
		
    }
	
}
