<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Repositories\GroupsRepository;


class GroupsController extends Controller
{
	
	const ATTRIBUTES = ['name'];

	public function __construct( GroupsRepository $GroupsRepository ) {

        $this->GroupsRepository = $GroupsRepository;
    }
	
    public function List(Request $request)
    {

		$filter  =  $request->input('filter') ?? '';
		$groups = $this->GroupsRepository->getAllPaginated($filter);

		return view('groups.list', ['data' => $groups, 'filter' => $filter]);
    }
	
	public function Add()
    {
		$user = [];
		return view('groups.edit', ['data' => $user]);

    }
	
	public function Edit(Request $request, $id)
    {
		$ID_users = Auth::id();
		$groups = $this->GroupsRepository->getById( $ID_users, $id );
		return view('groups.edit', ['data' => $groups]);
    }
	
    public function Update(Request $request) {
		
		$this->validate($request, [
			'name' => 'required',
		]);
		
		$id = $request->get('id');
		$ID_users = Auth::id();
		$attributes = $request->only(self::ATTRIBUTES);

		if ( $id == null ) {
			$attributes['ID_users'] = $ID_users;
			$user = $this->GroupsRepository->add( $attributes );
			return redirect()->route('groups.edit', $user->id)->with(['success' => 'Successfully added.']);
		} else {
			$this->GroupsRepository->update( $id, $attributes );
			return redirect()->back()->with(['success' => 'Successfully updated.']);
		}
		
    }
	
	public function Delete($id) {
		
		$user = $this->GroupsRepository->delete( $id );
		return redirect()->route('groups.list')->with(['success' => 'Deletion confirmed.']);
		
    }
	
}
