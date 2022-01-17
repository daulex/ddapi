<?php

function runVerifyEmail( $data ) {
    $parsed = json_decode($data->get_body());
    $x = maybe_unserialize(base64_decode($parsed->key));
    
    if(
        get_user_meta($x['id'], 'account_activated', true) === "0" && 
        get_user_meta($x['id'], 'activation_code', true) === $x['code']
    ){
        delete_user_meta($x['id'], 'activation_code');
        update_user_meta($x['id'], 'account_activated', 1);
        return json_encode(1);
    }
   
    return json_encode(0);
  }

  add_action('rest_api_init', function () {
    register_rest_route('ddapi', '/verify-email/', array(
        'methods' => 'POST',
        'callback' => 'runVerifyEmail'
    ));
});