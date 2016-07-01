<?php
/**
 * Template to show the Settings page.
 *
 * TAB: Automatic Decorations
 * @uses 	Checkbox	$data['allow_add_keyword_in_titles']			1- Add Keyword in Post titles
 *
 * @uses 	Checkbox	$data['enable_convertion_post_slug']			1- Convert Posts Slugs into SEO friendly removing common words
 * @uses 	string		$data['post_slugs_stop_words']
 *
 * @uses 	Checkbox	$data['allow_bold_style_to_apply']				1- Apply bold style to keyword
 * @uses 	Radio		$data['bold_style_to_apply']
 * @uses 	array		$bold_arr
 * @uses 	Checkbox	$data['allow_italic_style_to_apply']			1- Apply italic style to keyword
 * @uses 	Radio		$data['italic_style_to_apply']
 * @uses 	array		$italic_arr
 * @uses 	Checkbox	$data['allow_underline_style_to_apply']			1- Apply underline style to keyword
 * @uses 	Radio		$data['underline_style_to_apply']
 * @uses 	array		$underline_arr
 *
 * @uses 	Radio		$data['image_alt_tag_decoration']				Can be "empty", "all" and "none"
 * @uses	string		$data['alt_attribute_structure']
 * @uses 	Radio		$data['image_title_tag_decoration']				Can be "empty", "all" and "none"
 * @uses	string		$data['title_attribute_structure']
 *
 * @uses 	array		$tags_desc_arr
 * @uses 	array		$tags_desc_arr_item[0]							Tag name
 * @uses 	array		$tags_desc_arr_item[1]							Tag description
 *
 * @uses 	Checkbox	$data['allow_automatic_adding_rel_nofollow']	1- Add rel="nofollow" to external links
 * @uses 	Checkbox	$data['auto_add_rel_nofollow_img_links']		1- Add rel="nofollow" to image links
 *
 * @uses	Submit		submit_automatic_decorations					Save Settings
 *
 * TAB: Tags
 * @uses 	Checkbox	$data['enable_tagging_using_google']			1- Enable tagging based on Google Suggestions and Search
 * @uses 	int			$data['max_number_tags']						Specify up to how many tags should be added
 * @uses 	Radio		$data['append_tags']							0- Overwrite tags, 1- Append tags
 * @uses 	Checkbox	$data['to_retrieve_keywords_use_post_title']	1- Use post title
 * @uses 	Checkbox	$data['to_retrieve_keywords_use_post_content']	1- Use post content
 * @uses 	string		$data['blacklisted_tags']						Comma separated values of blacklisted tags
 * @uses 	string		$data['generic_tags']							Comma separated values of generic tags
 *
 * @uses	Submit		submit_tags										Save Settings
 *
 * TAB: Advanced
 * @uses 	array		$all_locales									List of available languages
 * @uses 	Radio		$analize_full_page								1- SEOPressor will analyze the full page (default), 0- SEOPressor will analyze the content area only
 * @uses	int			$data['h1_tag_already_in_theme']				1- Theme uses H1 Tags in Headings
 * @uses	int			$data['h2_tag_already_in_theme']				1- Theme uses H2 Tags in Headings
 * @uses	int			$data['h3_tag_already_in_theme']				1- Theme uses H3 Tags in Headings
 *
 * @uses	string		$data['minimum_score_to_publish']
 * @uses	int			$data['enable_special_characters_to_omit']
 * @uses	string		$data['special_characters_to_omit']
 *
 * @uses 	string		$data['lsi_bing_api_key']						API Key for the Bing API
 * @uses 	array		$data['lsi_language']							Language selected for the LSI API calls
 *
 * @uses	Submit		submit_advanced									Save Settings
 * @uses	Submit		submit_advanced_validate_api_key				Validate API Key
 *
 * TAB: Requirements
 * @uses 	int	   		$data['active']									1- The plugin is active.
 * @uses 	int	   		$data['allow_manual_reactivation']
 * @uses 	string		$msg_status										Message about plugin activation Status
 * @uses	Submit		submit_activation
 * @uses	Submit		submit_activation_now
 * @uses 	array		$requirement_msg_arr
 * @uses 	array		$requirement_msg_arr_item[0]					0- The message is negative
 * @uses 	array		$requirement_msg_arr_item[1]					The requirement message
 * @uses 	array		$plugin_domains									List of domains which the plugin can be active
 * @uses 	array		$plugin_domains_item
 * @uses 	int			$plugin_in_valid_domain							1- The plugin is in a valid domain
 *
 * @uses	Submit		submit_activation
 * @uses	Submit		submit_reactivation
 *
 * TAB: Plugin Update
 * @uses 	int			$plugin_is_active								1- The plugin is active.
 * @uses 	string		$file_list_msg
 * @uses 	array		$file_list
 * @uses 	string		$file_list_item
 * @uses 	int			$need_upgrade
 * @uses 	int			$write_permission_requirement					1- Has write permission
 * @uses 	int			$outgoing_connection_requirement				1- Has outgoing connection permission
 * @uses 	int			$zip_archive_requirement						1- Has zip archive permission
 *
 * @uses	Submit		submit_upgrade
 *
 * @package admin-panel
 * @version v5.0
 *
 */
