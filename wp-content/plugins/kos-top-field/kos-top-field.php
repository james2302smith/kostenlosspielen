<?php
/*
Plugin Name: Kos Top Field
Plugin URI: http://www.kostenlosspielen.biz/
Description: Add text to top feild
Version: 1.0
Author: Duongpq
License: GPLv2 or later
Text Domain: kostenlosspielen
*/

/*
 * category
 */

// them my category vao list
function manage_my_category_columns($columns)
{
 // add 'My Column'
 $columns['my_column'] = 'Top Field';

 return $columns;
}
add_filter('manage_edit-category_columns','manage_my_category_columns');

// hien thi category
function manage_category_custom_fields($deprecated,$column_name,$term_id)
{
	if ($column_name == 'my_column') {
        echo get_option( "category_top_field_$term_id");
	}
}
add_filter ('manage_category_custom_column', 'manage_category_custom_fields', 10,3);

//them category tu edit category
add_action ( 'edit_category_form_fields', 'edit_extra_category_fields');
function edit_extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id;
    $cat_meta = get_option( "category_top_field_$t_id");
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="extra1"><?php _e('Top field'); ?></label></th>
        <td>
            <input type="text" name="Cat_meta" id="Cat_meta" size="25" style="width:60%;" value="<?php echo $cat_meta ? htmlspecialchars($cat_meta) : ''; ?>"><br />
            <span class="description"><?php _e('extra top field'); ?></span>
        </td>
    </tr>
<?php
}

// add category tư add form
add_action ( 'category_add_form_fields', 'add_extra_category_fields');
function add_extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id;
    $cat_meta = get_option( "category_top_field_$t_id");
    ?>
    <div class="form-field">
        <label for="extra1"><?php _e('Top field'); ?></label>
        <input type="text" name="Cat_meta" id="Cat_meta" size="40" value="<?php echo $cat_meta ? htmlspecialchars($cat_meta) : ''; ?>"><br />
        <p class="description"><?php _e('Extra top field'); ?></p>
    </div>
<?php
}

// save extra category
add_action ( 'edited_category', 'save_extra_category_fileds');
add_action ( 'create_category', 'save_extra_category_fileds');
function save_extra_category_fileds( $term_id ) {
    if ( isset( $_POST['Cat_meta'] ) ) {
        $t_id = $term_id;
        $cat_data = stripslashes(trim($_POST['Cat_meta']));
        //save the option array
        update_option( "category_top_field_$t_id", $cat_data );
    }
}

// delete extra category
add_action ( 'delete_category', 'delete_extra_category_fileds');
function delete_extra_category_fileds( $term_id ) {
    delete_option("category_top_field_$term_id");
}

/*
 * home
 */

// add button
add_action( 'admin_init' , 'admin_register_fields' );
function admin_register_fields() {
    register_setting( 'general', 'home_top_field', '' );
    add_settings_field('home_top_field', '<label for="home_top_field">'.__('Home Top Field' , 'home_top_field' ).'</label>', 'admin_fields_html', 'general');
}
function admin_fields_html() {
    $value = get_option( 'home_top_field', '' );
    echo '<input type="text" id="home_top_field" name="home_top_field" class="regular-text" value="' . htmlspecialchars($value) . '" />';
}

/*
 * post
 */

add_action( 'add_meta_boxes', 'add_extra_field_post' );
function add_extra_field_post() {
	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box( 'c3m_meta', 'Top Field Text', 'add_extra_field_post_meta', $screen, 'side', 'high' );

	}
    //add_meta_box( 'c3m_meta', 'Top Field Text', 'add_extra_field_post_meta', 'post', 'side', 'high' );
}

function add_extra_field_post_meta( $post ) {
    $text = get_post_meta( $post->ID, '_top_field_text', true);
    //echo 'Add top field text';
    ?>
    <input type="text" name="top_field_text"  style="width:100%" value="<?php echo htmlspecialchars($text); ?>" />
<?php
}

add_action( 'save_post', 'save_extra_field_post' );
function save_extra_field_post( $post_ID ) {
    global $post;
    if( $post->post_type == "post" || $post->post_type == "page" ) {
        if (isset( $_POST ) ) {
            update_post_meta( $post_ID, '_top_field_text', $_POST['top_field_text'] );
        }
    }
}
?>