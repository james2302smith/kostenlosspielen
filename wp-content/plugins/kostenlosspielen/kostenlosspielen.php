<?php
/*
Plugin Name: Kostenlosspielen.biz
Plugin URI: http://www.kostenlosspielen.biz/
Description: Plugin for Kostenlosspielen.biz site
Author: Nguyen The Tuyen
*/

require_once( dirname( dirname( dirname( dirname( __FILE__ )))) . '/wp-load.php' );

$PLUGIN_DIR = dirname(__FILE__);
require_once $PLUGIN_DIR.'/constants.php';
require_once $PLUGIN_DIR.'/widgets/widgets.php';
require_once $PLUGIN_DIR.'/ui/KosUIHelper.php';
require_once $PLUGIN_DIR.'/feed/loader.php';

//require_once KOSTENLOSSPIELEN_PLUGIN_DIR.'/api/rest.php';

function get_current_url() {
    global $wp;
    $current_url = home_url(add_query_arg(array(),$wp->request));
    return $current_url;
}

add_filter('get_avatar', 'social_filter_avatar', 10, 5);
function social_filter_avatar($avatar, $id_or_email, $size, $default, $alt) {
    $useId = (!is_integer($id_or_email) && !is_string($id_or_email) && get_class($id_or_email)) ? $id_or_email->user_id : $id_or_email;
    if(!empty($useId)) {
        //. FacebookID
        $fbId = get_user_meta($useId, KOS_FACEBOOK_ID_KEY, true);
        if($fbId) {
            $size_label = 'large';
            if($size <= 100)
                $size_label = 'normal';
            else if($size <= 50)
                $size_label = 'small';

            $custom_avatar = "http://graph.facebook.com/$fbId/picture?type=$size_label";
            $avatar = '<img class="avatar" src="'.$custom_avatar.'" style="width:'.$size.'px;" alt="'.$alt.'" />';
        } else if(strpos($avatar, "gravatar.com/avatar") !== false) {
            $sex = get_user_meta($useId, 'sex', true);
            if($sex) {
                $image = SITE_ROOT_URL.'/wp-content/themes/twentyten/image/male.png';
                if($sex == 'female') {
                    $image = SITE_ROOT_URL.'/wp-content/themes/twentyten/image/female.png';
                }
                $avatar = '<img class="avatar" src="'.$image.'" style="width:'.$size.'px;" alt="'.$alt.'" />';
            }
        }
    }

    return $avatar;
}

/**
 * Prevent normal user access to /wp-admin
 */
add_action( 'init', 'blockusers_init' );
function blockusers_init() {
    if ( is_admin() && !current_user_can('administrator') && !(defined( 'DOING_AJAX' ) && DOING_AJAX)) {
        if(is_user_logged_in()) {
            wp_redirect(home_url());
            exit;
        }
    }
}
