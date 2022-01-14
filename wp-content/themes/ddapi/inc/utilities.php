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