<?php
function ddapi_goal_update( $data ): int {

	$user = wp_get_current_user();
	if($user->ID === 0) return 403;
	$post = get_post($data['id']);
	$parsed = $data->get_json_params();

	if($user->ID !== intval($post->post_author)) return 403;

	$data = array(
		'ID' => $post->ID,
		'post_title' => $data['title'],
		'meta_input' => array(
			'title_weekly' => $parsed['title_weekly'],
			'goal_type' => $parsed['goal_type'],
			'weekly_repetitions_goal' => $parsed['weekly_repetitions_goal'],
		)
	);

	wp_update_post( $data );

	return 200;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/goal(?:/(?P<id>\d+))?', array(
		'methods' => 'PUT',
		'callback' => 'ddapi_goal_update',
		'permission_callback' => '__return_true'
	) );
} );