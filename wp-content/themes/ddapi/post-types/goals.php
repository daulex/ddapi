<?php
function goals_post_type() {
	register_post_type( 'goal',
		array(
			'labels' => array(
				'name' => __( 'Goals' ),
				'singular_name' => __( 'Goal' )
			),
			'public' => true,
			'show_in_rest' => false,
			'supports' => array('title', 'custom-fields')
		)
	);
}
add_action( 'init', 'goals_post_type' );