<?php 
/**
 * Template for the HTMl to add to WP footer
 * 
 * @uses 	string 		$seo_link
 * @uses 	string 		$seo_link_text
 * @uses 	string 		$name_link
 * @uses 	string 		$name_link_text
 * @uses 	string		$footer_text_color
 * @uses 	string		$footer_tags_before
 * @uses 	string		$footer_tags_after
 * @uses 	string		$img_code
 * 
 * @version v5.0
 * 
 */
?>
<div style="text-align: center">
	<?php echo $footer_tags_before ?>
		<?php _e('Wordpress ','seo-pressor');?>
		<a href="<?php echo $seo_link; ?>" style="color:<?php echo $footer_text_color?>;"><?php echo $seo_link_text; ?></a>
		<?php _e(' Plugin by ','seo-pressor');?>
		<a href="<?php echo $name_link; ?>" style="color:<?php echo $footer_text_color?>;"><?php echo $name_link_text; ?></a>
	<?php echo $footer_tags_after ?>
	<?php if (isset($img_code)) echo $img_code?>
</div>
