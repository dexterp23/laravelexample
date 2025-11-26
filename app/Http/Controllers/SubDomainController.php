<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\LinksRepository;
use App\Repositories\PagesRepository;
use App\Repositories\DomainsRepository;
use App\Repositories\UserRepository;
use App\Repositories\RpixelsRepository;
use App\Repositories\LinksDataRepository;
use App\Repositories\LinksIpRepository;


class SubDomainController extends Controller
{

	public function __construct( LinksRepository $LinksRepository, PagesRepository $PagesRepository, DomainsRepository $DomainsRepository, UserRepository $UserRepository, RpixelsRepository $RpixelsRepository, LinksDataRepository $LinksDataRepository, LinksIpRepository $LinksIpRepository) {

        $this->LinksRepository = $LinksRepository;
		$this->PagesRepository = $PagesRepository;
		$this->DomainsRepository = $DomainsRepository;
		$this->UserRepository = $UserRepository;
		$this->RpixelsRepository = $RpixelsRepository;
		$this->LinksDataRepository = $LinksDataRepository;
		$this->LinksIpRepository = $LinksIpRepository;
    }
	
    public function index($text_link = false, $account = false, Request $request)
    {
		if ($account) {
			
			$ID_users = 0;
			$domain_default_url = "";
			$domain_pixel_code = "";
			$data = $this->DomainsRepository->getByCname($account);
			if (count($data) > 0) {
				$ID_users = $data[0]->ID_users;
				$domain_default_url = $data[0]->default_url;
				$domain_pixel_code = $data[0]->pixel_code;
			} else {
				$data = $this->UserRepository->getByMemberId($account);
				if (count($data) > 0) {
					$ID_users = $data[0]->id;
				}
			}
			if ($text_link && $ID_users > 0) {
					
				$links = $this->LinksRepository->getByTextLink($ID_users, $text_link);
				if (count($links) > 0) {
					$id_links = $links[0]->id;
					$link_name = $links[0]->name;
					$cloak_url = $links[0]->cloak_url;
					
					$rpixel_chk = $links[0]->rpixel_chk;
					$dates_chk = $links[0]->dates_chk;
					$pages_chk = $links[0]->pages_chk;
					
					$rpixels_id = $links[0]->rpixels_id;
					$pixel_code = '';
					$redirect_url = '';
					
					if ($rpixels_id > 0 && $rpixel_chk == 1) {
						$rpixels = $this->RpixelsRepository->getById($ID_users, $rpixels_id);	
						$pixel_code = $rpixels[0]->code;
					}

					switch ($links[0]->status) {
						case 1: 
							$pixel_code = '';
							$cloak_url = '';
							$id_page = $links[0]->page_id_pending;
							if ($id_page > 0 && $pages_chk == 1) {
								$page = $this->PagesRepository->getById($ID_users, $id_page);
								if (count($page) > 0) {
									$redirect_url = $page[0]->url;
								} else {
									$redirect_url = '';	
								}
							} else {
								$page = $this->PagesRepository->getDef($ID_users, 'panding_def');
								if (count($page) > 0) {
									$redirect_url = $page[0]->url;
								} else {
									$redirect_url = '';	
								}
							}
						break;
						case 2: 
							$timestamp_start = $links[0]->timestamp_start;
							$timestamp_end = $links[0]->timestamp_end;
							$now = time();
							if (($now >= $timestamp_start && $now <= $timestamp_end && $dates_chk == 1) || $dates_chk == 0) {
								$redirect_url = $links[0]->url;
							} else if ($now < $timestamp_start) {
								$pixel_code = '';
								$cloak_url = '';
								$id_page = $links[0]->page_id_pending;
								if ($id_page > 0 && $pages_chk == 1) {
									$page = $this->PagesRepository->getById($ID_users, $id_page);
									if (count($page) > 0) {
										$redirect_url = $page[0]->url;
									} else {
										$redirect_url = '';	
									}
								} else {
									$page = $this->PagesRepository->getDef($ID_users, 'panding_def');
									if (count($page) > 0) {
										$redirect_url = $page[0]->url;
									} else {
										$redirect_url = '';	
									}
								}
							} else if ($now > $timestamp_end) {
								$pixel_code = '';
								$cloak_url = '';
								$id_page = $links[0]->page_id_complete;
								if ($id_page > 0 && $pages_chk == 1) {
									$page = $this->PagesRepository->getById($ID_users, $id_page);
									if (count($page) > 0) {
										$redirect_url = $page[0]->url;
									} else {
										$redirect_url = '';	
									}
								} else {
									$page = $this->PagesRepository->getDef($ID_users, 'complete_def');
									if (count($page) > 0) {
										$redirect_url = $page[0]->url;
									} else {
										$redirect_url = '';	
									}
								}
							}
						break;
						case 3: 
							$pixel_code = '';
							$cloak_url = '';
							$id_page = $links[0]->page_id_complete;
							if ($id_page > 0 && $pages_chk == 1) {
								$page = $this->PagesRepository->getById($ID_users, $id_page);
								if (count($page) > 0) {
									$redirect_url = $page[0]->url;
								} else {
									$redirect_url = '';	
								}
							} else {
								$page = $this->PagesRepository->getDef($ID_users, 'complete_def');
								if (count($page) > 0) {
									$redirect_url = $page[0]->url;
								} else {
									$redirect_url = '';	
								}
							}
						break;
						case 4: 
							$redirect_url = $links[0]->url;
						break;
						case 5: 
							$redirect_url = $links[0]->url;
						break;
					}

					//stats data
					$attributes['ID_users'] = $ID_users;
					$attributes['links_id'] = $id_links;
					$userIP = getUserIpAddr();
					$attributes['ip'] = $userIP;
					
					$click_chk = $this->LinksIpRepository->getByIP($ID_users, $id_links, $userIP); 
					
					if (count($click_chk) > 0 && $request->input('nodata') == null) { 
						$links_data = $this->LinksDataRepository->getByIP($ID_users, $id_links, $userIP);

						$attributes['city'] = $links_data[0]->city;
						$attributes['state'] = $links_data[0]->state;
						$attributes['country'] =$links_data[0]->country;
						$attributes['country_code'] = $links_data[0]->country_code;
						$attributes['continent'] = $links_data[0]->continent;
						$attributes['continent_code'] = $links_data[0]->continent_code;
						$attributes['lat'] = $links_data[0]->lat;
						$attributes['lng'] = $links_data[0]->lng;
						$attributes['timezone'] = $links_data[0]->timezone;
						$attributes['currencyCode'] = $links_data[0]->currencyCode;
						
						$attributes['tier'] = $links_data[0]->tier;
						
						$attributes['browser_name'] =$links_data[0]->browser_name;
						$attributes['browser_version'] = $links_data[0]->browser_version;
						$attributes['os_platform'] = $links_data[0]->os_platform;
						$attributes['timestamp_created'] = time();
					} else { //ako je uniq
						$location = LocatonFromIP($userIP);
						$attributes['city'] = $location['city'];
						$attributes['state'] = $location['state'];
						$attributes['country'] = $location['country'];
						$attributes['country_code'] = $location['country_code'];
						$attributes['continent'] = $location['continent'];
						$attributes['continent_code'] = $location['continent_code'];
						$attributes['lat'] = $location['lat'];
						$attributes['lng'] = $location['lng'];
						$attributes['timezone'] = $location['timezone'];
						$attributes['currencyCode'] = $location['currencyCode'];
						
						$tier = getTier($location['country_code']);
						$attributes['tier'] = $tier;
						
						$browser = getBrowser();
						$attributes['browser_name'] = $browser['name'];
						$attributes['browser_version'] = $browser['version'];
						$attributes['os_platform'] = $browser['platform'];
						$attributes['timestamp_created'] = time();
					}
					
					
					$unique_click = 1;
					if (count($click_chk) > 0 || $attributes['lat'] == 0 || $attributes['lng'] == 0) $unique_click = 0;
					$attributes['click_type'] = $unique_click;

					if ($request->input('nodata') == true) {
						
						//
						
					} else {
						
						$this->LinksRepository->updateClick( $ID_users, $id_links, 'click_total', 1 );
						$this->LinksRepository->updateClick( $ID_users, $id_links, 'click_unique', $unique_click );
						
						if (count($click_chk) == 0) $this->LinksIpRepository->add( $attributes );
						$this->LinksDataRepository->add( $attributes );
						
					}
					//stats data end
					
					if ($request->input('checklink') == true) {
						echo json_encode (array('link_chk' => 'true', 'link_name'=> $link_name, 'redirect_url' => $redirect_url, 'cloak_url' => $cloak_url, 'pixel_code' => $pixel_code));
					} else {
						return view('subdomain.redirect', ['link_name'=> $link_name, 'redirect_url' => $redirect_url, 'cloak_url' => $cloak_url, 'pixel_code' => $pixel_code]);
					}

				} else {
					if ($domain_default_url) {
						if ($request->input('checklink') == true) {
							echo json_encode (array('link_chk' => 'true', 'link_name'=> '', 'redirect_url' => $domain_default_url, 'cloak_url' => '', 'pixel_code' => $domain_pixel_code));
						} else {
							return view('subdomain.redirect', ['link_name'=> '', 'redirect_url' => $domain_default_url, 'cloak_url' => '', 'pixel_code' => $domain_pixel_code]);
						}
					} else {
						echo '<h1 style="text-align: center;margin-top: 50px;">Oops! Something is wrong with this link. Please check your link and try again.</h1>';
					}
					return false;	
				}
				
			} else {
				if ($domain_default_url) {
						if ($request->input('checklink') == true) {
							echo json_encode (array('link_chk' => 'true', 'link_name'=> '', 'redirect_url' => $domain_default_url, 'cloak_url' => '', 'pixel_code' => $domain_pixel_code));
						} else {
							return view('subdomain.redirect', ['link_name'=> '', 'redirect_url' => $domain_default_url, 'cloak_url' => '', 'pixel_code' => $domain_pixel_code]);
						}
					} else {
						echo '<h1 style="text-align: center;margin-top: 50px;">Oops! Something is wrong with this link. Please check your link and try again.</h1>';
					}
				return false;
			}
			
		} else {
			echo '<h1 style="text-align: center;margin-top: 50px;">Oops! Something is wrong with this link. Please check your link and try again.</h1>';
			return false;
		}
        
    }

}
