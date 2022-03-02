<?php
function ddapi_goal_create( $data ): int {

	$user = wp_get_current_user();
	if($user->ID === 0) return 403;
//
	$parsed = json_decode($data->get_body());

	var_error_log($parsed);
	$args = array(
		'post_type' => 'goal',
		'post_title' => $parsed->data->title,
		'post_status' => 'publish'
	);

	$goal = wp_insert_post($args);
	if(isset($parsed->data->title_weekly)){
		update_post_meta($goal, 'title_weekly', $parsed->data->title_weekly);
	}
	if(isset($parsed->data->goal_type)){
		update_post_meta($goal, 'goal_type', $parsed->data->goal_type);
		if($parsed->data->goal_type === "Custom repetitions" && isset($parsed->data->weekly_repetitions_goal)){
			update_post_meta($goal, 'weekly_repetitions_goal', $parsed->data->weekly_repetitions_goal);
		}
	}


//	$new = maybe_serialize($parsed->todos);

//	update_post_meta( $user_todo_store, $key, $new);

	return 200;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/goal', array(
		'methods' => 'POST',
		'callback' => 'ddapi_goal_create',
		'permission_callback' => '__return_true'
	) );
} );