<?php
/*
Plugin Name: Kos comments
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display and ajax comments
Author: Nguyen The Tuyen
*/

require_once dirname(__FILE__).'/KosComments.php';
require_once dirname(__FILE__).'/constants.php';

function comment_form_field_comment_emotions($value) {
    echo '<div class="comment-form-comment">';
    echo '  ';
    cs_print_smilies();
    echo '  <label for="comment">' . _x( '&nbsp;', 'noun' ) . '</label>';
    echo '  <br/>';
    echo '  <textarea id="comment" name="comment" cols="45" rows="4" aria-required="true"></textarea>';
    echo '</div>';
    return '';
}
add_filter('comment_form_field_comment', 'comment_form_field_comment_emotions');
