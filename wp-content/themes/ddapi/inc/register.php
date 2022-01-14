<?php
function runRegister($data){
    $parsed = json_decode($data->get_body());

    $email = $parsed->username;
    $pass = $parsed->password;

    if(!username_exists($email)){
        $user_id = wp_create_user($email, $pass, $email);
        if (!is_wp_error($user_id)){
            $user = get_user_by('id', $user_id);
            $user->set_role('subscriber');

            $code = md5(time());

            $string = array('id'=>$user_id, 'code'=>$code);
            
            update_user_meta($user_id, 'account_activated', 0);
            update_user_meta($user_id, 'activation_code', $code);

            $url = get_app_url(). '/user/verify/?key=' . base64_encode( serialize($string));

            $html = 'Please click the following link to verify your email for dailyDo.lv <br/><br/> <a href="'.$url.'">'.$url.'</a>';

            wp_mail( $email, __('dailyDo.lv email verification','ddapi') , $html);

            return json_encode(1);
        }
    }

    return json_encode(0);
}

add_action('rest_api_init', function () {
    register_rest_route('ddapi', '/register/', array(
        'methods' => 'POST',
        'callback' => 'runRegister'
    ));
});