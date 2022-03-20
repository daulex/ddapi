<?php

function ddapiGetUserEmail( $data ) {
	$user = wp_get_current_user();
	if($user->ID === 0) return 403;
   
    return $user->user_email;
  }

  add_action('rest_api_init', function () {
    register_rest_route('ddapi', '/my-account/', array(
        'methods' => 'GET',
        'callback' => 'ddapiGetUserEmail'
    ));
});


function ddapiPutUserEmail( $data ) {
	$user = wp_get_current_user();
	if($user->ID === 0) return 403;

	$data = $data->get_json_params();
	if(!isset($data['email'])) return 503;

	wp_update_user(array(
		'ID' => $user->ID,
		'user_email' => $data['email']
	));

	return 200;
}

add_action('rest_api_init', function () {
	register_rest_route('ddapi', '/my-account/', array(
		'methods' => 'PUT',
		'callback' => 'ddapiPutUserEmail'
	));
});

function ddapiDeleteUser( $data ) {
	$user = wp_get_current_user();
	if($user->ID === 0) return 403;

	wp_delete_user($user->ID);

	return 200;
}

add_action('rest_api_init', function () {
	register_rest_route('ddapi', '/my-account/', array(
		'methods' => 'DELETE',
		'callback' => 'ddapiDeleteUser'
	));
});