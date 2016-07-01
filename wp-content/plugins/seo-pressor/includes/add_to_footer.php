<?php
/**
 * Include for the HTMl to add to WP footer
 * 
 */

// Get settings
$settings = WPPostsRateKeys_Settings::get_options();
$footer_text_color = $settings['footer_text_color'];
$footer_tags_before = $settings['footer_tags_before'];
$footer_tags_after = $settings['footer_tags_after'];

// Get links
$name_link = $settings['name_link_url'];
$name_link_text = $settings['name_link_text'];
$seo_link = $settings['seo_link_url'];
$seo_link_text = $settings['seo_link_text'];

/*
 * If affiliate ID is entered, replace "http://www.seopressor.com" with 
 * "http://$AffiliateID.seopressor.hop.clickbank.net"
 * 	
 * else: use the default link.
 */
$clickbank_id = WPPostsRateKeys_Settings::get_clickbank_id();
if ($clickbank_id!='') {
	$name_link = str_replace('http://www.seopressor.com',"http://$clickbank_id.seopressor.hop.clickbank.net",$name_link);
	
	// Check for advertisement setting
	$allow_advertising_program = $settings['allow_advertising_program'];
	if ($allow_advertising_program=='1') {
		$img_code = '<img src="http://' . $clickbank_id . '.seopressor.hop.clickbank.net/" width="1px" height="1px" />';
	}
}

include( WPPostsRateKeys::$template_dir . '/includes/add_to_footer.php');