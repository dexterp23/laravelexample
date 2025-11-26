<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Repositories\RpixelsRepository;


class RpixelsController extends Controller
{
	
	const ATTRIBUTES = ['name', 'code'];

	public function __construct( RpixelsRepository $RpixelsRepository ) {
        $this->RpixelsRepository = $RpixelsRepository;
    }
	
    public function List(Request $request)
    {
		$filter  =  $request->input('filter') ?? '';
		$rpixels = $this->RpixelsRepository->getAllPaginated($filter);

		return view('rpixels.list', ['data' => $rpixels, 'filter' => $filter]);
    }
	
	public function Add()
    {
		$user = [];
		return view('rpixels.edit', ['data' => $user]);
    }
	
	public function Edit(Request $request, $id)
    {
		$ID_users = Auth::id();
		$rpixels = $this->RpixelsRepository->getById( $ID_users, $id );
		return view('rpixels.edit', ['data' => $rpixels]);
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
			$user = $this->RpixelsRepository->add( $attributes );
			return redirect()->route('rpixels.edit', $user->id)->with(['success' => 'Successfully added.']);
		} else {
			$this->RpixelsRepository->update( $id, $attributes );
			return redirect()->back()->with(['success' => 'Successfully updated.']);
		}
		
    }
	
	public function Delete($id) {
		$user = $this->RpixelsRepository->delete( $id );
		return redirect()->route('rpixels.list')->with(['success' => 'Deletion confirmed.']);
    }
	
}
