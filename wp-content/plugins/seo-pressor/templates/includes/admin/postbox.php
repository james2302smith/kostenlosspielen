<?php
/**
 * Template to show the SEOPressor postbox.
 *
 * @uses	int			$post_id
 *
 * @uses	array 		$all_in_box
 * @uses	int			$all_in_box_item['keyword_id']
 * @uses	string		$all_in_box_item['keyword_tab_title']
 *
 * @uses	float		$all_in_box_item['box_score']
 * @uses	float		$all_in_box_item['box_keyword_density']
 *
 * @uses	string		$all_in_box_item['box_keyword']
 * @uses	string		$all_in_box_item['box_keyword_density_status']			1- Positive, 0- Negative
 * @uses	string		$all_in_box_item['box_keyword_density_message']
 *
 * @uses	array		$all_in_box_item['box_decoration_suggestions_arr']
 * @uses	int			$box_decoration_suggestions_arr_item[0]					1- Positive, 0- Negative
 * @uses	string		$box_decoration_suggestions_arr_item[1] 				Text with a suggestions like "Please add your keyword in the first sentence."
 *
 * @uses	array		$all_in_box_item['box_url_suggestions_arr']
 * @uses	int			$box_url_suggestions_arr_item[0]						1- Positive, 0- Negative
 * @uses	string		$box_url_suggestions_arr_item[1] 						Text with a suggestions like "Please add your keyword in the first sentence."
 *
 * @uses	array		$all_in_box_item['box_content_suggestions_arr']
 * @uses	int			$box_content_suggestions_arr_item[0]					1- Positive, 0- Negative
 * @uses	string		$box_content_suggestions_arr_item[1] 					Text with a suggestions like "Please add your keyword in the first sentence."
 *
 * @uses	Checkbox	$all_in_box_item['key_in_first_sentence']				1- Keyword is present in first sentence
 * @uses	Checkbox	$all_in_box_item['key_in_last_sentence']				1- Keyword is present in last sentence
 *
 * @uses	Checkbox	$settings['allow_meta_keyword']
 * @uses	Radio		$settings['use_for_meta_keyword']						Values are: categories, tags, seopressor_keywords
 * @uses	Checkbox	$settings['allow_meta_description']
 * @uses	string		$settings['meta_description']
 *
 * @package admin-panel
 * @version v5.0
 *
 */
