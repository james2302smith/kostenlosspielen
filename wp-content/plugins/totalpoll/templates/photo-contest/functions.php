<?php

if ( !defined('ABSPATH') )
    exit; // Shhh
    
// Enqueue Colorbox
add_action('tp_poll_enqueue_assets', 'tp_pc_enqueue_assets');

function tp_pc_enqueue_assets()
{
    wp_enqueue_script('colorbox', tp_get_template_url('jquery.colorbox.min.js'), array( 'jquery', 'totalpoll' ));
    wp_enqueue_script('tp-photo-contest', tp_get_template_url('helper.min.js'), array( 'colorbox' ));
}

?>