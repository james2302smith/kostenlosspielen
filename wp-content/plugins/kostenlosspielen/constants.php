<?php

if(!defined('KOS_PLUGIN_DIR')) {
    define('KOS_PLUGIN_DIR', dirname(__FILE__));
    define('KOS_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ )));
    define('KOS_API_URL', KOS_PLUGIN_URL.'/api');
    define('KOS_REST_API_URL', KOS_API_URL.'/rest.php');

    define('KOS_FACEBOOK_CLIENT_API', '624253760968467');
    define('KOS_FACEBOOK_CLIENT_SECRET', 'ba35fe9dd93497cd3443ecb86121d91a');
    define('KOS_FACEBOOK_ID_KEY', 'oauth_facebook_id');
    define('KOS_FACEBOOK_PROFILE_ACCESSTOKEN_KEY', 'oauth_facebook_accesstoken');
}