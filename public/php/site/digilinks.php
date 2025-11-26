<?php
include_once __DIR__."/config.php";

$Protocol = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== "off"?"https://":"http://";

$uri = $_SERVER["REQUEST_URI"];
$uri = strpos($uri, "?") > 0?substr($uri, 0, strpos($uri, "?")):$uri;
$uri = trim(strtolower($uri));
$uri = rtrim($uri, '/');
$uri_array = explode ("/", $uri);
$uri_count = count ($uri_array);
$LinkName = $uri_array[$uri_count-1];

$ServerURL = $Protocol.$UserName."-".$DomainSlug.".".$DomainDigi."/".$LinkName;

$CheckURL = $ServerURL."?checklink=true";
$jsonString = "";

if(function_exists('curl_version')){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $CheckURL);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_HEADER, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $jsonString = curl_exec($ch);
    curl_close($ch);
}else if(function_exists("file_get_contents")){
    $jsonString = file_get_contents($CheckURL);
}else if(function_exists("stream_get_contents")){
    $jsonString = stream_get_contents(fopen($CheckURL, "rb"));
}

if(!empty($jsonString)){
    $jsonData = json_decode($jsonString);
    if($jsonData->link_chk == "true"){
        $link_name = $jsonData->link_name;
        $redirect_url = $jsonData->redirect_url;
		$pixel_code = $jsonData->pixel_code;
		$cloak_url = $jsonData->cloak_url;
		
		$html .= '<!DOCTYPE html>
					<html>
					<head>
						<meta charset="UTF-8" />
						<meta name="viewport" content="width=device-width" />
						<meta property="og:site_name" content="'.$link_name.'" />
						<meta property="og:title" content="'.$link_name.'" />
						<meta property="og:description" content="'.$link_name.'" />
						<meta property="og:image" content="" />';
						if(!empty($redirect_url) && empty($cloak_url)) {
							$html .= '<meta property="og:url" content="'.$redirect_url.'" />
							<meta http-equiv="refresh" content="0; url='.$redirect_url.'" />';
						}
						$html .= '<title></title>
					</head>
					<body>';
					if (!empty($pixel_code)) $html .= $pixel_code;
					if(!empty($cloak_url) && !empty($redirect_url)) {
						$html .= '<style>
							body {
								margin: 0;
							}
						</style>
						<iframe width="100%" height="100%" src="'.$redirect_url.'" scrolling="auto" frameborder="0" name="'.$link_name.'" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"></iframe>';
					}
					$html .= '</body>
					</html>';
					
		echo $html;
		die();
    }else{
        if(!isset($Disable404))
            include_once __DIR__."/404.php";
    }
}else{
    if(!isset($Disable404))
        include_once __DIR__."/404.php";
}
if(!isset($Disable404))
    die;