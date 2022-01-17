<?php
function todos_post_type() {
	register_post_type( 'todo_lists',
		array(
			'labels' => array(
				'name' => __( 'Todo lists' ),
				'singular_name' => __( 'Todo list' )
			),
			'public' => true,
			'show_in_rest' => false,
			'supports' => array('title', 'custom-fields')
		)
	);
}
add_action( 'init', 'todos_post_type' );