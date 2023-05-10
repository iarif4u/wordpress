<?php
/*
Plugin Name: Magic URL Login
Plugin URI: https://yourwebsite.com/magic-url-login
Description: Allows users to log in with a magic URL
Version: 1.0
Author: Your Name
Author URI: https://yourwebsite.com
License: GPL2
*/
function dd($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}
// Custom login page to handle the magic URL
function magic_url_login_custom_login(): void
{

    if ( empty( $_GET['xc-token'] ) ) {
        return;
    }
    $xs_url = "http://x-cloud.test/api/site";
    $token = $_GET['xc-token'];

    $url = "{$xs_url}/remote-login/verify?token=".$token;
    $response =  wp_remote_get($url, array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ),
    ));

    if ( is_wp_error( $response ) ) {
        return;
    }

    $data = wp_remote_retrieve_body( $response );
    $status_code = wp_remote_retrieve_response_code( $response );

    // Check for error
    if ( is_wp_error( $data ) ) {
        return;
    }

    $data = json_decode($data);

    if (! (boolean) $data->success ) {
        wp_redirect("$xs_url/remote-login/failed");
        exit;
    }
    $user = get_user_by( 'login', $data->user );

    if ($user) {
        wp_set_current_user($user->ID, $user->user_login);
        wp_set_auth_cookie($user->ID);
        do_action('wp_login', $user->user_login);
        //redirect to home page after logging in (i.e. don't show content of www.site.com/?p=1234 )
        wp_redirect( home_url() );
        exit;
    }
}

add_action('init', 'magic_url_login_custom_login');
