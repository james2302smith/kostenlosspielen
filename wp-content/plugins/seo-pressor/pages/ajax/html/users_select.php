<?php
/**
 * Return Html select with all the WordPress users except the subscribers
 */

$all_users = get_users( array('fields'=>array('ID','user_login')));
$all_users_but_subscribers = array();
foreach ($all_users as $all_users_item) {
	// Ignore if is a "subscriber"
	$user_data = get_userdata( $all_users_item->ID );
	$wp_capabilities = $user_data->wp_capabilities;

	if (key_exists('administrator', $wp_capabilities)
			|| key_exists('editor', $wp_capabilities)
			|| key_exists('author', $wp_capabilities)
			|| key_exists('contributor', $wp_capabilities)
			) {
		$all_users_but_subscribers[] = $all_users_item;
	}
}
?>
<select multiselect="multiselect">
<?php
foreach ($all_users_but_subscribers as $user) {
	?>
	<option value="<?php echo $user->ID?>"><?php echo $user->user_login?></option>
	<?php
}
?>
</select>
<?php die(); ?>