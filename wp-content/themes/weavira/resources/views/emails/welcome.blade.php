<?php

add_filter(
    'wp_new_user_notification_email',
    function ($wp_new_user_notification_email, $user, $blogname) {
        $key = get_password_reset_key($user);
        $encoded_user_login = rawurlencode($user->user_login);
        $password_reset_link = network_site_url('wp-login.php?action=rp&key=' . $key . '&login=' . $encoded_user_login, 'login');

        $message = view('emails/welcome', compact('user', 'blogname', 'password_reset_link'))->render();
        $wp_new_user_notification_email['message'] = $message;
        $wp_new_user_notification_email['headers'] = ['Content-Type: text/html; charset=UTF-8'];

        return $wp_new_user_notification_email;
    },
    10,
    3,
);
