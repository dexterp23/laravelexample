<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Repositories\VendorsRepository;


class VendorsController extends Controller
{
	
	const ATTRIBUTES = ['name'];

	public function __construct( VendorsRepository $VendorsRepository ) {

        $this->VendorsRepository = $VendorsRepository;
    }
	
    public function List(Request $request)
    {

		$filter  =  $request->input('filter') ?? '';
		$vendors = $this->VendorsRepository->getAllPaginated($filter);

		return view('vendors.list', ['data' => $vendors, 'filter' => $filter]);
    }
	
	public function Add()
    {
		$user = [];
		return view('vendors.edit', ['data' => $user]);

    }
	
	public function Edit(Request $request, $id)
    {
		$ID_users = Auth::id();
		$vendors = $this->VendorsRepository->getById( $ID_users, $id );
		return view('vendors.edit', ['data' => $vendors]);

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
			$user = $this->VendorsRepository->add( $attributes );
			return redirect()->route('vendors.edit', $user->id)->with(['success' => 'Successfully added.']);
		} else {
			$this->VendorsRepository->update( $id, $attributes );
			return redirect()->back()->with(['success' => 'Successfully updated.']);
		}
		
    }
	
	public function Delete($id) {
		
		$user = $this->VendorsRepository->delete( $id );
		return redirect()->route('vendors.list')->with(['success' => 'Deletion confirmed.']);
		
    }
	
}
