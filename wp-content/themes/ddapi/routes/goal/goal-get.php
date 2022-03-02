<?php
function ddapi_goal_get( ) {

	$user = wp_get_current_user();
	if($user->ID === 0) return 403;

	$goals = new WP_Query(array(
		'post_type' => 'goal',
		'post_status' => 'publish',
		'author' => $user->ID
	));
	$goals = $goals->posts;
	if(!count($goals)) return 404;
	$res = array();
	foreach($goals as $goal):
		$res[] = array(
			"ID" => $goal->ID,
			"title" => $goal->post_title,
			"title_weekly" => get_post_meta($goal->ID, "title_weekly", true),
			"goal_type" => get_post_meta($goal->ID, "goal_type", true),
			"weekly_repetitions_goal" => get_post_meta($goal->ID, "weekly_repetitions_goal", true)
		);
	endforeach;
	return json_encode($res);
//	$parsed = json_decode($data->get_body());
//
//	$args = array(
//		'post_type' => 'goal',
//		'post_title' => $parsed->data->title,
//		'post_status' => 'publish'
//	);
//
//	$goal = wp_insert_post($args);
//
//	if(isset($parsed->data->title_weekly)){
//		update_post_meta($goal, 'title_weekly', $parsed->data->title_weekly);
//	}
//
//	if(isset($parsed->data->goal_type)){
//		update_post_meta($goal, 'goal_type', $parsed->data->goal_type);
//		if($parsed->data->goal_type === "Custom repetitions" && isset($parsed->data->weekly_repetitions_goal)){
//			update_post_meta($goal, 'weekly_repetitions_goal', $parsed->data->weekly_repetitions_goal);
//		}
//	}
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/goal(?:/(?P<id>\d+))?', array(
		'methods' => 'GET',
		'callback' => 'ddapi_goal_get',
		'permission_callback' => '__return_true'
	) );
} );