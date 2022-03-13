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

function get_app_url(): string {
    if(get_site_url() === "http://ddapi.awave.site"){
        return "http://localhost:3000";
    }
    return "https://app.dailydo.lv";
}

function get_goal_array($goal = false){
	if(!$goal) return false;
	return array(
		"ID" => $goal->ID,
		"title" => $goal->post_title,
		"title_weekly" => get_post_meta($goal->ID, "title_weekly", true),
		"goal_type" => get_post_meta($goal->ID, "goal_type", true),
		"weekly_repetitions_goal" => get_post_meta($goal->ID, "weekly_repetitions_goal", true),
		"today" => generate_today_data($goal->ID),
		"weekly_total" => generate_weekly_total($goal->ID)
	);
}
function generate_record_key($date = false): string{
	if($date){
		$date = strtotime($date);
	} else {
		$date = time();
	}
	return "r".date("yW", $date);
}
function generate_today_data($id){

	$meta_key = generate_record_key();
	$meta_value = maybe_unserialize(get_post_meta($id, $meta_key,true));

	if(is_array($meta_value) && isset($meta_value[date('w')])){
		return $meta_value[date('w')];
	}
	return 0;
}
function generate_weekly_total($id): int {
	$meta_key = generate_record_key();
	$meta_value = maybe_unserialize(get_post_meta($id, $meta_key,true));
	if(!is_array($meta_value)){ return 0; }
	$sum = 0;
	foreach($meta_value as $value):
		$sum += intval($value);
	endforeach;
	return $sum;
}