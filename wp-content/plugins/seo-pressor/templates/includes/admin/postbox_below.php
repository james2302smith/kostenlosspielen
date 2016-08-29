<?php
/**
 * Template to show the SEOPressor postbox.
 *
 * @uses	int			$post_id
 *
 * @package admin-panel
 * @version v5.0
 *
 */
?>
<?php // if ($seopressor_is_active) { // Ignored (and deleted bottom code) because the include is never made if hasn't permission  ?>
	<div class="seopressor-overlay-container">
		<div class="seopressor-overlay"></div>
		<div class="seopressor-loader-container">
            <span class="VerticalAlignHelper"></span><img src='<?php echo get_bloginfo ( 'wpurl' ) . '/wp-includes/js/thickbox/loadingAnimation.gif'; ?>' />
		</div>
	</div>
	<div class="seopressor-page">
		<div class="seopressor-tabs">
			<ul>
				<li><a href="#seopressor-settings"><?php _e('Settings','seo-pressor');?></a></li>
				<li><a href="#seopressor-rich-snippets"><?php _e('Rich Snippets','seo-pressor');?></a></li>
				<li><a href="#seopressor-social-seo"><?php _e('Social SEO','seo-pressor');?></a></li>
                <li><a href="#seopressor-dublin-core"><?php _e('Dublin Core','seo-pressor');?></a></li>
				<li><a href="#seopressor-add-tags"><?php _e('Add Tags','seo-pressor');?></a></li>
			</ul>
			<div id="seopressor-settings" class="ui-corner-top">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="seopressor-allow-meta-keyword">
									<?php _e('Use keywords as META Tags','seo-pressor')?>
								</label>
							</th>
							<td>
								<label>
									<input type="checkbox" class="seopressor-allow-meta-keyword" id="seopressor-allow-meta-keyword" name="allow_meta_keyword" value="1" <?php echo ($settings['allow_meta_keyword']=='1')?'checked="checked"':''?> />
									<span class="description"><?php _e('Allow SEOPressor to automatically use the SEOPressor keywords as META keyword tags.','seo-pressor')?></span>
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
							</th>
							<td>
								<label>
									<input type="radio" class="seopressor-use-categories-for-meta-keyword" id="seopressor-use-categories-for-meta-keyword" name="use_for_meta_keyword" value="categories" <?php echo ($settings['use_for_meta_keyword']==='categories')?'checked="checked"':''?> />
									<?php _e('Use Post Categories as META keywords.','seopressor')?>
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
							</th>
							<td>
								<label>
									<input type="radio" class="seopressor-use-tags-for-meta-keyword" id="use-tags-for-meta-keyword" name="use_for_meta_keyword" value="tags" <?php echo ($settings['use_for_meta_keyword']==='tags')?'checked="checked"':''?> />
									<?php _e('Use Post Tags as META keywords.','seopressor')?>
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
							</th>
							<td>
								<label>
									<input type="radio" class="seopressor-use-seopressor-keywords-for-meta-keyword" id="use-seopressor-keywords-for-meta-keyword" name="use_for_meta_keyword" value="seopressor_keywords" <?php echo ($settings['use_for_meta_keyword']==='seopressor_keywords')?'checked="checked"':''?> />
									<?php _e('Use SEOPressor Keywords as META keywords.','seopressor')?>
								</label>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row">
								<label for="seopressor-allow-meta-title">
									<?php _e('Use META title tag','seopressor')?>
								</label>
							</th>
							<td>
								<label>
									<input type="checkbox" class="seopressor-allow-meta-title" id="seopressor-allow-meta-title" name="allow_meta_title" value="1" <?php echo ($settings['allow_meta_title']=='1')?'checked="checked"':''?> />
									<span class="description"><?php _e('Allow SEOPressor to automatically use the text below as META title tag.','seo-pressor')?></span>
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="seopressor-meta-title">
									<?php _e('META title','seopressor')?>
								</label>
							</th>
							<td>
								<input type="text" id="seopressor-meta-title" class="seopressor-large-textarea-field" name="meta_title" value="<?php echo $settings['meta_title'] ?>" />
							</td>
						</tr>


						<tr valign="top">
							<th scope="row">
								<label for="seopressor-allow-meta-description">
									<?php _e('Use META description tag','seopressor')?>
								</label>
							</th>
							<td>
								<label>
									<input type="checkbox" class="seopressor-allow-meta-description" id="seopressor-allow-meta-description" name="allow_meta_description" value="1" <?php echo ($settings['allow_meta_description']=='1')?'checked="checked"':''?> />
									<span class="description"><?php _e('Allow SEOPressor to automatically use the text below as META description tag.','seo-pressor')?></span>
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="seopressor-meta-description">
									<?php _e('META description','seopressor')?>
								</label>
							</th>
							<td>
								<textarea id="seopressor-meta-description" class="seopressor-large-textarea-field" name="meta_description"><?php echo $settings['meta_description'] ?></textarea>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="seopressor-override-keyword-in-sentences">
									<?php _e('Override keyword detection in sentences','seopressor')?>
							</label>
							</th>
							<td>
								<label>
									<input type="checkbox" id="seopressor-override-keyword-in-sentences" name="allow_keyword_overriding_in_sentences" value="1" <?php echo ($settings['allow_keyword_overriding_in_sentences']=='1')?'checked="checked"':''?> />
									<span class="description"><?php _e('Allows you to automatically override SEOPressor keywords autodetection in sentences.','seo-pressor')?></span>
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
							</th>
							<td>
								<label>
									<input type="checkbox" class="seopressor-key-in-first-sentence" id="key-in-first-sentence" name="key_in_first_sentence" value="1" <?php echo ($settings['key_in_first_sentence']==='1')?'checked="checked"':''?> />
									<?php _e('Keyword present in first sentence','seopressor')?>
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
							</th>
							<td>
								<label>
									<input type="checkbox" class="seopressor-key-in-last-sentence" id="key-in-last-sentence" name="key_in_last_sentence" value="1" <?php echo ($settings['key_in_last_sentence']==='1')?'checked="checked"':''?> />
									<?php _e('Keyword present in last sentence','seopressor')?>
								</label>
							</td>
						</tr>
						<tr class="seopressor-submit-tr">
							<th></th>
							<td>
								<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="seopressor-rich-snippets" class="ui-corner-top">
			<br>
			<label>
				&nbsp;&nbsp;
				<input type="checkbox" class="seopressor-enable-rich-snippets" id="enable-rich-snippets" name="seop_enable_rich_snippets" value="1" <?php echo ($settings['enable_rich_snippets']==='1')?'checked="checked"':''?> />
				<?php _e('Enable Rich Snippets','seopressor')?>
			</label>
			<label>
				<br><br>&nbsp;&nbsp;
				<input type="checkbox" class="seopressor-publish-rich-snippets" id="publish-rich-snippets" name="seop_publish_rich_snippets" value="1" <?php echo ($settings['publish_rich_snippets']==='1')?'checked="checked"':''?> />
				<?php _e('Publish Rich Snippets (visible below Post Content)','seopressor')?>
			</label>
			<br><br>
				<div class="seopressor-tabs-second-lvl">
					<ul>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-rich-snippets-reviews">
								<span class="seopressor-icon seopressor-icon-review"></span>
								<?php _e('Review','seo-pressor');?>
							</a>
						</li>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-rich-snippets-events">
								<span class="seopressor-icon seopressor-icon-event"></span>
								<?php _e('Event','seo-pressor');?>
							</a>
						</li>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-rich-snippets-people">
								<span class="seopressor-icon seopressor-icon-people"></span>
								<?php _e('People','seo-pressor');?>
							</a>
						</li>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-rich-snippets-products">
								<span class="seopressor-icon seopressor-icon-product"></span>
								<?php _e('Product','seo-pressor');?>
							</a>
						</li>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-rich-snippets-recipes">
								<span class="seopressor-icon seopressor-icon-recipe"></span>
								<?php _e('Recipe','seo-pressor');?>
							</a>
						</li>
					</ul>
					<div id="seopressor-rich-snippets-reviews">
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('Review','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rating">
											<?php _e('Rating','seo-pressor')?>
										</label>
									</th>
									<td>
										<select id="seopressor-rating" name="seopressor_google_rich_snippet_rating" data-placeholder="Choose a rating...">
											<option value=""></option>
											<?php for ($i=1;$i<=5;($i=$i+0.5)) { $number_to_show = number_format($i,1); ?>
												<option <?php echo ($settings['google_rich_snippet_rating']==$number_to_show)?'selected="selected"':'' ?> value="<?php echo $number_to_show ?>"><?php echo $number_to_show ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-author">
											<?php _e('Author','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-author" name="seopressor_google_rich_snippet_author" value="<?php echo $settings['google_rich_snippet_author'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-short-summary">
											<?php _e('Summary','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<input type="text" id="seopressor-short-summary" class="seopressor-large-textarea-field" name="seopressor_google_rich_snippet_summary" value="<?php echo $settings['google_rich_snippet_summary'] ?>" />
											<br />
											<span class="description"><?php _e('A short (one line) summary of the review.','seo-pressor')?></span>
										</label>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-medium-summary">
											<?php _e('Description','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<textarea id="seopressor-medium-summary" class="seopressor-large-textarea-field" name="seopressor_google_rich_snippet_description"><?php echo $settings['google_rich_snippet_description'] ?></textarea>
											<br />
											<span class="description"><?php _e('A one-paragraph summary of the review.','seo-pressor')?></span>
										</label>
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end #seopressor-rich-snippets-reviews -->
					<div id="seopressor-rich-snippets-events">
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('Event','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-events-name">
											<?php _e('Name','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-events-name" name="seop_grs_event_name" value="<?php echo $settings['seop_grs_event_name'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-events-startdate">
											<?php _e('Date And Time','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<input type="text" id="seopressor-rich-snippets-events-startdate" name="seop_grs_event_startdate" value="<?php echo $settings['seop_grs_event_startdate'] ?>" />
											<br />
											<span class="description"><?php _e('Format: mm/dd/yyyy hh:mm','seo-pressor')?></span>
										</label>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-events-url">
											<?php _e('URL','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-events-url" class="seopressor-large-textarea-field" name="seop_grs_event_url" value="<?php echo $settings['seop_grs_event_url'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('Location','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-events-location-name">
											<?php _e('Name','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-events-location-name" name="seop_grs_event_location_name" value="<?php echo $settings['seop_grs_event_location_name'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-events-location-address-streetaddress">
											<?php _e('Street','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-events-location-address-streetaddress" class="seopressor-large-textarea-field" name="seop_grs_event_location_address_streetaddress" value="<?php echo $settings['seop_grs_event_location_address_streetaddress'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-events-address-addresslocality">
											<?php _e('Locality','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-events-address-addresslocality" name="seop_grs_event_location_address_addresslocality" value="<?php echo $settings['seop_grs_event_location_address_addresslocality'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-events-location-address-addressregion">
											<?php _e('Region','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-events-location-address-addressregion" name="seop_grs_event_location_address_addressregion" value="<?php echo $settings['seop_grs_event_location_address_addressregion'] ?>" />
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end #seopressor-rich-snippets-events -->
					<div id="seopressor-rich-snippets-people">
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('People','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-people-given-name">
											<?php _e('First Name','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-people-given-name" name="seop_grs_people_name_given_name" value="<?php echo $settings['seop_grs_people_name_given_name'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-people-family-name">
											<?php _e('Last Name','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-people-family-name" name="seop_grs_people_name_family_name" value="<?php echo $settings['seop_grs_people_name_family_name'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-people-locality">
											<?php _e('Locality','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-people-locality" name="seop_grs_people_locality" value="<?php echo $settings['seop_grs_people_locality'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-people-region">
											<?php _e('Region','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-people-region" name="seop_grs_people_region" value="<?php echo $settings['seop_grs_people_region'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-people-title">
											<?php _e('Title','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-people-title" name="seop_grs_people_title" value="<?php echo $settings['seop_grs_people_title'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-people-home-url">
											<?php _e('Home URL','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-people-home-url" class="seopressor-large-textarea-field" name="seop_grs_people_home_url" value="<?php echo $settings['seop_grs_people_home_url'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-people-photo">
											<?php _e('Photo URL','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-people-photo" class="seopressor-large-textarea-field" name="seop_grs_people_photo" value="<?php echo $settings['seop_grs_people_photo'] ?>" />
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end #seopressor-rich-snippets-people -->
					<div id="seopressor-rich-snippets-products">
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('Product','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-product-name">
											<?php _e('Name','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-product-name" name="seop_grs_product_name" value="<?php echo $settings['seop_grs_product_name'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-product-image">
											<?php _e('Image URL','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-product-image" class="seopressor-large-textarea-field" name="seop_grs_product_image" value="<?php echo $settings['seop_grs_product_image'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-product-description">
											<?php _e('Description','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-product-description" class="seopressor-large-textarea-field" name="seop_grs_product_description" value="<?php echo $settings['seop_grs_product_description'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-product-offers">
											<?php _e('Offers','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<textarea id="seopressor-rich-snippets-product-offers" class="seopressor-large-textarea-field" name="seop_grs_product_offers"><?php echo $settings['seop_grs_product_offers'] ?></textarea>
											<br />
											<span class="description"><?php _e('Put each Offer in a new line. Each Offer should be like: $19.99 USD.','seo-pressor')?></span>
										</label>
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end #seopressor-rich-snippets-products -->
					<div id="seopressor-rich-snippets-recipes">
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('Recipe','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-name">
											<?php _e('Recipe Name','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-name" name="seop_grs_recipe_name" value="<?php echo $settings['seop_grs_recipe_name'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-yield">
											<?php _e('Recipe Yield','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-yield" name="seop_grs_recipe_yield" value="<?php echo $settings['seop_grs_recipe_yield'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-author">
											<?php _e('Author Name','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-author" name="seop_grs_recipe_author" value="<?php echo $settings['seop_grs_recipe_author'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-photo">
											<?php _e('Photo URL','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-photo" class="seopressor-large-textarea-field" name="seop_grs_recipe_photo" value="<?php echo $settings['seop_grs_recipe_photo'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-ingredient">
											<?php _e('Ingredients','seo-pressor')?>
										</label>
									</th>
									<td>
										<label>
											<textarea id="seopressor-rich-snippets-recipe-ingredient" class="seopressor-large-textarea-field" name="seop_grs_recipe_ingredient"><?php echo $settings['seop_grs_recipe_ingredient'] ?></textarea>
											<br />
											<span class="description"><?php _e('Put each ingredient in a new line.','seo-pressor')?></span>
										</label>
									</td>
								</tr>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('Nutrition Facts','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-nutrition-calories">
											<?php _e('Calories','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-nutrition-calories" name="seop_grs_recipe_nutrition_calories" value="<?php echo $settings['seop_grs_recipe_nutrition_calories'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-nutrition-sodium">
											<?php _e('Sodium','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-nutrition-sodium" name="seop_grs_recipe_nutrition_sodium" value="<?php echo $settings['seop_grs_recipe_nutrition_sodium'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-nutrition-fat">
											<?php _e('Fat','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-nutrition-fat" name="seop_grs_recipe_nutrition_fat" value="<?php echo $settings['seop_grs_recipe_nutrition_fat'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-nutrition-protein">
											<?php _e('Protein','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-nutrition-protein" name="seop_grs_recipe_nutrition_protein" value="<?php echo $settings['seop_grs_recipe_nutrition_protein'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-nutrition-cholesterol">
											<?php _e('Cholesterol','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-nutrition-cholesterol" name="seop_grs_recipe_nutrition_cholesterol" value="<?php echo $settings['seop_grs_recipe_nutrition_cholesterol'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('Times','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-total-time-minutes">
											<?php _e('Total (in minutes)','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-total-time-minutes" name="seop_grs_recipe_total_time_minutes" value="<?php echo $settings['seop_grs_recipe_total_time_minutes'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-cook-time-minutes">
											<?php _e('Cook (in minutes)','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-cook-time-minutes" name="seop_grs_recipe_cook_time_minutes" value="<?php echo $settings['seop_grs_recipe_cook_time_minutes'] ?>" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label for="seopressor-rich-snippets-recipe-prep-time-minutes">
											<?php _e('Preparation (in minutes)','seo-pressor')?>
										</label>
									</th>
									<td>
										<input type="text" id="seopressor-rich-snippets-recipe-prep-time-minutes" name="seop_grs_recipe_prep_time_minutes" value="<?php echo $settings['seop_grs_recipe_prep_time_minutes'] ?>" />
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end #seopressor-rich-snippets-recipes -->
				</div>
			</div><!-- end #seopressor-rich-snippets -->
			<div id="seopressor-social-seo">
				<div class="seopressor-tabs-second-lvl">
					<ul>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-social-seo-facebook">
								<span class="seopressor-icon seopressor-icon-facebook"></span>
								<?php _e('Facebook','seo-pressor');?>
							</a>
						</li>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-social-seo-twitter">
								<span class="seopressor-icon seopressor-icon-twitter"></span>
								<?php _e('Twitter','seo-pressor');?>
							</a>
						</li>
					</ul>
					<div id="seopressor-social-seo-facebook">
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th colspan="2">
										<h2><?php _e('OpenGraph Tags','seo-pressor')?></h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label>
										<input type="checkbox" class="seopressor-enable-socialseo-facebook" id="enable-socialseo-facebook" name="seop_enable_socialseo_facebook" value="1" <?php echo ($settings['enable_socialseo_facebook']==='1')?'checked="checked"':''?> />
										<?php _e('Enable Social SEO for Facebook','seopressor')?>
									</label>
									</th>
									<td>
									
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Type','seo-pressor')?></label>
									</th>
									<td>
										<?php echo $settings['og_type'] ?>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('URL','seo-pressor')?></label>
									</th>
									<td>
										<a target="_blank" href="<?php echo $settings['og_url'] ?>"><?php echo $settings['og_url'] ?></a>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Site Name','seo-pressor')?></label>
									</th>
									<td>
										<?php echo $settings['og_sitename'] ?>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Publisher','seo-pressor')?></label>
									</th>
									<td>
										<input id="seopressor-og-publisher" class="seopressor-large-textarea-field" type="text" name="seopressor_og_publisher" value="<?php echo $settings['og_publisher']?>" />
										<br><span class="description"><?php echo __('To specify the URL of the author page in Facebook','seo-pressor') ?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Author','seo-pressor')?></label>
									</th>
									<td>
										<input id="seopressor-og-author" class="seopressor-large-textarea-field" type="text" name="seopressor_og_author" value="<?php echo $settings['og_author']?>" />
										<br><span class="description"><?php echo __('To specify the URL of the author profile in Facebook','seo-pressor') ?> &nbsp; <?php echo __('Default value','seo-pressor') . ': ' . $settings['og_author_default'] ?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Title','seo-pressor')?></label>
									</th>
									<td>
										<input id="seopressor-og-title" class="seopressor-large-textarea-field" type="text" name="seopressor_og_title" value="<?php echo $settings['og_title']?>" />
										<br><span class="description"><?php echo __('Default value','seo-pressor') . ': ' . $settings['og_title_default'] ?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Image','seo-pressor')?></label>
									</th>
									<td>
										<input id="seopressor-og-image" type="hidden" name="og_image" value="<?php echo $settings['og_image'] ?>" />
										<div class="seopressor-position-relative">
											<?php if ($settings['og_image'] != '') { ?>
											<span id="seopressor-gallery">
												<img src="<?php echo $settings['og_image'] ?>" />
											</span>
											<?php } else { ?>
												<span id="seopressor-gallery"></span>
												<span id="seopressor-gallery-count"></span>
												<span id="seopressor-image-control">
													<button class="seopressor-button-prev"><?php _e('Previous','seo-pressor')?></button>
													<button class="seopressor-button-next"><?php _e('Next','seo-pressor')?></button>
												</span>
											<?php } ?>
											<br>
											<input id="seopressor-og-image-use" type="checkbox" name="og_image_use" value="1" <?php echo ($settings['og_image_use'])?'checked="checked"':'' ?> />
											<?php _e('Use image','seo-pressor')?>
										</div>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Description','seo-pressor')?></label>
									</th>
									<td>
									<textarea id="seopressor-og-description" class="seopressor-large-textarea-field" name="seopressor_og_description"><?php echo $settings['og_description'] ?></textarea>
											<br />
											<span class="description"><?php echo __('Default value','seo-pressor') . ': ' . $settings['og_description_default'] ?></span>
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end #seopressor-social-seo-facebook -->
					<div id="seopressor-social-seo-twitter">
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th colspan="2">
										<h2>
											<?php _e('Twitter Card','seo-pressor')?>
										</h2>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label>
										<input type="checkbox" class="seopressor-enable-socialseo-twitter" id="enable-socialseo-twitter" name="seop_enable_socialseo_twitter" value="1" <?php echo ($settings['enable_socialseo_twitter']==='1')?'checked="checked"':''?> />
										<?php _e('Enable Social SEO for Twitter','seopressor')?>
									</label>
									</th>
									<td>
									
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Creator Site','seo-pressor')?></label>
									</th>
									<td>
										<?php echo $settings['twitter_creator_site'] ?>
										<?php if($settings['twitter_creator_site'] != '') { ?>
											<br />
											<span class="description"><?php _e('This is the value the Post author specify in "Twitter ID" field in his profile.','seo-pressor')
											?>&nbsp;<a href="<?php
											echo $author_profile_edit_page;
											?>">[<?php _e('EDIT','seo-pressor') ?>]</a></span>
										<?php } else { ?>
											<span class="description">
												<?php _e('Empty. This is the value the Post author specify in "Twitter ID" field in his profile.','seo-pressor') ?>&nbsp;<a href="<?php	echo $author_profile_edit_page; ?>#seopressor_twitter_user_card">[<?php _e('EDIT','seo-pressor') ?>]</a></span>
										<?php } ?>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('URL','seo-pressor')?></label>
									</th>
									<td>
										<a target="_blank" href="<?php echo $settings['twitter_url'] ?>"><?php echo $settings['twitter_url'] ?></a>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Title','seo-pressor')?></label>
									</th>
									<td>
										<input id="seopressor-twitter-title" class="seopressor-large-textarea-field" type="text" name="seopressor_twitter_title" value="<?php echo $settings['twitter_title']?>" />
										<br><span class="description"><?php echo __('Default value','seo-pressor') . ': ' . $settings['twitter_title_default'] ?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">
										<label><?php _e('Description','seo-pressor')?></label>
									</th>
									<td>
									<textarea id="seopressor-twitter-description" class="seopressor-large-textarea-field" name="seopressor_twitter_description"><?php echo $settings['twitter_description'] ?></textarea>
											<br />
											<span class="description"><?php echo __('Default value','seo-pressor') . ': ' . $settings['twitter_description_default'] ?></span>
									</td>
								</tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end #seopressor-social-seo-twitter -->
				</div>
			</div><!-- end #seopressor-social-seo -->
            <div id="seopressor-dublin-core">
            	<div class="seopressor-tabs-second-lvl">
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                          <th colspan="2">
                                <h2>
                                    <?php _e('Dublin Core','seo-pressor')?>
                                </h2>
                            </th>
                        </tr>
                    </tbody>
                </table>
                </div>
                <table class="form-table">
					<tbody>
					<tr valign="top">
                            <th scope="row">
                                <label>
										<input type="checkbox" class="seopressor-enable-dublincore" id="enable-dublincore" name="seop_enable_dublincore" value="1" <?php echo ($settings['enable_dublincore']==='1')?'checked="checked"':''?> />
										<?php _e('Enable Dublin Core','seopressor')?>
									</label>
                            </th>
                            <td>
                            </td>
                        </tr>
					<tr valign="top">
                            <th scope="row">
                                <label><?php _e('Title','seo-pressor')?></label>
                            </th>
                            <td>
										<input id="seopressor-dc-title" class="seopressor-large-textarea-field" type="text" name="seopressor_dc_title" value="<?php echo $settings['dc_title']?>" />
										<br><span class="description"><?php echo __('Default value','seo-pressor') . ': ' . $settings['dc_title_default'] ?></span>
									</td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php _e('Creator','seo-pressor')?></label>
                            </th>
                            <td><label>
                                <?php if($settings['dc_creator'] != '') { ?><?php echo $settings['dc_creator'] ?>
                                    <br />
                                    <span class="description"><?php _e('This is the value the Post author specify in "Google Plus Profile URL" field in his profile.','seo-pressor')
                                    ?>&nbsp;<a target="_blank" href="<?php	echo $author_profile_edit_page; ?>#seopressor_twitter_user_card">
                                    [<?php _e('EDIT','seo-pressor') ?>]</a></span>
                                <?php } else { ?>
                                    <span class="description">
                                        <?php _e('Empty. This is the value the Post author specify in "Google Plus Profile URL" field in his profile.','seo-pressor') ?>&nbsp;<a href="<?php	echo $author_profile_edit_page; ?>#seopressor_twitter_user_card">[<?php _e('EDIT','seo-pressor') ?>]</a></span>
                                <?php } ?></label>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php _e('Description','seo-pressor')?></label>
                            </th>
                            <td>
									<textarea id="seopressor-dc-description" class="seopressor-large-textarea-field" name="seopressor_dc_description"><?php echo $settings['dc_description'] ?></textarea>
											<br />
											<span class="description"><?php echo __('Default value','seo-pressor') . ': ' . $settings['dc_description_default'] ?></span>
									</td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php _e('Date','seo-pressor')?></label>
                            </th>
                            <td>
                                <label><?php echo $settings['dc_date'] ?></label>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php _e('Type','seo-pressor')?></label>
                            </th>
                            <td>
                                <label><?php echo $settings['dc_type'] ?></label>
                            </td>
                        </tr>
								<tr class="seopressor-submit-tr">
									<th></th>
									<td>
										<button type="submit" class="seopressor-button seopressor-submit-button" name="submit_update_data" onclick="return false;" /><?php _e('Update Settings','seopressor')?></button>
									</td>
								</tr>
					</tbody>
				</table>

			</div><!-- end #seopressor-dublin-core -->

			<div id="seopressor-add-tags">
				<div class="seopressor-tabs-second-lvl">
					<ul>
						<li class="seopressor-tabs-second-lvl">
							<a href="#seopressor-add-tags-yahoo">
								<span class="seopressor-icon seopressor-icon-yahoo"></span>
								<?php _e('Yahoo!','seo-pressor');?>
							</a>
						</li>
					</ul>
					<div id="seopressor-add-tags-yahoo">
					<input type="hidden" class="seopressor_tag_service" name="seopressor_tag_service" value="yahoo" />
					<table class="form-table">
						<tbody>
						<tr valign="top">
							<th colspan="2">
								<h2>
									<?php _e('Add Tags from Yahoo!','seo-pressor')?>
								</h2>
							</th>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php _e(' Instructions','seo-pressor')?></label>
							</th>
							<td>
								<?php _e('<strong>Step 1:</strong> Gather the tags from the service.','seo-pressor')?>
								<br />
								<?php _e('<strong>Step 2:</strong> Select the tags you want to add.','seo-pressor')?>
								<br />
								<?php _e('<strong>Step 3:</strong> Add selected tags to WordPress tags.','seo-pressor')?>
							</td>
						</tr>
						<tr>
							<th scope="row"></th>
							<td>
							<span id="seop_gettags_msg" style="display:none;"> 
							<strong><?php _e('Note:','seo-pressor')?></strong>
							<?php _e('No new Tag was found.','seo-pressor')?>
							</span>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
							</th>
							<td class="seopressor-tags-wrapper">
							</td>
						</tr>
						<tr class="seopressor-submit-tr">
							<th></th>
							<td>
								<button type="button" class="seopressor-button seopressor-get-tags" name="submit_get_tags" onclick="return false;" /><?php _e('Get Tags','seopressor')?></button>
							<button type="submit" class="seopressor-button seopressor-update-tags" name="submit_update_tags" onclick="return false;" /><?php _e('Add Tags to WordPress Tags','seopressor')?></button>
						</td>
					</tr>
					</tbody>
		</table>
					</div><!-- end #seopressor-add-tags-yahoo -->
				</div>
			</div><!-- end #seopressor-add-tags -->
		</div>
	</div>