<?php

function generate_username_from_email($email = false){
    if(!$email)
        return false;
    $email = preg_replace("/[^a-z0-9]+/", "", trim(strtolower($email)));

    return $email . rand(1,10000);
}

function var_error_log( $object=null ){
    ob_start();                    
    var_dump( $object );           
    $contents = ob_get_contents(); 
    ob_end_clean();                
    error_log( $contents );        
}

function get_app_url(){
    if(get_site_url() === "http://ddapi.awave.site"){
        return "http://localhost:3000";
    }
    return "https://app.dailydo.lv";
}

function get_user_store($user_id = false, $what = "todo") {
	if(!$user_id) return false;

	$labels = array(
		"todo" => array('todo_store', 'todo_lists'),
		"template" => array('template_store', 'todo_templates')
	);

	// check if store exists
	$store = get_user_meta($user_id, $labels[$what][0], true);

	// if no store, create one
	if(!$store){
		$new_store = array(
			'post_title'    => $what . ' ' . $user_id,
			'post_status'   => 'publish',
			'post_author'   => $user_id,
			'post_type'     => $labels[$what][1]
		);

		$store = wp_insert_post( $new_store );
		update_user_meta($user_id, $labels[$what][0], $store);
	}

	return intval($store);
}

function get_todo_label($date = false): string {
	$format = 'Ymd';
	$prefix = 'todo_';

	if(!$date) return $prefix . date($format);
	return $prefix . date($format, strtotime($date));
}