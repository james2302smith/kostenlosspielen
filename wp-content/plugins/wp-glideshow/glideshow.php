<?php
$direct_path =  get_bloginfo('wpurl')."/wp-content/plugins/wp-glideshow";
?>

<script type="text/javascript" src="<?php echo $direct_path;?>/scripts/slider.js"></script> 

<script type="text/javascript">
featuredcontentglider.init({
gliderid: "glideshow",
contentclass: "glidecontent",
togglerid: "p-select",
remotecontent: "", //Get gliding contents from external file on server? "filename" or "" to disable
selected: 1,
persiststate: true,
speed: <?php if ( get_option('glideshow-slider-speed')) {echo get_option('glideshow-slider-speed');} else {echo '500';} ?>,
direction: "<?php if ( get_option('glideshow-slider-style')) {echo get_option('glideshow-slider-style');} else {echo 'rightleft';} ?>", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
autorotate: <?php if ( get_option('glideshow-slider-auto')) {echo get_option('glideshow-slider-auto');} else {echo 'true';} ?>, //Auto rotate contents (true/false)?
autorotateconfig: [<?php if ( get_option('glideshow-slider-duration')) {echo get_option('glideshow-slider-duration');} else {echo '4000';} ?>, 0] //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
})
</script>
<div id="slidewrapper">
        
<?php

        $order = get_option('glideshow-order');
        
        switch($order) {
                
                case "date":
                        $order = "post_date";
                        break;
                case "title":
                        $order = "post_title";
                        break;
                default:
                        $order = "post_date";
                        break;
        }
        
        $sort = get_option('glideshow-sort');
        
        switch($sort) {
                
                case "asc":
                        $sort = "ASC";
                        break;
                case "desc":
                        $sort = "DESC";
                        break;
                default:
                        $sort = "DESC";
                        break;
        }

?>

        <div id="glideshow" class="glidecontentwrapper">

                <?php
                global $wpdb;
                
                $count = 0;
                
                $counting = 1;
                
                $querystr = "
                        SELECT wposts.* FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
                        WHERE wposts.ID = wpostmeta.post_id
                        AND wpostmeta.meta_key = 'content_glider' 
                        AND wpostmeta.meta_value = '1' 
                        AND wposts.post_status = 'publish' 
                        AND (wposts.post_type = 'post' OR wposts.post_type = 'page')
                        ORDER BY $order $sort";
						
				//echo $querystr;

                $pageposts = $wpdb->get_results($querystr, OBJECT); ?>
                <?php if ($pageposts): ?>
                        <?php global $post; ?>
                        <?php foreach ($pageposts as $post): ?>
                        <?php $do_not_duplicate[$post->ID] = $post->ID; ?>
                        <?php setup_postdata($post);

                        $custom = get_post_custom($post->ID);
                        /*$chars = get_option('glideshow-text-length');
                        if(!$chars) {
                                $chars = 200;
                        }*/
                        $count ++;
						$link[$count]=SITE_ROOT_URL.'/'.$post->post_name.'.html';
                ?>
                        <div class="glidecontent">
                        	<div class="glidecontenttext">
                                        <a title="<?php echo $post->post_title; ?>" href="<?php echo SITE_ROOT_URL.'/'.$post->post_name; ?>.html"><img src="<?php echo $post->game_image; ?>" width="311" height="224" alt="<?php echo $post->post_title; ?> Spiel" title="<?php echo $post->post_title; ?> Spiel" /></a>
                                        <a title="<?php echo $post->post_title; ?>" href="<?php echo SITE_ROOT_URL.'/'.$post->post_name; ?>.html" ><h3><?php echo $post->post_title;?></h3></a>
                                        <p style="width:200px;"><?php echo $post->game_intro_home; ?></p>
                            </div>
                        <div class="glideshow_play"><a title="<?php echo $post->post_title; ?>" href="<?php echo SITE_ROOT_URL.'/'.$post->post_name; ?>.html" rel="nofollow"><img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/themes/twentyten/images/button_playnow.gif" alt="Spielen" title="spielen" height="25" width="25" class="textmiddle"  />Spielen</a></div>
                        </div>
                <?php endforeach; ?>
                <?php endif; ?>
                        <div id="p-select" class="cssbuttonstoggler">
                                <div>
                                <?php
                                        $x = 1;
                                        while($x <= $count) {
                                                echo "<a href='#' class='toc'><span>$x</span></a>";
                                                $x++;
                                        }
                                ?>
                                <a href="#" class="prev"><span><?php if(get_option('glideshow-navigation-back')) {echo get_option('glideshow-navigation-back');} else {echo "zurück";} ?></span></a> <a href="#" class="next"><span><?php if(get_option('glideshow-navigation-next')) {echo get_option('glideshow-navigation-next');} else {echo "vor";} ?></span></a></div>
            	            </div>
                        
        </div>
</div>

		