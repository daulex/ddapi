<?php
function ddapi_goals_history_get($data) {

	$user = wp_get_current_user();
	if($user->ID === 0) return 403;
	if(isset($data['id'])){
		$post = get_post($data['id']);
		if($user->ID !== intval($post->post_author)) return 403;
		$res = get_goal_array($post, true);
	}else {
		$goals = new WP_Query( array(
			'post_type'   => 'goal',
			'post_status' => 'publish',
			'author'      => $user->ID
		) );
		$goals = $goals->posts;
		if ( ! count( $goals ) ) {
			return 404;
		}
		$res = array();
		foreach ( $goals as $goal ):
			$res[] = get_goal_array( $goal, true );
		endforeach;
	}
	return json_encode($res);

}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/goals-history(?:/(?P<id>\d+))?', array(
		'methods' => 'GET',
		'callback' => 'ddapi_goals_history_get',
		'permission_callback' => '__return_true'
	) );
} );