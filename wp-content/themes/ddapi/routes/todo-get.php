<?php
function ddapi_todo_get( $data ) {
	$user = wp_get_current_user();
	if($user->ID === 0) return 403;

	if(!isset($data['id'])){
		// GET Today's todo if one exists
		$key = get_todo_label();
		$user_todo_store = get_user_store($user->ID, "todo");
		$todo = get_post_meta( $user_todo_store, $key, true);
		if($todo === ""){
			$res = 404;
		}else{
			$res = json_encode(maybe_unserialize($todo));
		}
		return $res;
	}

	if($data['id'] === '000'){
		return "TODO: Get all todos for current user";
	}
	$todo_id = intval($data['id']);
	return "TODO: Get todo with ID: " . $todo_id;

	// $posts = get_posts( array(
	// //   'author' => $data['id'],
	// ) );

	// if ( empty( $posts ) ) {
	//   return null;
	// }



//	 return json_encode($user->ID === 0);

	//	return json_encode(maybe_unserialize(get_post_meta( 6, 'todo', true)));
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/todo/get(?:/(?P<id>\d+))?', array(
		'methods' => 'GET',
		'callback' => 'ddapi_todo_get',
		'permission_callback' => '__return_true'
	) );
} );