<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Repositories\PagesRepository;


class PagesController extends Controller
{
	
	const ATTRIBUTES = ['name', 'url'];

	public function __construct( PagesRepository $PagesRepository ) {
        $this->PagesRepository = $PagesRepository;
    }
	
    public function List(Request $request)
    {
		$ID_users = Auth::id();
		$filter  =  $request->input('filter') ?? '';
		$pages = $this->PagesRepository->getAllPaginated($filter);
		$pages_all = $this->PagesRepository->getAll($ID_users);
		$pending_page = $this->PagesRepository->getDef($ID_users, 'panding_def');
		$complete_page = $this->PagesRepository->getDef($ID_users, 'complete_def');
		$false_page = $this->PagesRepository->getDef($ID_users, '404_def');

		return view('pages.list', ['data' => $pages, 'filter' => $filter, 'pages_all' => $pages_all, 'pending_page' => $pending_page, 'complete_page' => $complete_page, 'false_page' => $false_page]);
    }
	
	public function Add()
    {
		$user = [];
		return view('pages.edit', ['data' => $user]);
    }
	
	public function Edit(Request $request, $id)
    {
		$ID_users = Auth::id();
		$pages = $this->PagesRepository->getById( $ID_users, $id );
		return view('pages.edit', ['data' => $pages]);
    }
	
    public function Update(Request $request) {
		
		$this->validate($request, [
			'name' => 'required',
			'url' => 'required',
		]);
		
		$id = $request->get('id');
		$ID_users = Auth::id();
		$attributes = $request->only(self::ATTRIBUTES);
		
		if ( $id == null ) {
			$attributes['ID_users'] = $ID_users;
			$user = $this->PagesRepository->add( $attributes );
			return redirect()->route('pages.edit', $user->id)->with(['success' => 'Successfully added.']);
		} else {
			$this->PagesRepository->update( $id, $attributes );
			return redirect()->back()->with(['success' => 'Successfully updated.']);
		}
		
    }
	
	public function Delete($id) {
		$user = $this->PagesRepository->delete( $id );
		return redirect()->route('pages.list')->with(['success' => 'Deletion confirmed.']);
    }
	
	public function UpdateDef(Request $request) {

		$attributes_reset['panding_def'] = 0;
		$attributes_reset['complete_def'] = 0;
		$attributes_reset['404_def'] = 0;
		$this->PagesRepository->updatedefReset( $attributes_reset );

		if ($request->get('panding_def') > 0) $this->PagesRepository->updatedef( 'panding_def', $request->get('panding_def') );
		if ($request->get('complete_def') > 0) $this->PagesRepository->updatedef( 'complete_def', $request->get('complete_def') );
		if ($request->get('404_def') > 0) $this->PagesRepository->updatedef( '404_def', $request->get('404_def') );

		return redirect()->back()->with(['success' => 'Successfully updated.']);
		
    }
	
}
