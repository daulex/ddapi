<?php

function ddapi_goal_delete( $data ): int {
	$post = get_post(intval($data['id']));
	if(!$post) return 404;

	$user = wp_get_current_user();
	if($user->ID === 0 || intval($post->post_author) !== $user->ID) return 403;

	return !!wp_delete_post($post->ID, true) === true ? 200 : 500;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/goal(?:/(?P<id>\d+))?', array(
		'methods' => 'DELETE',
		'callback' => 'ddapi_goal_delete',
		'permission_callback' => '__return_true'
	) );
} );