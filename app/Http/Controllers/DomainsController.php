<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Repositories\DomainsRepository;


class DomainsController extends Controller
{
	
	const ATTRIBUTES = ['name', 'slug', 'url', 'cname', 'default_url', 'pixel_code', 'is_forward', 'domain', 'subdomain'];

	public function __construct( DomainsRepository $DomainsRepository ) {
        $this->DomainsRepository = $DomainsRepository;
    }
	
    public function List(Request $request)
    {
		$filter  =  $request->input('filter') ?? '';
		$domains = $this->DomainsRepository->getAllPaginated($filter);

		return view('domains.list', ['data' => $domains, 'filter' => $filter]);
    }
	
	public function Add()
    {
		$domains = [];
		return view('domains.edit', ['data' => $domains]);
    }
	
	public function Edit(Request $request, $id)
    {
		$ID_users = Auth::id();
		$domains = $this->DomainsRepository->getById( $ID_users, $id );
		
		return view('domains.edit', ['data' => $domains]);
    }
	
    public function Update(Request $request) {
		
		$this->validate($request, [
			'name' => 'required',
			'slug' => 'required',
			'url' => 'required',
		]);
		
		$id = $request->get('id');
		$ID_users = Auth::id();
		$attributes = $request->only(self::ATTRIBUTES);
		
		$is_forward = $request->get('is_forward');
		if (!$is_forward) $is_forward = 0;
		$attributes['is_forward'] = $is_forward;
		
		$attributes['url'] = URLFix ($attributes['url']);
		$attributes['domain'] = DomainFix($attributes['url']);
		$attributes['subdomain'] = SubDomainFix($attributes['domain']);

		
		if ($id > 0) {
			$domains = $this->DomainsRepository->getById( $ID_users, $id );
			if ($domains[0]['subdomain'] != $attributes['subdomain']) {
				
				AddonDomain($attributes['domain'], $attributes['subdomain'], "add");

				//delete old domain from cpanel
				$domains_chk = $this->DomainsRepository->getBySubdomain( $domains[0]['subdomain'], $id );
				if (count($domains_chk) > 0) {
					//
				} else {
					AddonDomain($domains[0]['domain'], $domains[0]['subdomain'], "delete");
				}
			}
		} else {
			AddonDomain($attributes['domain'], $attributes['subdomain'], "add");
		}
		
		if ( $id == null ) {
			$attributes['ID_users'] = $ID_users;
			$user = $this->DomainsRepository->add( $attributes );
			return redirect()->route('domains.edit', $user->id)->with(['success' => 'Successfully added.']);
		} else {
			$this->DomainsRepository->update( $id, $attributes );
			return redirect()->back()->with(['success' => 'Successfully updated.']);
		}
		
    }
	
	public function Delete($id) {
		
		$ID_users = Auth::id();
		$domains = $this->DomainsRepository->getById( $ID_users, $id );
		
		//delete old domain from cpanel
		$domains_chk = $this->DomainsRepository->getBySubdomain( $domains[0]['subdomain'], $id );
		if (count($domains_chk) > 0) {
			//
		} else {
			AddonDomain($domains[0]['domain'], $domains[0]['subdomain'], "delete");
		}
		
		$user = $this->DomainsRepository->delete( $id );
		return redirect()->route('domains.list')->with(['success' => 'Deletion confirmed.']);
    }
	
