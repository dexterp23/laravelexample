<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Repositories\LinksRepository;
use App\Repositories\VendorsRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\PagesRepository;
use App\Repositories\DomainsRepository;
use App\Repositories\RpixelsRepository;


class AjaxController extends Controller
{

	public function __construct( LinksRepository $LinksRepository, VendorsRepository $VendorsRepository, GroupsRepository $GroupsRepository, PagesRepository $PagesRepository, DomainsRepository $DomainsRepository, RpixelsRepository $RpixelsRepository ) {

        $this->LinksRepository = $LinksRepository;
		$this->VendorsRepository = $VendorsRepository;
		$this->GroupsRepository = $GroupsRepository;
		$this->PagesRepository = $PagesRepository;
		$this->DomainsRepository = $DomainsRepository;
		$this->RpixelsRepository = $RpixelsRepository;
    }
	
    public function index(Request $request)
    {
		
		$page = $request->input('page');
		
		switch ($page) {
			
			case "NewDomain": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$attributes['ID_users'] = $ID_users;
				$attributes['name'] = $request->input('name');
				$attributes['slug'] = $request->input('slug');
				$attributes['url'] = $request->input('url');
				$attributes['cname'] = $request->input('cname');
				$attributes['default_url'] = $request->input('default_url');
				$attributes['pixel_code'] = $request->input('pixel_code');
				$attributes['is_forward'] = $request->input('is_forward');
				
				$attributes['url'] = URLFix ($attributes['url']);
				
				//add domain in cpanel
				$attributes['domain'] = DomainFix($attributes['url']);
				$attributes['subdomain'] = SubDomainFix($attributes['domain']);
				AddonDomain($attributes['domain'], $attributes['subdomain'], "add");
				
				$add = $this->DomainsRepository->add($attributes);
				$last_id = $add->id;
				
				$data_array = $this->DomainsRepository->getAll($ID_users, 'id,name,url');
				
				$array = array ('chk' => $chk, 'last_id' => $last_id, 'data_array' => $data_array);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
			case "NewCompletePage": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$attributes['ID_users'] = $ID_users;
				$attributes['name'] = $request->input('name');
				$attributes['url'] = $request->input('url');
				$add = $this->PagesRepository->add($attributes);
				$last_id = $add->id;
				
				$data_array = $this->PagesRepository->getAll($ID_users, 'id,name');
				
				$array = array ('chk' => $chk, 'last_id' => $last_id, 'data_array' => $data_array);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
			case "NewPendingPage": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$attributes['ID_users'] = $ID_users;
				$attributes['name'] = $request->input('name');
				$attributes['url'] = $request->input('url');
				$add = $this->PagesRepository->add($attributes);
				$last_id = $add->id;
				
				$data_array = $this->PagesRepository->getAll($ID_users, 'id,name');
				
				$array = array ('chk' => $chk, 'last_id' => $last_id, 'data_array' => $data_array);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
			case "NewRPixel": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$attributes['ID_users'] = $ID_users;
				$attributes['name'] = $request->input('name');
				$attributes['code'] = $request->input('code');
				$add = $this->RpixelsRepository->add($attributes);
				$last_id = $add->id;
				
				$data_array = $this->RpixelsRepository->getAll($ID_users, 'id,name');
				
				$array = array ('chk' => $chk, 'last_id' => $last_id, 'data_array' => $data_array);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
			case "NewGroup": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$attributes['ID_users'] = $ID_users;
				$attributes['name'] = $request->input('name');
				$add = $this->GroupsRepository->add($attributes);
				$last_id = $add->id;
				
				$data_array = $this->GroupsRepository->getAll($ID_users, 'id,name');
				
				$array = array ('chk' => $chk, 'last_id' => $last_id, 'data_array' => $data_array);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
			case "NewVendor": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$attributes['ID_users'] = $ID_users;
				$attributes['name'] = $request->input('name');
				$add = $this->VendorsRepository->add($attributes);
				$last_id = $add->id;
				
				$data_array = $this->VendorsRepository->getAll($ID_users, 'id,name');
				
				$array = array ('chk' => $chk, 'last_id' => $last_id, 'data_array' => $data_array);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
			case "slug_chk": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$id = $request->input('id');
				$slug = $request->input('slug');
				$domains = $this->DomainsRepository->chkSlug($ID_users, $id, $slug);
				if (count($domains) > 0) $chk = false;
				
				$array = array ('chk' => $chk);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
			case "visible_link_chk": 
				
				$array = array();
				$chk = true;
				
				$ID_users = Auth::id();
				$id = $request->input('id');
				$text_link = $request->input('text_link');
				$links = $this->LinksRepository->chkTextLink($ID_users, $id, $text_link);
				if (count($links) > 0) $chk = false;
				
				$array = array ('chk' => $chk);
				echo $_REQUEST['callback'].'('.json_encode ($array).')';
				
			break;
			
		}
        
    }

}
