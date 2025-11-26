<?php

if (!function_exists('URLFix')) {
	function URLFix($url) {
	
		$remove_string = parse_url($url, PHP_URL_PATH);
		if ($remove_string && $remove_string  != $url && $remove_string != "/" && $remove_string != "//") $url = strstr($url, $remove_string, true);
		if (strpos($url, '#') !== false) $url = strstr($url, '#', true);
		if (strpos($url, '?') !== false) $url = strstr($url, '?', true);
		if (strpos($url, '&') !== false) $url = strstr($url, '&', true);
		$url = trim($url, '/');
		
		return $url;
		
	}
}


if (!function_exists('DomainFix')) {
	function DomainFix($url) {
	
		$domain = preg_replace('#^http(s)?://#', '', $url);
		$domain = preg_replace('/www\./i', '', $domain);
		if (strpos($domain, '/') !== false) $domain = strstr($domain, '/', true);
		if (strpos($domain, '#') !== false) $domain = strstr($domain, '#', true);
		if (strpos($domain, '?') !== false) $domain = strstr($domain, '?', true);
		if (strpos($domain, '&') !== false) $domain = strstr($domain, '&', true);
		
		return $domain;
		
	}
}


if (!function_exists('SubDomainFix')) {
	function SubDomainFix($domain) {
	
		$subdomain = preg_replace("/[^A-Za-z0-9 ]/","", $domain);
		
		return $subdomain;
		
	}
}


if (!function_exists('AddonDomain')) {
	function AddonDomain($domain, $subdomain, $action) {
		
		/* ### API ### 
			https://documentation.cpanel.net/display/DD/cPanel+API+2+Functions+-+AddonDomain%3A%3Adeladdondomain
			https://documentation.cpanel.net/display/DD/cPanel+API+2+Functions+-+Email%3A%3Achangemx
			https://api.docs.cpanel.net/whm/tokens/#php
		*/
		
		$HostUser = config('defines.HostUser');
		$MainDomen = config('defines.MainDomen');
		$MainTracker = config('defines.MainTracker');
		
		switch ($action) {
			case "add": 
				$query = "https://174-136-57-21.cprapid.com:2087/json-api/cpanel?cpanel_jsonapi_user=".$HostUser."&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=AddonDomain&cpanel_jsonapi_func=addaddondomain&dir=/public_html/public&newdomain=".$domain."&subdomain=".$subdomain."";
				$query_mail = "https://174-136-57-21.cprapid.com:2087/json-api/cpanel?cpanel_jsonapi_user=".$HostUser."&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Email&cpanel_jsonapi_func=changemx&domain=".$domain."&exchange=mail.".$domain."&oldexchange=mail.".$domain."&oldpreference=5&preference=15&alwaysaccept=remote";
			break;
			case "delete": 
				$query = "https://174-136-57-21.cprapid.com:2087/json-api/cpanel?cpanel_jsonapi_user=".$HostUser."&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=AddonDomain&cpanel_jsonapi_func=deladdondomain&domain=".$domain."&subdomain=".$subdomain.".".$MainDomen."";
			break;
		}
		
		$user = "root";
		$token = config('defines.WHM_API_TOKEN');
		$return = '';
		
		if ($domain != $MainTracker && $domain != $MainDomen) {
			
			$return = WhmApiCurl($user, $token, $query);
			if ($action == "add") WhmApiCurl($user, $token, $query_mail);
			
		}
		
		return $return;
		
	}
}


if (!function_exists('WhmApiCurl')) {
	function WhmApiCurl($user, $token, $query) {

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		
		$header[0] = "Authorization: whm $user:$token";
		curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
		curl_setopt($curl, CURLOPT_URL, $query);
		
		$result = curl_exec($curl);
		
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if ($http_status != 200) {
			return false;
		} else {
			$json = json_decode($result);
			return true;
		}

	}
}



if (!function_exists('ToTimestamp')) {
	function ToTimestamp($date, $type, $timezone) {

		$date_array = explode ("-", $date);
		$date_array = explode ("-", $date);
		$timezone_array = explode (".", $timezone);
		$timezone_min = 0;
		if (!empty ($timezone_array[1])) {
			if ($timezone_array[1] == 5) $timezone_min = 30;
			if ($timezone_array[1] == 75) $timezone_min = 45;
		}
		if ($timezone < 0) $timezone_min = $timezone_min * (-1);
		
		if ($type == "start") {
			return mktime(00-($timezone_array[0]), 00-($timezone_min), 00, $date_array[1], $date_array[2], $date_array[0]);
		} else if ($type == "end") {
			return mktime(00-($timezone_array[0]), 00-($timezone_min), 00, $date_array[1], $date_array[2]+1, $date_array[0]);
		}
		
	}
}

if (!function_exists('GMTtoTimezone')) {
	function GMTtoTimezone($time, $timezone) {
		$timezone_array = explode (".", $timezone);
		$timezone_min = 0;
		if (!empty ($timezone_array[1])) {
			if ($timezone_array[1] == 5) $timezone_min = 30;
			if ($timezone_array[1] == 75) $timezone_min = 45;
		}
		if ($timezone < 0) $timezone_min = $timezone_min * (-1);
		
		return $time + ($timezone_array[0]*60*60) + ($timezone_min*60);
	}
}

if (!function_exists('DateFromDateRange')) {
	function DateFromDateRange($user_timezone) {
		$timezone_array = explode (".", $user_timezone);
		$timezone_min = 0;
		if (!empty ($timezone_array[1])) {
			if ($timezone_array[1] == 5) $timezone_min = 30;
			if ($timezone_array[1] == 75) $timezone_min = 45;
		}
		if ($user_timezone < 0) $timezone_min = $timezone_min * (-1);	
		
		return mktime(date('G') + $timezone_array[0], date('i') + $timezone_min, date('s'), date('m')-0, date('d')-6, date('Y'));
	}
}

