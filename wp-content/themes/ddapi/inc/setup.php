<?php
// disable normal wp api
remove_action('rest_api_init', 'create_initial_rest_routes', 99);

// disable user errors
function no_wordpress_errors(): string {
	return 'Something is wrong!';
}
add_filter( 'login_errors', 'no_wordpress_errors' );


//function add_cors_http_header(){
//  header("Access-Control-Allow-Origin: *");
//}
//add_action('plugins_loaded','add_cors_http_header');