<?php
/**
 * Template to show the plugin Make Money page
 *
 * @uses 	Checkbox		$data['allow_seopressor_footer']		1- Enable SEOPressor attribution link at the footer.
 *
 * @uses 	string			$data['footer_text_color']
 * @uses 	string			$data['clickbank_id']					SEOPressor Clickbank affiliate ID
 * @uses 	string			$data['seo_link_text']
 * @uses 	string			$data['name_link_text']
 * @uses 	string			$data['footer_tags_before']
 * @uses 	string			$data['footer_tags_after']
 *
 * @uses	Submit			submit_make_money
 *
 * @package admin-panel
 * @version	v5.0
 *
 */
?>
<div class="wrap seopressor-page">
	<div class="icon32" id="icon-dollar"><br /></div>
	<h2 class="seopressor-page-header">
		<?php _e('Make Money','seo-pressor')?>
		<br />
		<span class="description"><?php _e('This page lets you configure settings to make money via SEOPressor Affiliate Program.','seo-pressor')?></span>
	</h2>
	<div id="seopressor-message-container">
		<?php include( WPPostsRateKeys::$template_dir . '/includes/msg.php'); ?>
	</div> <!-- End Message Dashboard -->

	<?php if ($seopressor_is_active && $seopressor_has_permission) { ?>
		<form action="" method="post" class="seopressor-ajax-form">
			<div class="seopressor-container">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row" nowrap="nowrap">
								<label for="seopressor-allow-seopressor-footer">
									<?php _e('Add SEOPressor Attribution Link at the footer of the blog','seo-pressor'); ?>
								</label>
							</th>
						<td>
							<input type="checkbox" id="seopressor-allow-seopressor-footer" name="allow_seopressor_footer" value="1" <?php echo ($data['allow_seopressor_footer']=='1')?'checked="checked"':''?> />
								<label for="seopressor-allow-seopressor-footer">
									<span class="description"><?php _e('Check if you want earn money through us.','seo-pressor'); ?></span>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row" nowrap="nowrap">
								 <label for="seopressor-footer-text-color"><?php _e('Affiliate Link Color','seo-pressor'); ?></label>
							</th>
							<td>
								<input type="text" name="footer_text_color" id="seopressor-footer-text-color" value="<?php echo $data['footer_text_color']; ?>" />
								<div id="seopressor-footer-text-color-selector"></div>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="seopressor-clickbank-id">
									<?php _e('ClickBank ID','seo-pressor');?>
								</label>
							</th>
							<td>
								<label>
									<input type="text" id="seopressor-clickbank-id" name="clickbank_id" value="<?php echo $data['clickbank_id']?>" />
									<span class="description"><?php _e('Add your ClickBank Affiliate ID into the box. If you do not have a ClickBank ID, it\'s free to ','seo-pressor'); ?><a target="_blank" href="http://clickbank.com"><?php _e('sign up','seo-pressor'); ?></a><?php _e('.','seo-pressor'); ?></span>
								</label>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="seopressor-footer-tags-before">
									<?php _e('Tags before and after the link (optional)','seo-pressor');?>
								</label>
							</th>
							<td>
								<div id="seopressor-footer-preview">
									<input type="text" id="seopressor-footer-tags-before" class="seopressor-align-right" value="<?php echo $data['footer_tags_before']?>" size="20" name="footer_tags_before" />
									<label><?php _e('Wordpress ','seo-pressor');?><?php echo $data['seo_link_text'] ?><?php _e(' Plugin by ','seo-pressor');?>&nbsp;<?php echo $data['name_link_text'] ?>
									<input type="text" value="<?php echo $data['footer_tags_after']?>" size="20" name="footer_tags_after" /></label>
								</div>
							</td>
						</tr>
						<tr>
							<th scope="row" nowrap="nowrap">
								<label for="seopressor-allow-advertising-program">
									<?php _e('Participate in SEOPressor\'s Advertising Program','seo-pressor'); ?>
								</label>
							</th>
							<td>
								<input type="checkbox" id="seopressor-allow-advertising-program" name="allow_advertising_program" value="1" <?php echo ($data['allow_advertising_program']=='1')?'checked="checked"':''?> />
								<label for="seopressor-allow-advertising-program">
									<br />
									<span class="description"><?php _e('We will have your visitors\' browsers cookied to serve them SEOPressor banners.','seo-pressor'); ?></span>
									<br />
									<span class="description"><?php _e('If they purchase SEOPressor following the banners, <strong>you will earn a commission</strong> too!','seo-pressor'); ?></span>
									<br />
									<span class="description"><?php _e('Best part, <strong>we pay</strong> for the advertisement.','seo-pressor'); ?></span>
									<br />
									<span class="description"><?php _e('Just <strong>enable this</strong> to earn from our effort!','seo-pressor'); ?></span>
								</label>
							</td>
						</tr>
						<tr class="seopressor-submit-tr">
							<th scope="row"></th>
							<td>
								<button type="submit" class="seopressor-button" name="submit_make_money"><?php _e('Save Settings','seo-pressor') ?></button>
								<span class="seopressor-ajax-loader-container">
									<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
		<div id="seopressor-templates-container">
			<div class="seopressor-error-message ui-state-error ui-corner-all" style="padding: 0 0.7em;">
				<p>
					<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>
					<div class="seopressor-msg-mark"></div>
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