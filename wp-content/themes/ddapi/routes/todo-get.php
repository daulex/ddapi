<?php
function my_awesome_func( $data ) {
	// $posts = get_posts( array(
	// //   'author' => $data['id'],
	// ) );

	// if ( empty( $posts ) ) {
	//   return null;
	// }

	return json_encode(maybe_unserialize(get_post_meta( 6, 'todo', true)));

	// return json_encode(wp_get_current_user());
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'myplugin/v1', '/author/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'my_awesome_func',
		'permission_callback' => '__return_true'
	) );
} );