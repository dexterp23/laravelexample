<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Repositories\LinksRepository;
use App\Repositories\VendorsRepository;
use App\Repositories\DomainsRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\PagesRepository;
use App\Repositories\RpixelsRepository;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;


class LinksController extends Controller
{
	
	const ATTRIBUTES = ['vendor_id', 'name', 'url', 'status', 'domain_id', 'admin_domain', 'cloak_url', 'text_link', 'group_id', 'rpixels_id', 'page_id_pending', 'page_id_complete', 'tracking_link'];

	public function __construct( LinksRepository $LinksRepository, VendorsRepository $VendorsRepository, DomainsRepository $DomainsRepository, GroupsRepository $GroupsRepository, PagesRepository $PagesRepository, RpixelsRepository $RpixelsRepository ) {

        $this->LinksRepository = $LinksRepository;
		$this->VendorsRepository = $VendorsRepository;
		$this->DomainsRepository = $DomainsRepository;
		$this->GroupsRepository = $GroupsRepository;
		$this->PagesRepository = $PagesRepository;
		$this->RpixelsRepository = $RpixelsRepository;
    }
	
    public function List(Request $request)
    {
		
		$ID_users = Auth::id();
		$filter  =  $request->input('filter') ?? '';
		$vendor_id  =  $request->input('vendor_id') ?? 0;
		$group_id  =  $request->input('group_id') ?? 0;
		$status  =  $request->input('status') ?? 0;
		
		$links = $this->LinksRepository->getAllPaginated($filter, $vendor_id, $group_id, $status);
		$vendors = $this->VendorsRepository->getAll($ID_users);
		$groups = $this->GroupsRepository->getAll($ID_users);
		
		return view('links.list', ['data' => $links, 'filter' => $filter, 'vendors' => $vendors, 'groups' => $groups, 'vendor_id' => $vendor_id, 'group_id' => $group_id, 'status' => $status]);
    }
	
	public function Add()
    {
		$ID_users = Auth::id();
		$user = [];
		$vendors = $this->VendorsRepository->getAll($ID_users);
		$domains = $this->DomainsRepository->getAll($ID_users);
		$groups = $this->GroupsRepository->getAll($ID_users);
		$pages = $this->PagesRepository->getAll($ID_users);
		$rpixel = $this->RpixelsRepository->getAll($ID_users);
		
		return view('links.edit', ['data' => $user, 'vendors' => $vendors, 'domains' => $domains, 'groups' => $groups, 'pages' => $pages, 'rpixel' => $rpixel]);

    }
	
	public function Edit(Request $request, $id)
    {
		
		$ID_users = Auth::id();
		$links = $this->LinksRepository->getById( $ID_users, $id );
		$vendors = $this->VendorsRepository->getAll($ID_users);
		$domains = $this->DomainsRepository->getAll($ID_users);
		$groups = $this->GroupsRepository->getAll($ID_users);
		$pages = $this->PagesRepository->getAll($ID_users);
		$rpixel = $this->RpixelsRepository->getAll($ID_users);
		
		return view('links.edit', ['data' => $links, 'vendors' => $vendors, 'domains' => $domains, 'groups' => $groups, 'pages' => $pages, 'rpixel' => $rpixel]);

    }
	
    public function Update(Request $request) {
		
		$this->validate($request, [
			'name' => 'required',
			'url' => 'required',
			'text_link' => 'required',
			'text_link' => 'alpha_dash',
		]);
		
		$id = $request->get('id');
		$ID_users = Auth::id();
		$attributes = $request->only(self::ATTRIBUTES);
		
		$admin_domain = $request->get('admin_domain');
		if (!$admin_domain) $admin_domain = 2;
		$attributes['admin_domain'] = $admin_domain;
		$cloak_url = $request->get('cloak_url');
		if (!$cloak_url) $cloak_url = 0;
		$attributes['cloak_url'] = $cloak_url;
		$endless_chk = $request->get('endless_chk');
		if (!$endless_chk) $endless_chk = 0;
		$attributes['endless_chk'] = $endless_chk;
		$rpixel_chk = $request->get('rpixel_chk');
		if (!$rpixel_chk) $rpixel_chk = 0;
		$attributes['rpixel_chk'] = $rpixel_chk;
		$dates_chk = $request->get('dates_chk');
		if (!$dates_chk) $dates_chk = 0;
		$attributes['dates_chk'] = $dates_chk;
		$pages_chk = $request->get('pages_chk');
		if (!$pages_chk) $pages_chk = 0;
		$attributes['pages_chk'] = $pages_chk;
		
		//get offset
		$offset = GetOffset(Auth::user()->timeZone);
		
		//date_start
		$date_from_alt = $request->get('date_from_alt');
		$date_from_alt_array = explode ("@", $date_from_alt);
		$timestamp_alt = strtotime ($date_from_alt_array[0] .' '. $date_from_alt_array[1]);
		$timestamp_start = $timestamp_alt - ($offset * 60 * 60);
		
		$attributes['date_start'] = date("Y-m-d", $timestamp_start);
		$attributes['time_start'] = date("G:i:s", $timestamp_start);
		$attributes['timestamp_start'] = $timestamp_start;

		//date_end
		$date_end_alt = $request->get('date_end_alt');
		$date_end_alt_array = explode ("@", $date_end_alt);
		$timestamp_alt = strtotime ($date_end_alt_array[0] .' '. $date_end_alt_array[1]);
		$timestamp_end = $timestamp_alt - ($offset * 60 * 60);
		
		$attributes['date_end'] = date("Y-m-d", $timestamp_end);
		$attributes['time_end'] = date("G:i:s", $timestamp_end);
		$attributes['timestamp_end'] = $timestamp_end;

		if ( $id == null ) {
			$attributes['ID_users'] = $ID_users;
			$user = $this->LinksRepository->add( $attributes );
			return redirect()->route('links.edit', $user->id)->with(['success' => 'Successfully added.']);
		} else {
			$this->LinksRepository->update( $id, $attributes );
			return redirect()->back()->with(['success' => 'Successfully updated.']);
		}
		
    }
	
	public function Delete($id) {
		
		$user = $this->LinksRepository->delete( $id );
		return redirect()->route('links.list')->with(['success' => 'Deletion confirmed.']);
		
    }
	
}
