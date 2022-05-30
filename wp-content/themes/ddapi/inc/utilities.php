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

function get_goal_array($goal = false, $history = false){
	if(!$goal) return false;
	return array(
		"ID" => $goal->ID,
		"title" => $goal->post_title,
		"title_weekly" => get_post_meta($goal->ID, "title_weekly", true),
		"goal_type" => get_post_meta($goal->ID, "goal_type", true),
		"weekly_repetitions_goal" => get_post_meta($goal->ID, "weekly_repetitions_goal", true),
		"today" => generate_today_data($goal->ID),
		"weekly_total" => generate_weekly_total($goal->ID),
		"history" => $history ? generate_goal_history($goal->ID) : null
	);
}
function generate_record_key($date = false): string{
	if($date){
		$date = strtotime($date);
	} else {
		$date = strtotime('monday this week');
	}
	return "rr_".date('Y_m_d', $date);
}
function generate_today_data($id){

	$meta_key = generate_record_key();
	$meta_value = maybe_unserialize(get_post_meta($id, $meta_key,true));

	if(is_array($meta_value) && isset($meta_value[date('w')])){
		return $meta_value[date('w')];
	}
	return 0;
}
function generate_weekly_total($id) {
	$meta_key = generate_record_key();
	$meta_value = maybe_unserialize(get_post_meta($id, $meta_key,true));
	if(!is_array($meta_value)){ return 0; }
	$sum = 0;
	foreach($meta_value as $value):
		$sum += intval($value);
	endforeach;
	return $sum;
}
function generate_goal_history($id) {
	if(!$id) return false;
	$keys = get_post_custom_keys($id);
	$res = array();
	foreach($keys as $key):
		if(is_string($key) && substr($key, 0,3) === "rr_"):
			$res[$key] = maybe_unserialize(get_post_meta($id, $key,true));
		endif;
	endforeach;
	return $res;
}