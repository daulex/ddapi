<?php

function ddapiGetUserEmail() {
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


function ddapiPutUserEmail( $data ): int {
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

function ddapiDeleteUser(): int {
	$user = wp_get_current_user();
	if($user->ID === 0) return 403;

	$goals = new WP_Query(array(
		'author' => $user->ID,
		'post_type' => 'goal',
		'fields' => 'ids'
	));
	$goals = $goals->posts;
	foreach($goals as $goal):
		wp_delete_post($goal, true);
	endforeach;



	require_once( ABSPATH.'wp-admin/includes/user.php' );
	wp_delete_user($user->ID);

	return 200;
}

add_action('rest_api_init', function () {
	register_rest_route('ddapi', '/my-account/', array(
		'methods' => 'DELETE',
		'callback' => 'ddapiDeleteUser'
	));
});