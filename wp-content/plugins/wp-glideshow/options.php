<?php
$location = $options_page; // Form Action URI
?>

<div class="wrap">
	<h2>WP Glideshow Configuration</h2>
	<h3>General Adjustments</h3>
      <p>Give general Information concerning your Glideshow</p>
	
    <div style="margin-left:0px;">
    <form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
		<fieldset name="general_options" class="options">
        
	Order Content by:<br /><br/>
		<div style="margin:0;padding:0;">
        <select name="glideshow-order" id="glideshow-order">
		<option value="date" <?php if(get_option('glideshow-order') == "date") {echo "selected='selected'";}?>>Date</option>
		<option value="title" <?php if(get_option('glideshow-order') == "title") {echo "selected='selected'";}?>>Title</option>
	</select>
        </div><br />
		
	Sort Content:<br /><br/>
		<div style="margin:0;padding:0;">
        <select name="glideshow-sort" id="glideshow-sort">
		<option value="desc" <?php if(get_option('glideshow-sort') == "desc") {echo "selected='selected'";}?>>Descending</option>
		<option value="asc" <?php if(get_option('glideshow-order') == "asc") {echo "selected='selected'";}?>>Ascending</option>
	</select>
        </div><br />
	
        Text length (Number of chars, Default: 200):<br />
		<div style="margin:0;padding:0;">
        <input name="glideshow-text-length" id="glideshow-text-length" size="25" value="<?php echo get_option('glideshow-text-length'); ?>"></input>   
        </div><br />

        Navigation Next Button: (e.g. forward)<br />
		<div style="margin:0;padding:0;">
        <input name="glideshow-navigation-next" id="glideshow-navigation-next" size="25" value="<?php echo get_option('glideshow-navigation-next'); ?>"></input>   
        </div><br />

        Navigation Back Button: (e.g. back)<br />
		<div style="margin:0;padding:0;">
        <input name="glideshow-navigation-back" id="glideshow-navigation-back" size="25" value="<?php echo get_option('glideshow-navigation-back'); ?>"></input>   
        </div><br />

	  <h3>Slider Configuration</h3>
	  <p>Use these fields below to adjust the Sliding Options</p>

        Slide Speed (Speed of the Sliding Effect, Default: 500):<br />
		<div style="margin:0;padding:0;">
        <input name="glideshow-slider-speed" id="glideshow-slider-speed" size="25" value="<?php echo get_option('glideshow-slider-speed'); ?>"></input>   
        </div><br />

        Slide Style (Possibilities: updown, downup, leftright, rightleft, Default: rightleft):<br />
		<div style="margin:0;padding:0;">
        <input name="glideshow-slider-style" id="glideshow-slider-style" size="25" value="<?php echo get_option('glideshow-slider-style'); ?>"></input>   
        </div><br />

        Slide Autorotate (Possibilities: true, false, Default: true):<br />
		<div style="margin:0;padding:0;">
        <input name="glideshow-slider-auto" id="glideshow-slider-auto" size="25" value="<?php echo get_option('glideshow-slider-auto'); ?>"></input>   
        </div><br />

        Slide Duration (The higher, the longer it stays, Default: 4000):<br />
		<div style="margin:0;padding:0;">
        <input name="glideshow-slider-duration" id="glideshow-slider-duration" size="25" value="<?php echo get_option('glideshow-slider-duration'); ?>"></input>   
        </div><br />

	  <h3>Styling Configuration</h3>
	  <p>Use these fields below to adjust the styling of the Glideshow.<br><br>
	  <em>Remember - Image Width/Height will only be adjusted for new pictures. To resize old images use "regenerate thumbnails" - plugin.</em><br/></p>
	  
	  
	   Glideshow Text Width: (Default: 290)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-text-width" id="glideshow-text-width" size="25" value="<?php echo get_option('glideshow-text-width'); ?>"></input>   
        </div><br />
	  
	   Glideshow Image Width: (Default: 300)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-img-width" id="glideshow-img-width" size="25" value="<?php echo get_option('glideshow-img-width'); ?>"></input>   
        </div><br />
	  
	    Glideshow Image Height: (Default: 250)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-img-height" id="glideshow-img-height" size="25" value="<?php echo get_option('glideshow-img-height'); ?>"></input>   
        </div><br />
	  
	    Glideshow Heading Size: (Default: 18)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-title-size" id="glideshow-title-size" size="25" value="<?php echo get_option('glideshow-title-size'); ?>"></input>   
        </div><br />

	  Glideshow Background Colour: (Default: EEE)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-background-color" id="glideshow-background-color" size="25" value="<?php echo get_option('glideshow-background-color'); ?>"></input>   
        </div><br />

	  Glideshow Border Colour: (Default: CCC)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-border-color" id="glideshow-border-color" size="25" value="<?php echo get_option('glideshow-border-color'); ?>"></input>   
        </div><br />

	  Glideshow Text Color: (Default: 3b3b3b)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-text-color" id="glideshow-text-color" size="25" value="<?php echo get_option('glideshow-text-color'); ?>"></input>   
        </div><br />

	  Glideshow Navigation Background Color: (Default: FFF)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-navigation-background-color" id="glideshow-navigation-background-color" size="25" value="<?php echo get_option('glideshow-navigation-background-color'); ?>"></input>   
        </div><br />

	  Glideshow Navigation Color: (Default: 3b3b3b)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-navigation-color" id="glideshow-navigation-color" size="25" value="<?php echo get_option('glideshow-navigation-color'); ?>"></input>   
        </div><br />

	  Glideshow Navigation Active Background Color: (Default: 3b3b3b)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-navigation-active-background-color" id="glideshow-navigation-active-background-color" size="25" value="<?php echo get_option('glideshow-navigation-active-background-color'); ?>"></input>   
        </div><br />

	  Glideshow Navigation Active Color: (Default: FFF)<br />
	  <div style="margin:0;padding:0;">
        <input name="glideshow-navigation-active-color" id="glideshow-navigation-active-color" size="25" value="<?php echo get_option('glideshow-navigation-active-color'); ?>"></input>   
        </div><br />
                
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="glideshow-title-size,glideshow-text-width, glideshow-order, glideshow-sort,glideshow-img-width, glideshow-img-height,glideshow-slider-speed,glideshow-slider-style,glideshow-slider-auto,glideshow-slider-duration,glideshow-text-length,glideshow-navigation-next,glideshow-navigation-back,glideshow-background-color,glideshow-border-color,glideshow-text-color,glideshow-navigation-background-color,glideshow-navigation-color,glideshow-navigation-active-background-color,glideshow-navigation-active-color" />

		</fieldset>
		<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p>
	</form>      
</div>