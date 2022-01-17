<?php
function ddapi_todo_update( $data ): int {
	$parsed = json_decode($data->get_body());
	$new = maybe_serialize($parsed->todos);

	update_post_meta( 6, 'todo', $new);

	return 200;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/update-todo', array(
		'methods' => 'PUT',
		'callback' => 'ddapi_todo_update',
		'permission_callback' => '__return_true'
	) );
} );