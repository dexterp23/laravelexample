<?php
/*
Plugin Name: DigiLinks
Plugin URI: 
Description: DigiLinks WP Plugin.
Version: 1.0.1
Author: DigiLinks Team
Author URI: http://www.digistore24.com/
*/

function digilink_redirect() {
    global $wp_query;

	if(is_404()){
        status_header( 200 );
        $wp_query->is_404=false;
        $Disable404 = true;
        include_once __DIR__."/digilinks.php";
        //die();
    }
}
add_filter('template_redirect', 'digilink_redirect' );