?>
<div class="wrap seopressor-page">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2 class="seopressor-page-header">
		<?php _e('Settings','seo-pressor')?>
		<br />
		<span class="description"><?php _e('This page shows you the settings for the plugin.','seo-pressor')?></span>
	</h2>
	<div id="seopressor-message-container">
		<?php include( WPPostsRateKeys::$template_dir . '/includes/msg.php'); ?>
	</div>
	<?php if ($seopressor_has_permission) { ?>
	<div class="seopressor-tabs" style="visibility:hidden" id="seopressor-settings-tabs">
		<ul>
			<?php if ($seopressor_is_active) { ?>
				<li><a href="#seopressor-automatic-decorations"><?php _e('Automatic SEO','seo-pressor');?></a></li>
				<li><a href="#seopressor-tags"><?php _e('Tags','seo-pressor');?></a></li>
				<li><a href="#seopressor-advanced"><?php _e('Advanced','seo-pressor');?></a></li>
			<?php } ?>
			<li><a href="#seopressor-requirements"><?php _e('Requirements','seo-pressor');?></a></li>
			<?php if ($seopressor_is_active) { ?>
				<li><a href="#seopressor-upgrade"><?php _e('Plugin Update','seo-pressor');?></a></li>
			<?php } ?>
		</ul>
		<?php if ($seopressor_is_active) { ?>
			<div id="seopressor-automatic-decorations" class="ui-corner-top">
				<form action="" method="post" class="seopressor-ajax-form">
					<?php wp_nonce_field('WPPostsRateKeys-save-settings');?>

					<div class="seopressor-tabs-second-lvl" id="seopressor-automatic-decorations-tabs">
						<ul>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-automatic-decoration-post-titles">
									<span class="seopressor-icon seopressor-icon-title"></span>
									<?php _e('Posts Titles','seo-pressor');?>
								</a>
							</li>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-automatic-decoration-posts-slugs">
									<span class="seopressor-icon seopressor-icon-slug"></span>
									<?php _e('Posts Slugs','seo-pressor');?>
								</a>
							</li>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-automatic-decoration-keywords">
									<span class="seopressor-icon seopressor-icon-keyword"></span>
									<?php _e('Keywords','seo-pressor');?>
								</a>
							</li>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-automatic-decoration-images">
									<span class="seopressor-icon seopressor-icon-image"></span>
									<?php _e('Images','seo-pressor');?>
								</a>
							</li>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-automatic-decoration-links">
									<span class="seopressor-icon seopressor-icon-link"></span>
									<?php _e('Links','seo-pressor');?>
								</a>
							</li>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-automatic-decoration-perpost">
									<span class="seopressor-icon seopressor-icon-settings"></span>
									<?php _e('Social SEO','seo-pressor');?>
								</a>
							</li>
						</ul>
						<div id="seopressor-automatic-decoration-post-titles">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-add-keyword-in-titles"><?php _e('Keyword in post titles','seo-pressor')?></label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="seopressor-allow-add-keyword-in-titles" name="allow_add_keyword_in_titles" value="1" <?php echo ($data['allow_add_keyword_in_titles']=='1')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to automatically add the Keyword in Posts titles.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_automatic_decorations"><?php _e('Save Settings','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- end #seopressor-automatic-decoration-post-titles -->
						<div id="seopressor-automatic-decoration-posts-slugs">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-enable-convertion-post-slug">
												<?php _e('Make Post Slugs SEO Friendly','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="seopressor-enable-convertion-post-slug" name="enable_convertion_post_slug" value="1" <?php echo ($data['enable_convertion_post_slug']=='1')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to removing common words like \'a\', \'since\' and \'so\' from the slug.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-words-to-omit">
												<?php _e('Words to omit','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<textarea id="seopressor-words-to-omit" name="post_slugs_stop_words"><?php echo $data['post_slugs_stop_words'] ?></textarea>
												<br />
												<span class="description"><?php _e('What words do you want to omit when optimizing your post slugs.','seo-pressor')?>
													<br />
													<?php _e('One word per line.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_automatic_decorations"><?php _e('Save Settings','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- end #seopressor-automatic-decoration-posts-slugs -->

						<div id="seopressor-automatic-decoration-keywords">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-bold-style-to-apply">
												<?php _e('Decorate your keyword with bold','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="seopressor-allow-bold-style-to-apply" name="allow_bold_style_to_apply" value="1" <?php echo ($data['allow_bold_style_to_apply']=='1')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to automatically decorate your keyword with ','seo-pressor')?><strong><?php _e('bold','seo-pressor')?></strong><?php _e('.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="bold-style-to-apply-0"><?php _e('Bold style','seo-pressor')?></label>
										</th>
										<td>
											<?php $index = 0; foreach ($bold_arr as $bold_item) { ?>
												<label>
													<input type="radio" id="bold-style-to-apply-<?php echo $index;?>" name="bold_style_to_apply" <?php echo ($data['bold_style_to_apply']==$index)?'checked="checked"':''?> value="<?php echo $index?>" />
													<?php echo htmlentities($bold_item[0]) ?> - <?php echo htmlentities($bold_item[1]) ?>
												</label>
												<br />
											<?php $index++; } ?>
											<span class="description">
											&nbsp;<?php _e('This style will be used to display the keyword in Bold.','seo-pressor'); ?>
											</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-italic-style-to-apply">
												<?php _e('Decorate your keyword with italic','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="seopressor-allow-italic-style-to-apply" name="allow_italic_style_to_apply" value="1" <?php echo ($data['allow_italic_style_to_apply']=='1')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to automatically decorate your keyword with ','seo-pressor')?><em><?php _e('italic','seo-pressor')?></em><?php _e('.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="italic-style-to-apply-0"><?php _e('Italic style','seo-pressor')?></label>
										</th>
										<td>
											<?php $index = 0; foreach ($italic_arr as $italic_item) { ?>
												<label>
													<input type="radio" id="italic-style-to-apply-<?php echo $index;?>" name="italic_style_to_apply" <?php echo ($data['italic_style_to_apply']==$index)?'checked="checked"':''?> value="<?php echo $index?>" />
													<?php echo htmlentities($italic_item[0]) ?> - <?php echo htmlentities($italic_item[1]) ?>
												</label>
												<br />
											<?php $index++; } ?>
											<span class="description">
												&nbsp;<?php _e('This style will be used to display the keyword in Italic.','seo-pressor'); ?>
											</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-underline-style-to-apply">
												<?php _e('Decorate your keyword with underline','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="seopressor-allow-underline-style-to-apply" name="allow_underline_style_to_apply" value="1" <?php echo ($data['allow_underline_style_to_apply']=='1')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to automatically decorate your keyword with ','seo-pressor')?><u><?php _e('underline','seo-pressor')?></u><?php _e('.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="underline-style-to-apply-0"><?php _e('Underline style','seo-pressor')?></label>
										</th>
										<td>
											<?php $index = 0; foreach ($underline_arr as $underline_item) { ?>
												<label>
													<input type="radio" id="underline-style-to-apply-<?php echo $index;?>" name="underline_style_to_apply" <?php echo ($data['underline_style_to_apply']==$index)?'checked="checked"':''?> value="<?php echo $index?>" />
													<?php echo htmlentities($underline_item[0]) ?> - <?php echo htmlentities($underline_item[1]) ?>
												</label>
												<br />
											<?php $index++; } ?>
											<span class="description">
												&nbsp;<?php _e('This style will be used to display the keyword in Underline.','seo-pressor'); ?>
											</span>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_automatic_decorations"><?php _e('Save Settings','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- end #seopressor-automatic-decoration-keywords -->
						<div id="seopressor-automatic-decoration-images">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-automatic-adding-alt-keyword">
												<?php _e('Alternate text attribute','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="radio" id="seopressor-allow-automatic-adding-alt-keyword" name="image_alt_tag_decoration" value="empty" <?php echo ($data['image_alt_tag_decoration']=='empty')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to automatically add','seo-pressor')?><strong><?php _e(' alt="value" ','seo-pressor')?></strong><?php _e('to all images in the content that do not have an alt tag value.','seo-pressor')?>
												</span>
											</label>
											<br />
											<label>
												<input type="radio" name="image_alt_tag_decoration" value="all" <?php echo ($data['image_alt_tag_decoration']=='all')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Override all images alt values.','seo-pressor')?>
												</span>
											</label>
											<br />
											<label>
												<input type="radio" name="image_alt_tag_decoration" value="none" <?php echo ($data['image_alt_tag_decoration']=='none')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Don\'t automatically decorate alt images values.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-alt-attribute-structure">
												<?php _e('Alternate text structure','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="text" id="seopressor-alt-attribute-structure" name="alt_attribute_structure" value="<?php echo $data['alt_attribute_structure']?>" />
												<br />
												<span class="description">
													<?php _e('Structure to be used for the image alt attribute.','seo-pressor')?>
												</span>
											</label>
											<br />
											<div>
												<h2 class="seopressor-settings-heading">
													<?php _e('List of allowed tags','seo-pressor')?>
												</h2>
												<table cellspacing="0" class="widefat seopressor-inner-table">
													<tbody>
														<?php $index=0; foreach ($tags_desc_arr as $tags_desc_arr_item) { ?>
															<tr <?php echo ($index%2 == 0)?'class="alternate"':''?>>
																<td class="import-system row-title"><?php echo $tags_desc_arr_item[0] ?></td>
																<td class="desc"><?php echo $tags_desc_arr_item[1] ?></td>
															</tr>
														<?php $index++; } ?>
													</tbody>
												</table>
											</div>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-automatic-adding-title-keyword">
												<?php _e('Title attribute','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="radio" name="image_title_tag_decoration" value="empty" <?php echo ($data['image_title_tag_decoration']=='empty')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to automatically add the title attribute to all images in the content that do not have a image title value.','seo-pressor')?>
												</span>
											</label>
											<br />
											<label>
												<input type="radio" name="image_title_tag_decoration" value="all" <?php echo ($data['image_title_tag_decoration']=='all')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Override all images title values.','seo-pressor')?>
												</span>
											</label>
											<br />
											<label>
												<input type="radio" name="image_title_tag_decoration" value="none" <?php echo ($data['image_title_tag_decoration']=='none')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Don\'t automatically decorate title images values.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-title-attribute-structure">
												<?php _e('Title structure','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<input type="text" id="seopressor-title-attribute-structure" name="title_attribute_structure" value="<?php echo $data['title_attribute_structure']?>" />
												<br />
												<span class="description">
													<?php _e('Structure to be used for the image title attribute.','seo-pressor')?>
												</span>
											</label>
											<br />
											<div>
												<h2 class="seopressor-settings-heading">
													<?php _e('List of allowed tags','seo-pressor')?>
												</h2>
												<table cellspacing="0" class="widefat seopressor-inner-table">
													<tbody>
														<?php $index=0; foreach ($tags_desc_arr as $tags_desc_arr_item) { ?>
															<tr <?php echo ($index%2 == 0)?'class="alternate"':''?>>
																<td class="import-system row-title"><?php echo $tags_desc_arr_item[0] ?></td>
																<td class="desc"><?php echo $tags_desc_arr_item[1] ?></td>
															</tr>
														<?php $index++; } ?>
													</tbody>
												</table>
											</div>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_automatic_decorations"><?php _e('Save Settings','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- end #seopressor-automatic-decoration-images -->
						<div id="seopressor-automatic-decoration-links">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-automatic-adding-rel-nofollow">
												<?php _e('No follow external links','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
													<input type="checkbox" id="seopressor-allow-automatic-adding-rel-nofollow" name="allow_automatic_adding_rel_nofollow" value="1" <?php echo ($data['allow_automatic_adding_rel_nofollow']=='1')?'checked="checked"':''?> />									<span class="description">
													<?php _e('Allow SEOPressor to automatically add','seo-pressor')?><strong><?php _e(' rel="nofollow" ','seo-pressor')?></strong><?php _e('to external links.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-auto-add-rel-nofollow-img-links">
												<?php _e('No follow image links','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
													<input type="checkbox" id="seopressor-auto-add-rel-nofollow-img-links" name="auto_add_rel_nofollow_img_links" value="1" <?php echo ($data['auto_add_rel_nofollow_img_links']=='1')?'checked="checked"':''?> />									<span class="description">
													<?php _e('Allow SEOPressor to automatically add','seo-pressor')?><strong><?php _e(' rel="nofollow" ','seo-pressor')?></strong><?php _e('to image links.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_automatic_decorations"><?php _e('Save Settings','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- end #seopressor-automatic-decoration-links -->
						<div id="seopressor-automatic-decoration-perpost">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-automatic-adding-enable-rich-snippets">
												<?php _e('Rich Snippets','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
													<input type="checkbox" id="seopressor-allow-automatic-adding-enable-rich-snippets" name="enable_rich_snippets" value="1" <?php echo ($data['enable_rich_snippets']=='1')?'checked="checked"':''?> />									<span class="description">
													<?php _e('Enable Rich Snippets in Posts Settings','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-automatic-adding-enable-socialseo-facebook">
												<?php _e('Facebook','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
													<input type="checkbox" id="seopressor-allow-automatic-adding-enable-socialseo-facebook" name="enable_socialseo_facebook" value="1" <?php echo ($data['enable_socialseo_facebook']=='1')?'checked="checked"':''?> />									<span class="description">
													<?php _e('Enable Social SEO / Facebook in Posts Settings','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-automatic-adding-enable-socialseo-twitter">
												<?php _e('Twitter','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
													<input type="checkbox" id="seopressor-allow-automatic-adding-enable-socialseo-twitter" name="enable_socialseo_twitter" value="1" <?php echo ($data['enable_socialseo_twitter']=='1')?'checked="checked"':''?> />									<span class="description">
													<?php _e('Enable Social SEO / Twitter in Posts Settings','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-allow-automatic-adding-enable-dublincore">
												<?php _e('Dublin Core','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
													<input type="checkbox" id="seopressor-allow-automatic-adding-enable-dublincore" name="enable_dublincore" value="1" <?php echo ($data['enable_dublincore']=='1')?'checked="checked"':''?> />									<span class="description">
													<?php _e('Enable Dublin Core in Posts Settings','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_automatic_decorations"><?php _e('Save Settings','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- end #seopressor-automatic-decoration-perpost -->
					</div><!-- end .seopressor-tabs-second-lvl -->
				</form>
			</div><!-- end #seopressor-automatic-decoration -->

			<div id="seopressor-tags" class="ui-corner-top">
				<form action="" method="post" class="seopressor-ajax-form">
					<?php wp_nonce_field('WPPostsRateKeys-save-settings');?>

					<div class="seopressor-tabs-second-lvl" id="seopressor-tags-tabs">
						<ul>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-tags-post-tags">
									<span class="seopressor-icon seopressor-icon-tag"></span>
									<?php _e('Post Tags','seo-pressor');?>
								</a>
							</li>
						</ul>
						<div id="seopressor-tags-post-tags">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="seopressor-enable-tagging-using-google">
												<?php _e('Enable tagging','seo-pressor'); ?>
											</label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="seopressor-enable-tagging-using-google" name="enable_tagging_using_google" value="1" <?php echo ($data['enable_tagging_using_google']=='1')?'checked="checked"':''?> />
												<span class="description">
													<?php _e('Allow SEOPressor to automatically add related keywords in Posts tags based on Google Suggestions and Search.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="seopressor-max-number-tags">
												<?php _e('Number of tags to add','seo-pressor'); ?>
											</label>
										</th>
										<td>
											<label>
												<input type="text" id="seopressor-max-number-tags" name="max_number_tags" value="<?php echo $data['max_number_tags'] ?>" />
												<br />
												<span class="description">
													<?php _e('Specify up to how many tags should be added.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="seopressor-append-tags-append">
												<?php _e('Append or Overwrite tags','seo-pressor'); ?>
											</label>
										</th>
										<td>
											<label>
												<input type="radio" id="seopressor-append-tags-append" name="append_tags" value="1" <?php echo ($data['append_tags']=='1')?'checked="checked"':''?> />
												<?php _e('Append','seo-pressor'); ?>
											</label>
											<br />
											<label>
												<input type="radio" name="append_tags" value="0" <?php echo ($data['append_tags']=='0')?'checked="checked"':''?> />
												<?php _e('Overwrite','seo-pressor'); ?>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-to-retrieve-keywords-use-post-title">
												<?php _e('Data to use to retrieve keywords','seo-pressor'); ?>
											</label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="seopressor-to-retrieve-keywords-use-post-title" name="to_retrieve_keywords_use_post_title" value="1" <?php echo ($data['to_retrieve_keywords_use_post_title']=='1')?'checked="checked"':''?> />
												<?php _e('Use post title.','seo-pressor'); ?>
											</label>
											<br />
											<label>
												<input type="checkbox" id="seopressor-to-retrieve-keywords-use-post-content" name="to_retrieve_keywords_use_post_content" value="1" <?php echo ($data['to_retrieve_keywords_use_post_content']=='1')?'checked="checked"':''?> />
												<?php _e('Use post content.','seo-pressor'); ?>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-blacklisted-tags">
												<?php _e('Blacklisted tags','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<textarea id="seopressor-blacklisted-tags" name="blacklisted_tags"><?php echo $data['blacklisted_tags'] ?></textarea>
												<br />
												<span class="description"><?php _e('What tags do you never want to include when importing keywords.','seo-pressor')?>
													<br />
													<?php _e('Comma separated values.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="seopressor-generic-tags">
												<?php _e('Generic tags','seo-pressor')?>
											</label>
										</th>
										<td>
											<label>
												<textarea id="seopressor-generic-tags" name="generic_tags"><?php echo $data['generic_tags'] ?></textarea>
												<br />
												<span class="description"><?php _e('What tags do you want to include in all posts.','seo-pressor')?>
													<br />
													<?php _e('Comma separated values.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_tags"><?php _e('Save Settings','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div><!-- end #seopressor-tags-post-tags -->
					</div><!-- end .seopressor-tabs-second-lvl -->
				</form>
			</div><!-- end #seopressor-tags -->

			<div id="seopressor-advanced" class="ui-corner-top">
				<form action="" method="post" class="seopressor-ajax-form">
					<?php wp_nonce_field('WPPostsRateKeys-save-settings');?>

					<div class="seopressor-tabs-second-lvl" id="seopressor-advanced-tabs">
						<ul>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-advanced-lsi">
									<span class="seopressor-icon seopressor-icon-settings"></span>
									<?php _e('LSI Settings','seo-pressor');?>
	 							</a>
							</li>
							<li class="seopressor-tabs-second-lvl">
								<a href="#seopressor-advanced-miscelaneous">
									<span class="seopressor-icon seopressor-icon-misc"></span>
									<?php _e('Miscellaneous','seo-pressor');?>
								</a>
							</li>
						</ul>
						<div id="seopressor-advanced-miscelaneous">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="seopressor-locale"><?php _e('Language','seo-pressor')?></label>
										</th>
										<td>
											<select id="seopressor-locale" name="locale">
												<?php // First print the default language?>
												<option <?php echo ($data['locale'] == '')?'selected="selected"':'' ?> value=""><?php _e('Default (English)','seo-pressor');?></option>
												<?php foreach ($all_locales as $all_locales_item) { ?>
													<option <?php echo ($data['locale'] == $all_locales_item)?'selected="selected"':'' ?> value="<?php echo $all_locales_item?>"><?php echo $all_locales_item?></option>
												<?php }?>
											</select>
											<br />
											<span class="description"><?php _e('Language to be used for SEOPressor texts.','seo-pressor')?>
											</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="seopressor-analize-full-page">
												<?php _e('Content to analyze','seo-pressor'); ?>
											</label>
										</th>
										<td>
											<label>
												<input type="radio" id="seopressor-analize-full-page" name="analize_full_page" value="1" <?php echo ($data['analize_full_page']=='1')?'checked="checked"':''?> />
												<?php _e('SEOPressor will analyze the <strong>full page</strong>.','seo-pressor'); ?>
											</label>
											<br />
											<label>
												<input type="radio" name="analize_full_page" value="0" <?php echo ($data['analize_full_page']=='0')?'checked="checked"':''?> />
												<?php _e('SEOPressor will analyze the <strong>content area</strong> only.','seo-pressor'); ?>
											</label>
											</span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row" nowrap="nowrap">
											<label for="h1-tag-already-in-theme"><?php _e('Headings in theme','seo-pressor')?></label>
										</th>
										<td>
											<label>
												<input type="checkbox" id="h1-tag-already-in-theme" name="h1_tag_already_in_theme" value="1" <?php echo ($data['h1_tag_already_in_theme']=='1')?'checked="checked"':''?> />
												<span class="description"><?php _e('The active Theme already uses H1 tags for post and page headings.','seo-pressor')?>
												</span>
											</label>
											<br />
											<label>
												<input type="checkbox" name="h2_tag_already_in_theme" value="1" <?php echo ($data['h2_tag_already_in_theme']=='1')?'checked="checked"':''?> />
												<span class="description"><?php _e('The active Theme already uses H2 tags for post and page headings.','seo-pressor')?>
												</span>
											</label>
											<br />
											<label>
												<input type="checkbox" name="h3_tag_already_in_theme" value="1" <?php echo ($data['h3_tag_already_in_theme']=='1')?'checked="checked"':''?> />
												<span class="description"><?php _e('The active Theme already uses H3 tags for post and page headings.','seo-pressor')?>
												</span>
											</label>
										</td>
									</tr>
									<tr valign="top">
									<th scope="row" nowrap="nowrap">
										<label for="seopressor-special-characters-to-omit">
											<?php _e('Characters to omit','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<input type="checkbox" name="enable_special_characters_to_omit" value="1" <?php echo ($data['enable_special_characters_to_omit']=='1')?'checked="checked"':''?> />
											<span class="description"><?php _e('Enable if you want omit the follow characters when analyzing your keywords.','seo-pressor')?>
											</span>
										</label>
										<br />
										<label>
											<textarea id="seopressor-special-characters-to-omit" name="special_characters_to_omit"><?php echo $data['special_characters_to_omit'] ?></textarea>
											<br />
											<span class="description"><?php _e('What characters do you want to omit when analyzing your keywords.','seo-pressor')?>
												<br />
												<?php _e('One character per line.','seo-pressor')?>
											</span>
										</label>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row" nowrap="nowrap">
										<label for="seopressor-minimum-score-before-allow-to-publish">
											<?php _e('Minimum score before publishing','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<input type="text" class="seopressor-spinner" id="seopressor-minimum-score-before-allow-to-publish" name="minimum_score_to_publish" value="<?php echo $data['minimum_score_to_publish'] ?>" <?php echo(!WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SET_MIN_SCORE))?'readonly="readonly"':'' ?> />
											<br />
											<span class="description">
												<?php if (!WPPostsRateKeys_Capabilities::user_can(WPPostsRateKeys_Capabilities::SET_MIN_SCORE)) { ?>
													<strong><?php _e('Important Note: ','seo-pressor')?></strong><?php _e('Edit permission denied. Check this with WordPress or SEOPressor plugin administrator.','seo-pressor')?>
													<br />
												<?php } ?>
												<?php _e('If the Score of a Post is less than this value, the status will be "Draft" instead of "Published".','seo-pressor')?>
												<br />
												<?php _e('Leave it empty to allow Posts with any score to be published.','seo-pressor')?>
											</span>
										</label>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row" nowrap="nowrap">
										<label for="seopressor-support-multibyte">
											<?php _e('Support Multibyte character encoding','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<input type="checkbox" id="seopressor-support-multibyte" name="multibyte" value="1" <?php echo ($data['multibyte']=='1')?'checked="checked"':''?> />
											<span class="description"><?php _e('Select if you requires that SEOPressor works with Multibyte character encoding languages.','seo-pressor')?>
											</span>
										</label>
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th scope="row"></th>
									<td>
										<button type="submit" class="seopressor-button" id="submit" name="submit_advanced"><?php _e('Save Settings','seo-pressor')?></button>
										<span class="seopressor-ajax-loader-container">
											<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
										</span>
									</td>
								</tr>
							</tbody>
						</table>
						</div>
						<div id="seopressor-advanced-lsi">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="seopressor-lsi-bing-api-key"><?php _e('Bing API Key','seo-pressor')?></label>
										</th>
										<td>
											<input type="text" id="seopressor-lsi-bing-api-key" class="seopressor-large-text-field" name="lsi_bing_api_key" value="<?php echo $data['lsi_bing_api_key'] ?>" />
											<span class="seopressor-position-relative">
												<a id="seopressor-bing-api-get-api-keys-steps-button" class="seopressor-icon-info" onclick="return false;" title="<?php _e('Click to see instructions on how get a Bing API key in order to get the LSI.','seo-pressor')?>"></a>
											</span>
											<br />
											<label for="seopressor-lsi-bing-api-key">
												<span class="description"><?php _e('API key for make the requests to the Bing API at Azure Marketplace.','seo-pressor')?></span>
											</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="seopressor-lsi-language"><?php _e('Region/Language','seo-pressor')?></label>
										</th>
										<td>
											<select id="seopressor-lsi-language" name="lsi_language">
												<option <?php echo ($data['lsi_language'] == '')?'selected="selected"':'' ?> value=""><?php _e('Determined by Bing API','seo-pressor') ?></option>
												<option <?php echo ($data['lsi_language'] == 'ar-XA')?'selected="selected"':'' ?> value="ar-XA"><?php _e('Arabia (Arabic)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'bg-BG')?'selected="selected"':'' ?> value="bg-BG"><?php _e('Bulgaria (Bulgarian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'cs-CZ')?'selected="selected"':'' ?> value="cs-CZ"><?php _e('Czech Republic (Czech)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'da-DK')?'selected="selected"':'' ?> value="da-DK"><?php _e('Denmark (Danish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'de-AT')?'selected="selected"':'' ?> value="de-AT"><?php _e('Austria (German)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'de-CH')?'selected="selected"':'' ?> value="de-CH"><?php _e('Switzerland (German)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'de-DE')?'selected="selected"':'' ?> value="de-DE"><?php _e('Germany (German)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'el-GR')?'selected="selected"':'' ?> value="el-GR"><?php _e('Greece (Greek)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-AU')?'selected="selected"':'' ?> value="en-AU"><?php _e('Australia (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-CA')?'selected="selected"':'' ?> value="en-CA"><?php _e('Canada (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-AU')?'selected="selected"':'' ?> value="en-AU"><?php _e('Australia (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-GB')?'selected="selected"':'' ?> value="en-GB"><?php _e('United Kingdom (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-ID')?'selected="selected"':'' ?> value="en-ID"><?php _e('Indonesia (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-IE')?'selected="selected"':'' ?> value="en-IE"><?php _e('Ireland (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-IN')?'selected="selected"':'' ?> value="en-IN"><?php _e('India (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-MY')?'selected="selected"':'' ?> value="en-MY"><?php _e('Malaysia (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-NZ')?'selected="selected"':'' ?> value="en-NZ"><?php _e('New Zealand (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-PH')?'selected="selected"':'' ?> value="en-PH"><?php _e('Philippines (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-SG')?'selected="selected"':'' ?> value="en-SG"><?php _e('Singapore (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-US')?'selected="selected"':'' ?> value="en-US"><?php _e('United States (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-XA')?'selected="selected"':'' ?> value="en-XA"><?php _e('Arabia (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'en-ZA')?'selected="selected"':'' ?> value="en-ZA"><?php _e('South Africa (English)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'es-AR')?'selected="selected"':'' ?> value="es-AR"><?php _e('Argentina (Spanish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'es-CL')?'selected="selected"':'' ?> value="es-CL"><?php _e('Chile (Spanish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'es-ES')?'selected="selected"':'' ?> value="es-ES"><?php _e('Spain (Spanish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'es-MX')?'selected="selected"':'' ?> value="es-MX"><?php _e('Mexico (Spanish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'es-US')?'selected="selected"':'' ?> value="es-US"><?php _e('United States (Spanish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'es-XL')?'selected="selected"':'' ?> value="es-XL"><?php _e('Latin America (Spanish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'et-EE')?'selected="selected"':'' ?> value="et-EE"><?php _e('Estonia (Estonian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'fi-FI')?'selected="selected"':'' ?> value="fi-FI"><?php _e('Finland (Finish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'fr-BE')?'selected="selected"':'' ?> value="fr-BE"><?php _e('Belgium (French)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'fr-CA')?'selected="selected"':'' ?> value="fr-CA"><?php _e('Canada (French)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'fr-CH')?'selected="selected"':'' ?> value="fr-CH"><?php _e('Switzerland (French)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'fr-FR')?'selected="selected"':'' ?> value="fr-FR"><?php _e('France (French)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'he-IL')?'selected="selected"':'' ?> value="he-IL"><?php _e('Israel (Hebrew)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'hr-HR')?'selected="selected"':'' ?> value="hr-HR"><?php _e('Croatia (Croatian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'hu-HU')?'selected="selected"':'' ?> value="hu-HU"><?php _e('Hungary (Hungarian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'it-IT')?'selected="selected"':'' ?> value="it-IT"><?php _e('Italy (Italian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'ja-JP')?'selected="selected"':'' ?> value="ja-JP"><?php _e('Japan (Japanese)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'ko-KR')?'selected="selected"':'' ?> value="ko-KR"><?php _e('Korea (Korean)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'lt-LT')?'selected="selected"':'' ?> value="lt-LT"><?php _e('Lithuania (Lithuanian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'lv-LV')?'selected="selected"':'' ?> value="lv-LV"><?php _e('Latvia (Latvian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'nb-NO')?'selected="selected"':'' ?> value="nb-NO"><?php _e('Norway (Norwegian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'nl-BE')?'selected="selected"':'' ?> value="nl-BE"><?php _e('Belgium (Dutch)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'nl-NL')?'selected="selected"':'' ?> value="nl-NL"><?php _e('Netherlands (Dutch)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'pl-PL')?'selected="selected"':'' ?> value="pl-PL"><?php _e('Poland (Polish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'pt-BR')?'selected="selected"':'' ?> value="pt-BR"><?php _e('Brazil (Portuguese)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'pt-PT')?'selected="selected"':'' ?> value="pt-PT"><?php _e('Portugal (Portuguese)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'ro-RO')?'selected="selected"':'' ?> value="ro-RO"><?php _e('Romania (Romanian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'ru-RU')?'selected="selected"':'' ?> value="ru-RU"><?php _e('Russia (Russian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'sk-SK')?'selected="selected"':'' ?> value="sk-SK"><?php _e('Slovak Republic (Slovak)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'sl-SL')?'selected="selected"':'' ?> value="sl-SL"><?php _e('Slovenia (Slovenian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'sv-SE')?'selected="selected"':'' ?> value="sv-SE"><?php _e('Sweden (Swedish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'th-TH')?'selected="selected"':'' ?> value="th-TH"><?php _e('Thailand (Thai)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'tr-TR')?'selected="selected"':'' ?> value="tr-TR"><?php _e('Turkey (Turkish)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'uk-UA')?'selected="selected"':'' ?> value="uk-UA"><?php _e('Ukraine (Ukrainian)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'zh-CN')?'selected="selected"':'' ?> value="zh-CN"><?php _e('China (Chinese)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'zh-HK')?'selected="selected"':'' ?> value="zh-HK"><?php _e('Hong Kong SAR (Chinese)','seo-pressor')?></option>
												<option <?php echo ($data['lsi_language'] == 'zh-TW')?'selected="selected"':'' ?> value="zh-TW"><?php _e('Taiwan (Chinese)','seo-pressor')?></option>
											</select>
											<br />
											<span class="description"><?php _e('Language to be used for the keywords LSI.','seo-pressor')?></span>
										</td>
									</tr>
									<tr class="seopressor-submit-tr">
										<th scope="row"></th>
										<td>
											<button type="submit" class="seopressor-button" id="submit" name="submit_advanced"><?php _e('Save Settings','seo-pressor')?></button>
											<button type="submit" class="seopressor-button" id="submit" name="submit_advanced_validate_api_key"><?php _e('Validate API Key','seo-pressor')?></button>
											<span class="seopressor-ajax-loader-container">
												<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</form>
			</div><!-- End #seopressor-advanced -->
		<?php } ?>
		<div id="seopressor-requirements" class="ui-corner-top">
			<form action="" method="post" class="seopressor-ajax-form">
				<div>
					<table cellspacing="0">
						<tbody>
							<tr class="<?php echo ($data['active'] == 0 )?'seopressor-negative':'seopressor-positive' ?>">
								<td class="seopressor-icon-cell">
									<div class="seopressor-position-relative">
										<span class="seopressor-icon-suggestion-type"></span>
									</div>
								</td>
								<td class="seopressor-msg-cell seopressor-submit-tr">
									<p>
										<?php echo $msg_status ?>
										<?php if ($data['active'] == 0 ) { ?>
											<?php if ($data['active']==0 && $data['allow_manual_reactivation']=='0') { ?>
												<button type="submit" class="seopressor-button" name="submit_activation"><?php _e('Activate Plugin Now','seo-pressor')?></button>
												<span class="seopressor-ajax-loader-container">
													<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
												</span>
											<?php } elseif ($data['active']==0 && $data['allow_manual_reactivation']=='1') { ?>
												<button type="submit" class="seopressor-button" name="submit_reactivation"><?php _e('Re Activate Plugin Now','seo-pressor')?></button>
												<span class="seopressor-ajax-loader-container">
													<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
												</span>
											<?php } ?>
										<?php }?>
									</p>
								</td>
							</tr>
							<?php foreach ($requirement_msg_arr as $requirement_msg_arr_item) { ?>
								<tr class="<?php echo ($requirement_msg_arr_item[0] == 0 )?'seopressor-negative':'seopressor-positive' ?>">
									<td class="seopressor-icon-cell">
										<div class="seopressor-position-relative">
											<span class="seopressor-icon-suggestion-type"></span>
										</div>
									</td>
									<td class="seopressor-msg-cell">
										<p>
											<?php echo $requirement_msg_arr_item[1] ?>
										</p>
									</td>
								</tr>
							<?php } ?>

							<tr class="<?php echo ($plugin_in_valid_domain == 1 )?'seopressor-positive':'seopressor-negative' ?>">
								<td class="seopressor-icon-cell">
									<div class="seopressor-position-relative">
										<span class="seopressor-icon-suggestion-type"></span>
									</div>
								</td>
								<td class="seopressor-msg-cell">
									<p>
										<?php
										if ($plugin_license_is_multi) {
											_e('Your license is for multiples Sites.','seo-pressor');
										}
										else {
											_e('Your license is for a single Site, and can be installed on the follow registered domain:','seo-pressor');
										}
										 ?>
									</p>
									<ul class="seopressor-requirements-domain-list">
										<?php 
										if (!$plugin_license_is_multi) {
										foreach ($plugin_domains as $plugin_domains_item) { ?>
											<li>
												<?php echo $plugin_domains_item ?>
											</li>
										<?php } } ?>
									</ul>
									<p>
										<?php 
										if ($plugin_license_is_multi) {
											_e('You can check the list of registered domains, or download a new SEOPressor copy from the ','seo-pressor');
										}
										else {
											_e('You can download a new SEOPressor copy from the ','seo-pressor');
										} 
										?><a target="_blank" href="http://seopressor.com/download/download.php"><?php _e('SEOPressor download page','seo-pressor'); ?></a><?php _e('.','seo-pressor'); ?>
									</p>
										<?php
										if (!$plugin_license_is_multi) {
											?><p><?php
											_e('You can upgrade your SEOPressor to a Multi-site License now in ','seo-pressor'); ?><a target="_blank" href="http://seopressor.com/specialupgrade.html"><?php _e('SEOPressor upgrade page','seo-pressor'); ?></a><?php _e('.','seo-pressor');
											?></p><?php
										}
										?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div><!-- End #seopressor-requirements -->

		<?php if ($seopressor_is_active) { ?>
			<div id="seopressor-upgrade" class="ui-corner-top">
				<form action="" method="post" class="seopressor-ajax-form">
					<?php wp_nonce_field('wp-posts-rate-keys-auto-upgrade');?>

					<div>
						<br />
						<strong><?php _e('Step 1: ','seo-pressor');?></strong><?php _e('Check for requirements.','seo-pressor');?>
						<table cellspacing="0">
							<tbody>
								<tr class="<?php echo ($write_permission_requirement)?'seopressor-positive':'seopressor-negative' ?>">
									<td class="seopressor-icon-cell">
										<div class="seopressor-position-relative">
											<span class="seopressor-icon-suggestion-type"></span>
										</div>
									</td>
									<td class="seopressor-msg-cell">
										<table>
											<tbody>
												<tr>
													<p>
														<?php echo $file_list_msg ;?>
														<button type="button" class="seopressor-button" id="seopressor-show-files" name="show_files" onclick="return false;">
															<span class="ui-button-icon-primary ui-icon ui-icon-plus"></span>
															<?php _e('See files','seo-pressor');?>
														</button>
														<?php if (count($file_list)>0) { ?>
															<br />
														<?php } ?>
													</p>
													<ul id="seopressor-file-list-wrapper">
														<?php foreach ($file_list as $file_list_item) { ?>
															<li>
																<?php echo $file_list_item ?>
															</li>
														<?php } ?>
													</ul>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr class="<?php echo ($outgoing_connection_requirement)?'seopressor-positive':'seopressor-negative' ?>">
									<td class="seopressor-icon-cell">
										<div class="seopressor-position-relative">
											<span class="seopressor-icon-suggestion-type"></span>
										</div>
									</td>
									<td class="seopressor-msg-cell">
										<p>
											<?php _e('Connection to download the latest version is allowed.','seo-pressor');?>
										</p>
									</td>
								</tr>
								<tr class="<?php echo ($zip_archive_requirement)?'seopressor-positive':'seopressor-negative' ?>">
									<td class="seopressor-icon-cell">
										<div class="seopressor-position-relative">
											<span class="seopressor-icon-suggestion-type"></span>
										</div>
									</td>
									<td class="seopressor-msg-cell">
										<p>
											<?php _e('Has required <a href="http://php.net/manual/en/class.ziparchive.php" target="_blank">ZipArchive</a> PHP library.','seo-pressor');?>
										</p>
									</td>
								</tr>
								<tr class="<?php echo ($cs_active_requirement)?'seopressor-positive':'seopressor-negative' ?>">
									<td class="seopressor-icon-cell">
										<div class="seopressor-position-relative">
											<span class="seopressor-icon-suggestion-type"></span>
										</div>
									</td>
									<td class="seopressor-msg-cell">
										<p>
											<?php
											if ($cs_active_requirement) {
												_e('You have an active license.','seo-pressor');
											}
											else {
												_e("You have't an active license. You can try <a href='http://seopressor.com/download/download.php'>download</a> the latest version manually or contact SEOPressor support.",'seo-pressor');
											}
											?>
										</p>
									</td>
								</tr>
							</tbody>
						</table>

						<p>
							<strong><?php _e('Step 2: ','seo-pressor');?></strong><?php _e('Make a manual backup of the Plugin files.','seo-pressor');?>
						</p>
						<p>
							<strong><?php _e('Step 3: ','seo-pressor');?></strong><?php _e('Proceed with Update.','seo-pressor');?>
						</p>
						<table cellspacing="0">
							<tbody>
								<tr class="<?php echo (($need_upgrade && $plugin_is_active)||(!$plugin_is_active))?'seopressor-negative':'seopressor-positive' ?>">
									<td class="seopressor-icon-cell">
										<div class="seopressor-position-relative">
											<span class="seopressor-icon-suggestion-type"></span>
										</div>
									</td>
									<td class="seopressor-msg-cell seopressor-submit-tr">
										<p><?php if ($need_upgrade && $plugin_is_active) { 
										?><button type="submit" class="seopressor-button" name="submit_upgrade"><?php _e('Proceed with Update','seo-pressor') ?></button>
												<span class="seopressor-ajax-loader-container">
													<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
												</span>
											<?php } else if (!$need_upgrade && $plugin_is_active) { ?>
												<?php echo __('You are using the latest version','seo-pressor') . ' ' . WPPostsRateKeys::VERSION . '. ' . __('Update is not required.','seo-pressor');
												?></br></br><button type="submit" class="seopressor-button" name="submit_upgrade"><?php _e('Proceed with Update','seo-pressor') ?></button>
												<span class="seopressor-ajax-loader-container">
													<img title="Loading data..." alt="Loading..." class="seopressor-ajax-loader" src="<?php echo get_bloginfo ('wpurl') . '/wp-admin/images/wpspin_light.gif'; ?>" />
												</span>
											<?php } else if (!$plugin_is_active) { ?>
												<?php _e('You need to activate the plugin.','seo-pressor');?>
											<?php } ?>
										</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			</div><!-- End #seopressor-update -->
		<?php } ?>
	</div>
	<?php } ?>

	<div id="seopressor-templates-container">
		<div class="seopressor-error-message ui-state-error ui-corner-all seopressor-negative seopressor-position-relative" style="padding: 0 0.7em;">
			<p>
				<span class="seopressor-icon-suggestion-type"></span>
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
</div>