if (!function_exists('CreateZip')) {
	function CreateZip($files = array(),$destination = '',$dir = '',$overwrite = false) {
		
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite) { return false; }
		//vars
		$valid_files = array();
		//if files were passed in...
		if(is_array($files)) {
			//cycle through each file
			foreach($files as $file) {
				//make sure the file exists
				if(file_exists($file['path'])) {
					$valid_files[] = array ('path' => $file['path'], 'name' => $file['name']);
				}
			}
		}

		//if we have good files...
		if(count($valid_files)) {
			//create the archive
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			if ($dir) $zip->addEmptyDir($dir);
			//add the files
			foreach($valid_files as $file) {
				$file_dest = $file['name'];
				if ($dir) $file_dest = $dir.'/'.$file['name'];
				$zip->addFile($file['path'], $file_dest);
			}
			//debug
			//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
			
			//close the zip -- done!
			$zip->close();

			//check to make sure the file exists
			return file_exists($destination);
		}
		else
		{
			return false;
		}
	}
}

if (!function_exists('FolderCopy')) {
	function FolderCopy($source, $target) {
		if ( is_dir( $source ) ) {
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry; 
				if ( is_dir( $Entry ) ) {
					FolderCopy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
	
			$d->close();
		}else {
			copy( $source, $target );
		}
	}
}

if (!function_exists('getTier')) {
	function getTier($country_code) {
		$tier = 5;
		$x_country = DB::table('x_country')->where('country_code', $country_code)->first();
		if (isset($x_country->country_code)) {
			$tier = $x_country->tier;
		}
	   	return $tier;
	}
}

if (!function_exists('getBrowser')) {
	function getBrowser () {
		
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$ub = 'Unknown';
		$platform = 'Unknown';
		$version= "";
	
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'Linux';
		}
		elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
			$platform = 'Mac';
		}
		elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
			$platform = 'Windows';
		}
		elseif (preg_match('/ubuntu/i', $u_agent)) {
			$platform = 'Ubuntu';
		}
		elseif (preg_match('/iphone/i', $u_agent)) {
			$platform = 'Iphone';
		}
		elseif (preg_match('/ipod/i', $u_agent)) {
			$platform = 'Ipod';
		}
		elseif (preg_match('/ipad/i', $u_agent)) {
			$platform = 'Ipad';
		}
		elseif (preg_match('/android/i', $u_agent)) {
			$platform = 'Android';
		}
		elseif (preg_match('/blackberry/i', $u_agent)) {
			$platform = 'Blackberry';
		}
		elseif (preg_match('/webos/i', $u_agent)) {
			$platform = 'Mobile';
		}
	   
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
			$ub = "Netscape";
		}
		elseif(preg_match('/edge/i',$u_agent))
		{
			$bname = 'Edge';
			$ub = "Edge";
		}
		elseif(preg_match('/maxthon/i',$u_agent))
		{
			$bname = 'Maxthon';
			$ub = "Maxthon";
		}
		elseif(preg_match('/konqueror/i',$u_agent))
		{
			$bname = 'Konqueror';
			$ub = "Konqueror";
		}
		elseif(preg_match('/mobile/i',$u_agent))
		{
			$bname = 'Handheld Browser';
			$ub = "Handheld Browser";
		}
	   
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
	   
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
	   
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
	   
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
		
	}
}

if (!function_exists('LocatonFromIP')) {
	function LocatonFromIP ($ipAddr) {
		
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		
		//$ipAddr = '144.168.157.33'; //test
		
		
		//api.ipregistry.co (ovaj se placa)
		@$xml = json_decode(file_get_contents("https://api.ipregistry.co/".$ipAddr ."?key=4q4mv70ue98ud70d")); //?key=tryout
		
		$lat = @$xml->location->latitude;
		$lng = @$xml->location->longitude;
		if (!$lat) $lat = 0;
		if (!$lng) $lng = 0;
		
		$output = array(
                        "city"           => @$xml->location->city,
                        "state"          => @$xml->location->region->name,
                        "country"        => @$xml->location->country->name,
                        "country_code"   => @$xml->location->country->code,
                        "continent"      => @$xml->location->continent->name,
                        "continent_code" => @$xml->location->continent->code,
						"lat" => $lat,
						"lng" => $lng,
						"timezone" => @$xml->time_zone->id,
						"currencyCode" => @$xml->currency->code
                    );
		
		return $output;
		
	}
}

if (!function_exists('getUserIpAddr')) {
	function getUserIpAddr () {
		
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
		   $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		   $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
		   $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		   $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
		   $ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
		   $ipaddress = $_SERVER['REMOTE_ADDR'];
		else
		   $ipaddress = 'UNKNOWN';    
		return $ipaddress;
		
	}
}

if (!function_exists('GetOffset')) {
	function GetOffset ($timeZone) {
		
		$dtz = new DateTimeZone($timeZone);
		$time_in = new DateTime('now', $dtz);
		$offset = $dtz->getOffset( $time_in ) / 3600;
		$offset = ($offset < 0 ? $offset : "+".$offset);
		
		return $offset;
		
	}
}

if (!function_exists('randomNum')) {
	function randomNum ($number=false) {
		
		$random = hash('md5' , microtime ());
		if ($number) $random = substr($random, -$number, $number);
		
		return $random;
		
	}
}

if (!function_exists('isPublish')) {
	function isPublish() {
	   return auth()->user()->publish === 1;
	}
}

if (!function_exists('isAdmin')) {
	function isAdmin() {
	   return auth()->user()->role === 'admin';
	}
}

if (!function_exists('isUser')) {
	function isUser() {
	   return auth()->user()->role === 'user';
	}
}



