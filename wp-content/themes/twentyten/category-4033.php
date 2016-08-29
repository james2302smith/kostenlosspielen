<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = get_query_var('cat');
		//echo $paged;
		?>
		
		<div class="col1">
			<div class="box">
				<div id="leftcontent" class="grid_12">
					<div style="position:relative;">
					<div style="width:100%;height:250px;border-bottom:1px solid #99D6FF;overflow-y:auto;overflow-x:hidden;position:absolute;bottom:0;left:0;">
					<?php dynamic_sidebar( 'first-footer-widget-area' ); ?></div>	
					  <div>
					  <div style="clear:both;height:5px;"></div>
					  <div class="ads_text">Werbung</div>			    
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
					  <div style="clear:both;height:10px;"></div>				
							
					  <div class="grid_16_top_4 icol1">  
							<h3 class="h3_mickey_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/mickey-spiele/">Mickey Spiele</a></h3>
							<div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(1587); ?>
							</div><!-- /post -->
					  </div>

					  <div class="grid_16_top_4 icol2">  
							<h3 class="h3_hunde_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/hunde-spiele/">Hunde Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4034); ?>
							</div><!-- /post -->
					  </div>
					
					  <div class="grid_16_top_4 icol3">  
							<h3 class="h3_penguin_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/penguin-spiele/">Penguin Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(1567); ?>
						  </div><!-- /post -->
					  </div>

					<div style="clear:both;height:5px;"></div>				

					  <div class="grid_16_top_4 icol1">  
							<h3 class="h3_ratte_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/ratte-spiele/">Ratte</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4037); ?>
						  </div><!-- /post -->
					  </div>
						
					  <div class="grid_16_top_4 icol2">  
							<h3 class="h3_delfin_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/delfin-spiele/">Delfin Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4035); ?>
						  </div><!-- /post -->
					  </div>

					  <div class="grid_16_top_4 icol3">  
							<h3 class="h3_drache_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/drache-spiele/">Drache Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4039); ?>
						  </div><!-- /post -->
					  </div>

					<div style="clear:both;height:5px;"></div>
					  <div class="ads_text">Werbung</div>			    
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
					  <div style="clear:both;height:10px;"></div>				

					  <div class="grid_16_top_4 icol1">  
							<h3 class="h3_elefante_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/elefanten-spiele/">Elefanten Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4036); ?>
						  </div><!-- /post -->
					  </div>
						
					  <div class="grid_16_top_4 icol2">  
							<h3 class="h3_haehnchen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/haehnchen-spiele/">Hähnchen Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4038); ?>
						  </div><!-- /post -->
					  </div>

					  <div class="grid_16_top_4 icol3">  
							<h3 class="h3_biene_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/biene-spiele/">Biene Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4050); ?>
						  </div><!-- /post -->
					  </div>
					  <div style="clear:both;height:5px;"></div>				

					  <div class="grid_16_top_4 icol1">  
							<h3 class="h3_donald_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/donald-duck/">Donald Duck</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(3090); ?>
						  </div><!-- /post -->
					  </div>
						
					  <div class="grid_16_top_4 icol2">  
							<h3 class="h3_baeren_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/baeren-spiele/">Bären Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4045); ?>
						  </div><!-- /post -->
					  </div>

					  <div class="grid_16_top_4 icol3">  
							<h3 class="h3_fisch_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/fischspiele/">Fischspiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4049); ?>
							</div><!-- /post -->
					  </div>

					<div style="clear:both;height:5px;"></div>
					  <div class="ads_text">Werbung</div>			    
					  <div style="margin-left:3px;">
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

					  <div style="clear:both;height:10px;"></div>				

					  <div class="grid_16_top_4 icol1">  
							<h3 class="h3_tom_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/tom-jerry/">Tom & Jerry</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4046); ?>
						  </div><!-- /post -->
					  </div>
					  <div class="grid_16_top_4 icol2">  
							<h3 class="h3_hamster_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/hamster-spiele/">Hamster Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(1006); ?>
						  </div><!-- /post -->
					  </div>
					  <div class="grid_16_top_4 icol3">  
							<h3 class="h3_insekt_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/insekten-spiele/">Insekten Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4047); ?>
						  </div><!-- /post -->
					  </div>
					  <div style="clear:both;height:5px;"></div>				
					  <div class="grid_16_top_4 icol1">  
							<h3 class="h3_katze_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/katze-spiele/">Katze Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(1318); ?>
						  </div><!-- /post -->
					  </div>
					  <div class="grid_16_top_4 icol2">  
							<h3 class="h3_naruto_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/naruto-spiele/">Naruto Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4048); ?>
						  </div><!-- /post -->
					  </div>
					  <div class="grid_16_top_4 icol3">  
							<h3 class="h3_loewen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/loewen-spiele/">Löwen Spiele</a></h3>
							<div class="postcate"> 
								<?php echo getPostByCategoryTop4AJAX(4044); ?>
						  </div><!-- /post -->
					  </div>
					<div style="clear:both;height:5px;"></div>
					</div>
					<div style="padding-bottom:250px;"></div>
			    </div>
			    </div><!-- /leftcontent --> 
			</div><!--/box-->
		</div><!--/col1-->
<?php get_sidebar(); ?>


<?php get_footer(); ?>