<?php
function todo_templates_post_type() {
	register_post_type( 'todo_templates',
		array(
			'labels' => array(
				'name' => __( 'Todo templates' ),
				'singular_name' => __( 'Todo template' )
			),
			'public' => true,
			'show_in_rest' => false,
			'supports' => array('title', 'custom-fields')
		)
	);
}
add_action( 'init', 'todo_templates_post_type' );