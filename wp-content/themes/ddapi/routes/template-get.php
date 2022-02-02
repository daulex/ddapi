<?php
function ddapi_template_get( $data ) {
	$user = wp_get_current_user();
	if($user->ID === 0) return 403;
	$user_template_store = get_user_store($user->ID, "template");


	if($data['id'] === '000'){
		return json_encode(get_templates_by_store($user_template_store));
	}
	return 0;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/template(?:/(?P<id>\d+))?', array(
		'methods' => 'GET',
		'callback' => 'ddapi_template_get',
		'permission_callback' => '__return_true'
	) );
} );