<?php

if(!defined('KOS_PLUGIN_DIR')) {
    define('KOS_PLUGIN_DIR', dirname(__FILE__));
    define('KOS_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ )));
    define('KOS_API_URL', KOS_PLUGIN_URL.'/api');
    define('KOS_REST_API_URL', KOS_API_URL.'/rest.php');

    define('KOS_FACEBOOK_CLIENT_API', '1125629600830878');
    define('KOS_FACEBOOK_CLIENT_SECRET', 'f20a787147b5aa16aaaceed1bee94820');
    define('KOS_FACEBOOK_ID_KEY', 'oauth_facebook_id');
    define('KOS_FACEBOOK_PROFILE_ACCESSTOKEN_KEY', 'oauth_facebook_accesstoken');

    define('KOS_GOOGLE_CLIENT_API', '1017100044792-detb1os4cgugifhvh1cbv6579vj3cov4.apps.googleusercontent.com');
    define('KOS_GOOGLE_CLIENT_SECRET', 'EGOqkqXNeUdMUkAfq_758yFY');
    define('KOS_GOOGLE_ID_KEY', 'oauth_google_id');
    define('KOS_GOOGLE_PROFILE_ACCESSTOKEN_KEY', 'oauth_google_accesstoken');
}