?>
<?php if ($seopressor_is_active && $seopressor_has_permission) { ?>
	<span id="seopressor-plugin-url" class="ui-helper-hidden"><?php echo WPPostsRateKeys::$plugin_url; ?></span>
	<span id="seopressor-post-id" class="ui-helper-hidden"><?php echo $post_id; ?></span>
	<div class="seopressor-overlay-container">
		<div class="seopressor-overlay"></div>
		<div class="seopressor-loader-container">
			<img src='<?php echo get_bloginfo ( 'wpurl' ) . '/wp-includes/js/thickbox/loadingAnimation.gif'; ?>' />
		</div>
	</div>
	<div class="seopressor-top-message">
		<?php _e('You may optimize ','seo-pressor');?><strong><?php _e('up to 3','seo-pressor');?></strong><?php _e(' keywords.','seo-pressor');?>
		<br />
		<?php _e('Click on ','seo-pressor');?><strong><?php _e('"+"','seo-pressor');?></strong><?php _e(' to add keyword.','seo-pressor');?>
	</div>

	<div id="seopressor-keyword-list">
		<ul>
			<li class="seopressor-keyword-field-item">
				<label for="seopressor-keyword-field-item-input-initial">Type to add a keyword.</label>
				<input type="text" value="" name="seopressor_keywords[]" id="seopressor-keyword-field-item-input-initial">
				<span title="" class="seopressor-control seopressor-icon-add"></span>
			</li>
		</ul>
	</div>

	<?php foreach ($all_in_box as $all_in_box_item) {?>
		<?php if ($all_in_box_item['keyword_id'] == 1) { ?>
		<div id="seopressor-main">
			<div class="seopressor-refresh-container" onclick="return false;">
				<button class="seopressor-button" id="refresh-postbox">
					<span class="seopressor-icon seopressor-icon-refresh"></span>
					<?php _e('Click to Refresh the Analysis','seopressor')?>
				</button>
			</div>

			<div class="seopressor-score-boxes-container">
				<div class="seopressor-score-box-block seopressor-score-box-block-score">
					<div class="seopressor-score-box-header">
						<?php _e('Score','seopressor')?>
					</div>
					<div class="seopressor-score-box <?php echo ($all_in_box_item['box_score'] >= 86 && $all_in_box_item['box_score'] <= 100)?'seopressor-positive':'seopressor-negative'?>">
						<span class="seopressor-score-text">
							<?php _e('0','seopressor')?>
						</span>
						</div>
				</div>

				<div class="seopressor-score-box-block seopressor-score-box-block-keyword-density">
					<div class="seopressor-score-box-header">
						<?php _e('Keyword Density','seopressor')?>
					</div>
					<div class="seopressor-score-box <?php echo ($all_in_box_item['box_keyword_density_status'] == 1)?'seopressor-positive':'seopressor-negative'?>">
						<span class="seopressor-score-text"><?php _e('0','seopressor')?>
						<span class="seopressor-percent"><?php _e('%','seopressor')?></span>
						</span>
					</div>
				</div>
				<br class="seopressor-clearfloat" />
			</div>

			<div class="seopressor-tabs seopressor-bottom-content-container ui-helper-hidden">
				<ul>
					<li class="seopressor-suggestions-tab">
						<a href="#seopressor-suggestions"><?php _e('Suggestions','seo-pressor');?></a>
					</li>
					<li class="seopressor-content-tab">
						<a href="#seopressor-content"><?php _e('Content','seo-pressor');?></a>
					</li>
				</ul>
				<br class="clearfix" />

				<div id="seopressor-suggestions">
					<!--<div class="seopressor-suggestion-heading <?php if (!count($all_in_box_item['score_less_than_100_arr'])) { echo 'ui-helper-hidden'; } ?>">
						<?php _e('Filter suggestions','seo-pressor');?>
					</div>-->
					<select class="seopressor-suggestion-heading" id="seopressor-suggestions-filter" name="seopressor_suggestions_filter">
						<option value="keyword-decoration"><?php _e('Keyword Decoration','seo-pressor');?></option>
						<option value="url"><?php _e('URL','seo-pressor');?></option>
						<option value="content"><?php _e('Content','seo-pressor');?></option>
					</select>

					<div id="seopressor-suggestions-keyword-decoration" class="seopressor-suggestion-container seopressor-suggestion-container-specific">
					</div><!-- end #seopressor-suggestions-keyword-decoration -->

					<div id="seopressor-suggestions-url" class="seopressor-suggestion-container seopressor-suggestion-container-specific">
					</div><!-- end #seopressor-suggestions-url -->

					<div id="seopressor-suggestions-content" class="seopressor-suggestion-container seopressor-suggestion-container-specific">
					</div><!-- end #seopressor-suggestions-content -->

					<div class="seopressor-suggestion-heading">
						<?php _e('Get your 100% easily','seo-pressor');?>
					</div>
					<div id="seopressor-suggestions-score-less-than-100" class="seopressor-suggestion-container seopressor-suggestion-container-general <?php if (!count($all_in_box_item['score_less_than_100_arr'])) { echo 'ui-helper-hidden'; } ?>">
					</div><!-- end #seopressor-suggestions-score-less-than-100 -->

					<div class="seopressor-suggestion-heading">
						<?php _e('Possible Over-Optimization Detected','seo-pressor');?>
					</div>
					<div id="seopressor-suggestions-score-more-than-100" class="seopressor-suggestion-container seopressor-suggestion-container-general <?php if (!count($all_in_box_item['score_more_than_100_arr'])) { echo 'ui-helper-hidden'; } ?>">
					</div><!-- end #seopressor-suggestions-score-more-than-100 -->

					<div class="seopressor-suggestion-heading">
						<?php _e('Over-Optimization Warning','seo-pressor');?>
					</div>
					<div id="seopressor-suggestions-score-over-optimization" class="seopressor-suggestion-container seopressor-suggestion-container-general <?php if (!count($all_in_box_item['score_over_optimization_arr'])) { echo 'ui-helper-hidden'; } ?>">
					</div><!-- end #seopressor-suggestions-score-over-optimization -->
				</div><!-- end #seopressor-suggestions -->

				<div id="seopressor-content">
					<div class="seopressor-tabs">
						<ul>
							<li class="seopressor-content-lsi-tab">
								<a href="#seopressor-content-lsi"><?php _e('LSI','seo-pressor');?></a>
							</li>
							<li class="seopressor-content-videos-tab">
								<a href="#seopressor-content-videos"><?php _e('Videos','seo-pressor');?></a>
								<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
							</li>
						</ul>

						<div id="seopressor-content-lsi">
							<!--<div class="seopressor-lsi-heading ">
								<?php _e('Filter LSI by keyword','seo-pressor') ?>
							</div>-->
							<select class="seopressor-lsi-heading" id="seopressor-lsi-filter" name="seopressor_lsi_filter">
							</select>
							<div id="seopressor_lsi_filter_mark"></div>
						</div><!-- end #seopressor-content-lsi -->

						<div id="seopressor-content-videos">
							<div class="seopressor-align-center">
								<button id="seopressor-get-videos-button" class="seopressor-button" onclick="return false;">
									<span class="seopressor-icon seopressor-icon-search"></span>
									<?php _e('<strong>Click to Search</strong> Related Videos','seo-pressor');?>
								</button>
							</div>
							<select class="seopressor-videos-heading" id="seopressor-videos-filter" name="seopressor_videos_filter">
							</select>
							<div id="seopressor_videos_filter_mark"></div>
						</div><!-- end #seopressor-content-videos -->
					</div>
				</div><!-- End #seopressor-content -->
			</div>
		</div><!-- End #seopressor-keyword-<?php echo $all_in_box_item['keyword_id'] ?> -->
		<?php } ?>
	<?php } ?>
	<div id="seopressor-templates-container">
		<div class="seopressor-keyword-field">
			<li>
				<label for=""><?php _e('Type to add a keyword.','seo-pressor');?></label>
				<input type="text" id="" name="seopressor_keywords[]" value="" disabled="disabled" />
				<span class="seopressor-control" title=""></span>
			</li>
		</div>
	</div>
<?php } elseif ($seopressor_is_active && !$seopressor_has_permission) { // The plugin is active but user not have required capabilities ?>
	<div class="seopressor-top-message seopressor-state-inactive">
		<?php _e('<strong>SEOPressor permission denied.</strong><br />You can check this with WordPress or SEOPressor plugin administrator.','seo-pressor');?>
	</div>
<?php } else { // The plugin is not active. ?>
	<div class="seopressor-top-message seopressor-state-inactive">
		<?php _e('SEOPressor is <strong>inactive</strong>.<br />For more information, please visit ','seo-pressor');?><a target="_blank" " href="<?php echo get_bloginfo ( 'wpurl' ) . '/wp-admin/admin.php?page=seo-pressor.php#seopressor-requirements'; ?>"><?php _e('Settings','seo-pressor');?></a><?php _e('.','seo-pressor');?>
	</div>
<?php } ?>