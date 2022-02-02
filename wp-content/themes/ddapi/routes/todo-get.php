<?php
function ddapi_todo_get( $data ) {
	$user = wp_get_current_user();
	if($user->ID === 0) return 403;
	$user_todo_store = get_user_store($user->ID);

	if(!isset($data['id'])){
		$key = get_todo_label();

		$todo = get_post_meta( $user_todo_store, $key, true);
		if($todo === ""){
			$res = 404;
		}else{
			$res = json_encode(maybe_unserialize($todo));
		}
		return $res;
	}

	if($data['id'] === '000'){
		return json_encode(get_todos_by_store($user_todo_store));
	}

	$todo_id = intval($data['id']);
	$todo = get_post_meta( $user_todo_store, 'todo_'.$todo_id, true);
	if($todo === "") return 404;
	return json_encode(maybe_unserialize($todo));

}

add_action( 'rest_api_init', function () {
	register_rest_route( 'ddapi', '/todo(?:/(?P<id>\d+))?', array(
		'methods' => 'GET',
		'callback' => 'ddapi_todo_get',
		'permission_callback' => '__return_true'
	) );
} );