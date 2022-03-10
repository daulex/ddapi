<?php
function ddapi_goal_record( $data ): int {


	// add record
//	$week[date('w')] = 1;

	$user = wp_get_current_user();
	if($user->ID === 0) return 403;
	$post = get_post($data['id']);

	if($user->ID !== intval($post->post_author)) return 403;


	$parsed = $data->get_json_params();
	$record_value = 1;
	$meta_key = generate_record_key();
	$meta_value = maybe_unserialize(get_post_meta($post->ID, $meta_key,true));
	if($parsed){
		var_error_log($parsed);
	}
	if(!$meta_value){
		$meta_value = array();
	}
	$meta_value[date('w')] = $record_value;
	$meta_value = maybe_serialize($meta_value);

	update_post_meta($post->ID,$meta_key,$meta_value);

	var_error_log($meta_value);
//	$data = array(
//		'ID' => $post->ID,
//		'post_title' => $data['title'],
//		'meta_input' => array(
//			'title_weekly' => $parsed['title_weekly'],
//			'goal_type' => $parsed['goal_type'],
//			'weekly_repetitions_goal' => $parsed['weekly_repetitions_goal'],
//		)
//	);
//
//	wp_update_post( $data );
//
	return 200;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/goal/record(?:/(?P<id>\d+))?', array(
		'methods' => 'POST',
		'callback' => 'ddapi_goal_record',
		'permission_callback' => '__return_true'
	) );
} );