	public function Download($id, $type) {
		
		$ID_users = Auth::id();
		$domains = $this->DomainsRepository->getById( $ID_users, $id );
		
		switch ($type) {
			case "wordpress": 
				
				$dir_path = storage_path('app');
				$dir_path_files = public_path() . "/php";
				$user_dir = $type."_".$ID_users."_".$id;

				if (!file_exists($dir_path.'/'.$user_dir)) mkdir($dir_path.'/'.$user_dir , 0777);
				FolderCopy($dir_path_files.'/wordpress', $dir_path.'/'.$user_dir);
				
				$fp = @fopen($dir_path.'/'.$user_dir.'/config.php', "w");
				$string_lang = '<?php
				';
				$string_lang .= ' $UserName = "'.Auth::user()->member_id.'"; 
				';
				$string_lang .= ' $DomainSlug = "'.$domains[0]->slug.'"; 
				';
				$string_lang .= ' $DomainDigi = "'.config('defines.MainTracker').'"; 
				';
				$string_lang .= '
				?>';
				@fwrite($fp, $string_lang);
				@fclose($fp);
				
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/404.php', 'name' => '404.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/digilinks.php', 'name' => 'digilinks.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/digilinks-wp.php', 'name' => 'digilinks-wp.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/index.php', 'name' => 'index.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/config.php', 'name' => 'config.php');
				$zip_file = $dir_path.'/'.$user_dir.'/digilinks-wp.zip';
				$result = CreateZip($files_to_zip, $zip_file, 'digilinks', false);

				if ($result) {
					
					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Cache-Control: public");
					header("Content-Description: File Transfer");
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=digilinks-wp.zip');
					header("Content-Transfer-Encoding: binary");
					header('Content-Length:'.@filesize($zip_file));	
					
					$file = @fopen($zip_file,"rb");
					if ($file) {
					  while(!feof($file)) {
						print(fread($file, 1024*8));
						flush();
						if (connection_status()!=0) {
						  @fclose($file);
						  die();
						}
					  }
					  @fclose($file);
					}
					
					@unlink ($zip_file);
					foreach ($files_to_zip as $k => $v) {	
						@unlink ($v['path']);
					}
					rmdir($dir_path.'/'.$user_dir);
					
				} else {
					return redirect()->route('domains.edit', $id)->withErrors(['error' => 'No files!']);
				}
				
			break;
			
			case "site": 
				
				$dir_path = storage_path('app');
				$dir_path_files = public_path() . "/php";
				$user_dir = $type."_".$ID_users."_".$id;
				
				if (!file_exists($dir_path.'/'.$user_dir)) mkdir($dir_path.'/'.$user_dir , 0777);
				FolderCopy($dir_path_files.'/site', $dir_path.'/'.$user_dir);
				
				$fp = @fopen($dir_path.'/'.$user_dir.'/config.php', "w");
				$string_lang = '<?php
				';
				$string_lang .= ' $UserName = "'.Auth::user()->member_id.'"; 
				';
				$string_lang .= ' $DomainSlug = "'.$domains[0]->slug.'"; 
				';
				$string_lang .= ' $DomainDigi = "'.config('defines.MainTracker').'"; 
				';
				$string_lang .= '
				?>';
				@fwrite($fp, $string_lang);
				@fclose($fp);
				
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/404.php', 'name' => '404.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/digilinks.php', 'name' => 'digilinks.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/digilinks-wp.php', 'name' => 'digilinks-wp.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/index.php', 'name' => 'index.php');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/.htaccess', 'name' => '.htaccess');
				$files_to_zip[] = array ('path' => $dir_path.'/'.$user_dir.'/config.php', 'name' => 'config.php');
				$zip_file = $dir_path.'/'.$user_dir.'/digilinks.zip';
				$result = CreateZip($files_to_zip, $zip_file, 'digilinks', false);

				if ($result) {
					
					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Cache-Control: public");
					header("Content-Description: File Transfer");
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=digilinks.zip');
					header("Content-Transfer-Encoding: binary");
					header('Content-Length:'.@filesize($zip_file));	
					
					$file = @fopen($zip_file,"rb");
					if ($file) {
					  while(!feof($file)) {
						print(fread($file, 1024*8));
						flush();
						if (connection_status()!=0) {
						  @fclose($file);
						  die();
						}
					  }
					  @fclose($file);
					}
					
					@unlink ($zip_file);
					foreach ($files_to_zip as $k => $v) {	
						@unlink ($v['path']);
					}
					rmdir($dir_path.'/'.$user_dir);
					
				} else {
					return redirect()->route('domains.edit', $id)->withErrors(['error' => 'No files!']);
				}
				
			break;
		}
		
    }
	
}






















