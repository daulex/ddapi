<?php 
remove_action('rest_api_init', 'create_initial_rest_routes', 99);



function no_wordpress_errors(){
    return 'Something is wrong!';
  }
add_filter( 'login_errors', 'no_wordpress_errors' );

function my_awesome_func( $data ) {
    $posts = get_posts( array(
    //   'author' => $data['id'],
    ) );
   
    if ( empty( $posts ) ) {
      return null;
    }
   
    return json_encode(wp_get_current_user());
  }

add_action( 'rest_api_init', function () {
    register_rest_route( 'myplugin/v1', '/author/(?P<id>\d+)', array(
      'methods' => 'GET',
      'callback' => 'my_awesome_func',
    ) );
  } );

function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('init','add_cors_http_header');