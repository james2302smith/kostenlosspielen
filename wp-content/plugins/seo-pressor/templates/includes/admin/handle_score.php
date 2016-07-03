<?php
/**
 * Template to show the Score
 *
 * @package admin-panel
 * @version v5.0
 *
 */
?>
<div class="wrap seopressor-page">
	<div class="icon32" id="icon-edit-pages"><br /></div>
	<h2 class="seopressor-page-header">
		<?php _e('Posts/Pages Score','seo-pressor')?>
		<br />
		<span class="description"><?php _e('This page shows you the score and suggestions for all the posts and pages you have. Also allows you to change the main SEOPressor keyword.','seo-pressor')?></span>
	</h2>
	<div id="seopressor-message-container">
		<?php include( WPPostsRateKeys::$template_dir . '/includes/msg.php'); ?>
	</div> <!-- End Message Dashboard -->

	<?php if ($seopressor_is_active && $seopressor_has_permission) { ?>
		<fieldset>
			<h2 class="seopressor-padding-top-none seopressor-settings-heading">
				<?php _e('To add or edit the keyword you must select a row in the grid below:','seo-pressor')?>
			</h2>
			<div id="seopressor-score-grid-container" class="seopressor-grid">
				<table id="seopressor-score-grid">
				</table>
				<div id="seopressor-score-grid-pager">
				</div>
			</div>
		</fieldset>

		<div id="seopressor-templates-container">
			<div class="seopressor-error-message ui-state-error ui-corner-all" style="padding: 0 0.7em;">
				<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>
				<span class="seopressor-msg-mark"></span></p>
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
