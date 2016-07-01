<?php
/*
Template Name: Jetzt Spielen auf www.kostenlosspielen.biz
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>
		<div class="col1">
			<div class="box">
			    <div id="leftcontent" class="grid_12">
			      <div id="post_title">
			          <h1>Jetzt spielen</h1>
			      </div>
				  <div style="clear:both;height:0px;"></div>				  
   			      <div class="category_list">       

			        <?php 
		   
		$query = "SELECT distinct rating_postid FROM  `kostenlosspielen_ratings` WHERE rating_username='Guest'";
		$pageposts = $wpdb->get_results($query, OBJECT);
		$post_arr=array();
		$counter=0;
		foreach ($pageposts as $post){
			
			$post_id=$post->rating_postid;
			$query2='SELECT count(rating_id) as num FROM `kostenlosspielen_ratings` WHERE rating_postid='.$post_id.' ORDER BY num desc';
			$count_arr=$wpdb->get_results($query2, OBJECT);
			//print_r($count_arr);
			if(($count_arr[0]->num > 10) && ($post_id!=2))
			{
				//echo $i.'-'.$post_id.'-'.$count_arr[0]->num.'<br />';
				$title=get_the_title($post_id);
				$link=get_permalink($post_id);
				
		   	    if($counter==0||$counter==12||$counter==24){ ?>
				    <div style="clear:both;height:5px;background:#CDEEFF;"></div>
				      <div class="ads_text">Werbung</div>
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
				      <div style="clear:both;height:10px;background:#CDEEFF;margin-bottom:10px;"></div>				
			      <?php } 			   	  	

			      if(($counter!=0) &&(($counter % 4 ==0))){ ?>
			      	<div style="clear:both;"></div>
			      <?php } 
			      if($counter % 4 ==0){
			      	?><div class="game_js_item_1"> 
			      <?php
			      }else{
			      	?><div class="game_js_item">
			      <?php }?>
						<div class="meist_item_thumbs">
			                <a title="<?php echo $title; ?>" href="<?php echo $link; ?>" rel="bookmark"><img src="<?php echo get_post_meta($post_id, "image", $single = true); ?>" width="150" height="113" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" /></a>
      					</div>
      					<div class="meist_item_text">
      						<a title="<?php echo $title; ?>" href="<?php echo $link; ?>"><?php echo $title; ?></a>
      						<center><?php the_ratings_js($post_id); ?></center>
      						
      					</div>
			      </div>
				  <?php
				  $counter++;
			}
		}
			      ?>     
			        <div style="clear:both;height:0px;"></div>
			        </div><!-- /end of category_list -->
			    </div><!-- /leftcontent --> 
			</div><!--/box-->
		</div><!--/col1-->

<?php get_footer(); ?>