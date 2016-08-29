<?php get_header(); ?>
<?php get_sidebar(); ?>
		<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $tag_name=get_query_var('tag');
        $tag = get_term_by('slug', $tag_name, 'post_tag');
        $term_uid = $tag->term_id;
		 
		?>
		<div class="col1">
			<div class="box">
			    <div id="leftcontent" class="grid_12">
			          <h1>Kostenlose Spiele nach <?php echo ucfirst($tag->name); ?></h1>
			        <?php 
   $query_tag_games = "SELECT $wpdb->posts.* FROM $wpdb->posts,$wpdb->term_taxonomy,$wpdb->term_relationships WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type='post' AND $wpdb->term_taxonomy.term_id=".$term_uid." AND $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id AND $wpdb->term_relationships.object_id=$wpdb->posts.id AND $wpdb->term_taxonomy.taxonomy='post_tag' ORDER BY comment_count DESC LIMIT 100";
   $pageposts = $wpdb->get_results($query_tag_games, OBJECT);
     $counter=0;
      ?>     
			
				  <div class="ads_top">
				  	<div class="ads_top_item ads_top_left">
				  		<script type="text/javascript"><!--
google_ad_client = "ca-pub-2394577543361208";
/* kostenlosspielenbiz_index_300_right */
google_ad_slot = "7263029967";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
				  	</div>
				  	<div class="ads_top_item">
				  		<script type="text/javascript"><!--
google_ad_client = "ca-pub-2394577543361208";
/* kostenlosspielenbiz_index_300_right */
google_ad_slot = "7263029967";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
				  	</div>
				  </div>
				  <div style="clear:both;">
			      <div class="category_list">       
			  <?php if ($pageposts):
			   foreach ($pageposts as $post):
			         setup_postdata($post);
					 $game_views= intval(get_post_meta($post->ID,'pvc_views',true))+6923;
					 $game_intro=get_post_meta($post->ID, "intro", $single = true);
			   	  if($counter==15){ ?>
				    <div style="clear:both;height:5px;background:#CDEEFF;"></div>
				      <div style="border-right:5px solid #CDEEFF;">
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
				      <div style="clear:both;height:5px;background:#CDEEFF;"></div>				
			      <?php } 			   	  	
			      if(($counter!=0) &&(($counter % 5 ==0))){ ?>
			      	<div style="clear:both;"></div>
			      <?php } 
			      if($counter % 5 ==0){
			      	?><div class="meist_game_item_1"> 
			      <?php
			      }else{
			      	?><div class="meist_game_item">
			      <?php }?>
						<div class="meist_item_thumbs">
			                <a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><img src="<?php echo get_post_meta($post->ID, "image", $single = true); ?>" width="120" height="89" alt="<?php the_title(); ?>" title="<?php echo $game_intro; ?>" /></a>
      					</div>
      					<div class="meist_item_text">
      						<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
      						<center><?php echo $game_views; ?>-mal gespielt</center>
      					</div>
			      </div>
			   <?php 
			   $counter++;
			   endforeach;
			  endif; ?>
			  	 	      <?php
				   if($counter<15){
				   		?>
				  <div style="clear:both;height:5px;"></div>
			      	<div style="margin-left:6px;">
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
			      <div style="clear:both;height:5px;"></div>				

				   		<?php
				   }?>

			        <div style="clear:both;height:0px;"></div>
			        </div><!-- /end of category_list -->
			    </div><!-- /leftcontent --> 
			</div><!--/box-->
		</div><!--/col1-->



<?php get_footer(); ?>