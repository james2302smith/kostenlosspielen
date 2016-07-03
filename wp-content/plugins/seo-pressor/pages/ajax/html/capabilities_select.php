<?php
/**
 * Return Html select with all the SEOPressor capabilities
 */

$arr_capability = WPPostsRateKeys_Capabilities::get_all();
?>
<select multiselect="multiselect">
<?php
if (isset($_REQUEST['select_toolbar']) && $_REQUEST['select_toolbar']=='true') {
	?>
	<option value=""><?php echo __('All','seo-pressor');?></option>
	<?php
}

foreach ($arr_capability as $arr_capability_key=>$arr_capability_names) {
	?>
	<option value="<?php echo $arr_capability_key?>"><?php echo $arr_capability_names[0]?></option>
	<?php
}
?>
</select>
<?php die(); ?>
