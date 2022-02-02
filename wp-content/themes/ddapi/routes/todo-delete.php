<?php

function ddapi_todo_delete( $data ) {
	$user = wp_get_current_user();
	if($user->ID === 0 || !isset($data['id'])) return 403;
	$user_todo_store = get_user_store($user->ID);

	$todo_id = intval($data['id']);

	return json_encode(delete_post_meta( $user_todo_store, 'todo_'.$todo_id));
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/todo(?:/(?P<id>\d+))?', array(
		'methods' => 'DELETE',
		'callback' => 'ddapi_todo_delete',
		'permission_callback' => '__return_true'
	) );
} );