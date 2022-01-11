<?php 
include("inc/reset-password.php");

remove_action('rest_api_init', 'create_initial_rest_routes', 99);


function no_wordpress_errors(){
    return 'Something is wrong!';
  }
add_filter( 'login_errors', 'no_wordpress_errors' );

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

  function var_error_log( $object=null ){
    ob_start();                    // start buffer capture
    var_dump( $object );           // dump the values
    $contents = ob_get_contents(); // put the buffer into a variable
    ob_end_clean();                // end capture
    error_log( $contents );        // log contents of the result of var_dump( $object )
}


  function ddapi_update_todo( $data ) {
    $parsed = json_decode($data->get_body());
    $cache = maybe_serialize($parsed->todosCache);
    $new = maybe_serialize($parsed->todos);
    
    update_post_meta( 6, 'todo', $new);
    
    return 200;
  }

  add_action( 'rest_api_init', function () {
    register_rest_route( 'ddapi', '/update-todo', array(
      'methods' => 'PUT',
      'callback' => 'ddapi_update_todo',
  'permission_callback' => '__return_true'
    ) );
  } );

function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('init','add_cors_http_header');



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