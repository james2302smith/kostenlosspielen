<?php
/**
 * Template to show the plugin Role Settings page
 *
 * @uses 	Checkbox		data['enable_role_settings']		1- Enable roles support.
 *
 * @uses 	array			$capabilities_desc_arr
 * @uses 	array			$capabilities_desc_arr_item[0]		Capability name
 * @uses 	array			$capabilities_desc_arr_item[1]		Capability description
 *
 * @uses	Submit			submit_role_settings
 *
 * @package admin-panel
 * @version	v5.0
 *
 */
?>
<div class="wrap seopressor-page">
	<div class="icon32" id="icon-ms-admin"><br /></div>
	<h2 class="seopressor-page-header">
		<?php _e('Role Settings','seo-pressor')?>
		<br />
		<span class="description"><?php _e('This page let you configure what SEOPressor\' sections users can access to.','seo-pressor')?></span>
	</h2>
	<div id="seopressor-message-container">
		<?php include( WPPostsRateKeys::$template_dir . '/includes/msg.php'); ?>
	</div> <!-- End Message Dashboard -->

	<?php if ($seopressor_is_active && $seopressor_has_permission) { ?>
		<div class="seopressor-tabs">
			<ul>
				<li><a href="#seopressor-role-settings-general"><?php _e('General Settings','seo-pressor');?></a></li>
				<li><a href="#seopressor-role-settings-wordpress-roles"><?php _e('WordPress Roles','seo-pressor');?></a></li>
				<li><a href="#seopressor-role-settings-custom-roles"><?php _e('Custom Roles','seo-pressor');?></a></li>
			</ul>
			<div id="seopressor-role-settings-general" class="ui-corner-top">
				<form action="" method="post" class="seopressor-ajax-form">
					<table class="form-table">
						<tbody>
							<tr>
								<th>
									<label for="seopressor-role-settings">
										<?php _e('Enable Roles Support','seo-pressor'); ?>
									</label>
								</th>
								<td>
									<label for="seopressor-role-settings">
										<input type="checkbox" id="seopressor-role-settings" name="enable_role_settings" value="1" <?php echo ($data['enable_role_settings']=='1')?'checked="checked"':''?> />
										<span class="description"><?php _e('Check if you want SEOPressor to be restricted to certain roles. If disabled, everyone can use SEOPressor.','seo-pressor'); ?></span>
									</label>
								</td>
							</tr>
							<tr class="seopressor-submit-tr">
								<th></th>
								<td>
									<button type="submit" class="seopressor-button" name="submit_role_settings"><?php _e('Save Settings','seo-pressor') ?></button>
									<span class="seopressor-ajax-loader-container">
										<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div id="seopressor-role-settings-wordpress-roles" class="ui-corner-top">
				<h2 class="seopressor-settings-heading">
					<?php _e('Capabilities List','seo-pressor')?>
				</h2>
				<table cellspacing="0" class="widefat">
					<tbody>
						<?php $index=0; foreach ($capabilities_desc_arr as $capabilities_desc_arr_item) { ?>
							<tr <?php echo ($index%2 == 0)?'class="alternate"':''?>>
								<td class="import-system row-title"><?php echo $capabilities_desc_arr_item[0] ?></td>
								<td class="desc"><?php echo $capabilities_desc_arr_item[1] ?></td>
							</tr>
						<?php $index++; } ?>
					</tbody>
				</table>
				<br />
				<fieldset>
					<legend>
						<div class="seopressor-grid-actions-bar">
						</div>
					</legend>
					<h2 class="seopressor-padding-top-none seopressor-settings-heading">
						<?php _e('Set the capabilities that will have each Wordpress role enabling or restricting SEOPressor functionalities to users:','seo-pressor')?>
					</h2>
					<div id="seopressor-manage-wordpress-roles-grid-container" class="seopressor-grid">
						<table id="seopressor-manage-wordpress-roles-grid">
						</table>
						<div id="seopressor-manage-wordpress-roles-grid-pager">
						</div>
					</div>
				</fieldset>
			</div>
			<div id="seopressor-role-settings-custom-roles" class="ui-corner-top">
				<h2 class="seopressor-settings-heading">
					<?php _e('Capabilities List','seo-pressor')?>
				</h2>
				<table cellspacing="0" class="widefat">
					<tbody>
						<?php $index=0; foreach ($capabilities_desc_arr as $capabilities_desc_arr_item) { ?>
							<tr <?php echo ($index%2 == 0)?'class="alternate"':''?>>
								<td class="import-system row-title"><?php echo $capabilities_desc_arr_item[0] ?></td>
								<td class="desc"><?php echo $capabilities_desc_arr_item[1] ?></td>
							</tr>
						<?php $index++; } ?>
					</tbody>
				</table>
				<br />
				<fieldset>
					<legend>
						<div id="seopressor-grid-actions-bar-custom-roles" class="seopressor-grid-actions-bar">
							<button class="seopressor-grid-add-button"><strong><?php _e('Click to Add','seo-pressor')?></strong>&nbsp;<?php _e('Custom Role','seo-pressor')?></button>
						</div>
					</legend>
					<h2 class="seopressor-padding-top-none seopressor-settings-heading">
						<?php _e('Create new custom roles and set its capabilities:','seo-pressor')?>
					</h2>
					<div id="seopressor-manage-custom-roles-grid-container" class="seopressor-grid">
						<table id="seopressor-manage-custom-roles-grid">
						</table>
						<div id="seopressor-manage-custom-roles-grid-pager">
						</div>
					</div>
				</fieldset>
				<br /><br />
				<fieldset>
					<legend>
						<div id="seopressor-manage-user-custom-roles-grid-container" class="seopressor-grid-actions-bar">
							<button class="seopressor-grid-add-button"><strong><?php _e('Click to Add','seo-pressor')?></strong>&nbsp;<?php _e(' Roles to User','seo-pressor')?></button>
						</div>
					</legend>
					<h2 class="seopressor-padding-top-none seopressor-settings-heading">
						<?php _e('Associate users with the created custom roles enabling or restricting SEOPressor functionalities to users:','seo-pressor')?>
					</h2>
					<div id="seopressor-manage-user-custom-roles-grid-container" class="seopressor-grid">
						<table id="seopressor-manage-user-custom-roles-grid">
						</table>
						<div id="seopressor-manage-user-custom-roles-grid-pager">
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		<div id="seopressor-templates-container">
			<div class="seopressor-error-message ui-state-error ui-corner-all" style="padding: 0 0.7em;">
				<p>
					<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>
					<span class="seopressor-msg-mark"></span>
				</p>
			</div>
			<div class="seopressor-notification-message ui-state-highlight ui-corner-all seopressor-positive seopressor-position-relative" style="padding: 0 0.7em;">
				<span class="seopressor-icon-suggestion-type"></span>
				<p>
					<span class="seopressor-msg-mark"></span>
				</p>
			</div>
		</div>
	<?php } ?>
</div>

