<?php
/**
 * Template to show the plugin Internal Links page
 *
 * @package admin-panel
 * @version	v5.0
 *
 */
?>
<div class="wrap seopressor-page">
	<div class="icon32" id="icon-link-manager"><br /></div>
	<h2 class="seopressor-page-header">
		<?php _e('Internal Links','seo-pressor')?>
		<br />
		<span class="description"><?php _e('This page let you configure the internal links.','seo-pressor')?></span>
	</h2>
	<div id="seopressor-message-container">
		<?php include( WPPostsRateKeys::$template_dir . '/includes/msg.php'); ?>
	</div> <!-- End Message Dashboard -->

	<?php if ($seopressor_is_active && $seopressor_has_permission) { ?>
		<fieldset>
			<legend>
				<div class="seopressor-grid-actions-bar">
					<button class="seopressor-grid-add-button"><strong><?php _e('Click to Add','seo-pressor')?></strong>&nbsp;<?php _e('Internal Link','seo-pressor')?></button>
				</div>
			</legend>
			<div id="seopressor-automatic-internal-link-grid-container" class="seopressor-grid">
				<table id="seopressor-automatic-internal-link-grid">
				</table>
				<div id="seopressor-automatic-internal-link-grid-pager">
				</div>
			</div>
		</fieldset>
	<?php } ?>
</div>