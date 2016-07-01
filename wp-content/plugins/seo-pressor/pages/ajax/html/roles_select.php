<?php
/**
 * Return Html select with all the SEOPressor Custom Roles
 */

$arr_custom_roles = WPPostsRateKeys_RolesCapabilities::get_all('custom','role_type','','%s');
?>
<select multiselect="multiselect">
<?php
foreach ($arr_custom_roles as $arr_custom_roles_item) {
	?>
	<option value="<?php echo $arr_custom_roles_item->id?>"><?php echo $arr_custom_roles_item->role_name?></option>
	<?php
}
?>
</select>
<?php die(); ?>