<?php
function runRetrivePassword($data){
    global $wpdb, $wp_hasher;
    $user_data = get_user_by('email',  $data['email']);
    if (!$user_data) return array('result' => true);

    do_action('lostpassword_post');
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    $key = get_password_reset_key($user_data);
    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
    $message .= "dailyDo.lv" . "\r\n";
    $message .= sprintf(__('Account email: %s'), $user_email) . "\r\n\r\n";
    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
    // $message .= network_site_url("wp-login.php?action=rp&to=$key&em=" . rawurlencode($user_login), 'login');

    $message .= '/user/reset/?em='.rawurlencode($user_email).'&to='.$key;



    $title = __('DailyDo.lv Password Reset');
    $title = apply_filters('retrieve_password_title', $title);
    $message = apply_filters('retrieve_password_message', $message, $key);

    wp_mail($user_email, $title, $message);

    return array('result' => true);
}

add_action('rest_api_init', function () {
    register_rest_route('ddapi', '/reset-password/(?P<email>\S+)', array(
        'methods' => 'GET',
        'callback' => 'runRetrivePassword'
    ));
});