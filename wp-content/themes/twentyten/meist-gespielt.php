<?php
/*
Template Name: Meist Gespielt Spiele
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="box">
	<div id="leftcontent_full" class="grid_12">
		<div style="position:relative;">
		<div style="width:100%;height:250px;border-bottom:1px solid #99D6FF;overflow-y:auto;overflow-x:hidden;position:absolute;bottom:0;left:0;">
		<?php dynamic_sidebar( 'first-footer-widget-area' ); ?></div>	
		<div>
		<div class="category_top"><h1>Top 100 meist gespielten Spiele</h1></div>        

		<?php 
//$query_popular_games = "SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post' ORDER BY RAND() LIMIT $start, $posts_per_page";   
   $query_popular_games="SELECT * FROM kostenlosspielen_posts
					WHERE post_status =  'publish'
					AND post_type =  'post'
					ORDER BY game_views DESC LIMIT 100"; 
   $pageposts = $wpdb->get_results($query_popular_games, OBJECT);
	
	 $counter=0;
	  ?>     
		<div>
  <?php if ($pageposts):
   foreach ($pageposts as $post):
		 setup_postdata($post); 
		 $game_views= $post->game_views;
		 $game_intro=get_post_meta($post->ID, "intro", $single = true);
		 $image= get_post_meta($post->ID, "image", $single = true); 
		 
	  if($counter==12||$counter==24){ ?>
		<div style="clear:both;height:5px;background:#CDEEFF;"></div>
		  <div class="ads_text">Werbung</div>
		  <div style="border-right:5px solid #CDEEFF;text-align:center;">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-2394577543361208";
				/* kostenlosspielenbiz_index_728 */
				google_ad_slot = "9196115111";
				google_ad_width = 728;
				google_ad_height = 90;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
		  <div style="clear:both;height:10px;background:#CDEEFF;margin-bottom:10px;"></div>				
		  <?php } 			   	  	
		  if($counter % 4 ==0){ ?>
			<div style="clear:both;"></div>
		  <?php } ?>
			<div class="meist_game_item">
				<div class="meist_item_thumbs">
					<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><img src="<?php echo $image; ?>" width="200" height="150" alt="<?php the_title(); ?>" title="<?php echo $game_intro; ?>" /></a>
				</div>
				<div class="meist_item_text">
					<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
				</div>
			</div>
   <?php 
   $counter++;
   endforeach;
  endif; ?>
		<div style="clear:both;height:0px;"></div>
		</div><!-- /end of category_list -->
		<div style="clear:both;height:5px;"></div>
		</div>
		<div style="padding-bottom:250px;"></div>	
		</div>					
	</div><!-- /leftcontent --> 
</div><!--/box-->


<?php get_footer(); ?>