<?php
function ddapi_goal_create( $data ): int {

	$user = wp_get_current_user();
	if($user->ID === 0) return 403;

	$parsed = $data->get_json_params();

	$args = array(
		'post_type' => 'goal',
		'post_title' => $parsed['title'],
		'post_status' => 'publish'
	);

	$goal = wp_insert_post($args);

	if(isset($parsed['title_weekly'])){
		update_post_meta($goal, 'title_weekly', $parsed['title_weekly']);
	}

	if(isset($parsed['goal_type'])){
		update_post_meta($goal, 'goal_type', $parsed['goal_type']);
		if($parsed['goal_type'] === "Custom repetitions" && isset($parsed['weekly_repetitions_goal'])){
			update_post_meta($goal, 'weekly_repetitions_goal', $parsed['weekly_repetitions_goal']);
		}
	}

	return 200;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/goal', array(
		'methods' => 'POST',
		'callback' => 'ddapi_goal_create',
		'permission_callback' => '__return_true'
	) );
} );