<?php
function ddapi_todo_update( $data ): int {

	$user = wp_get_current_user();
	if($user->ID === 0) return 403;

	if(!isset($data['id'])){

		$key = get_todo_label();
		$user_todo_store = get_user_store($user->ID, "todo");
		$parsed = json_decode($data->get_body());

		$new = maybe_serialize($parsed->todos);

		update_post_meta( $user_todo_store, $key, $new);

		return 200;
	}

	return 403;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/update-todo', array(
		'methods' => 'PUT',
		'callback' => 'ddapi_todo_update',
		'permission_callback' => '__return_true'
	) );
} );