<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 385;
		//action-spiele;
		//echo $paged;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Action Spiele: Top 10 Online Spiele</h2>
							<div class="body">
								<?php echo getTop10PopularGames($cat_ID); ?>
							</div>
						</div>                     
						<div style="clear:both;height:10px;"></div>
								<div class="box-with-border category-3-ads-box">
									<p class="title">Werbung</p>
									<div class="body">
										<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
										<!-- kostenlosspielenbiz_index_728 -->
										<ins class="adsbygoogle"
											 style="display:inline-block;width:728px;height:90px"
											 data-ad-client="ca-pub-2394577543361208"
											 data-ad-slot="9196115111"></ins>
										<script>
										(adsbygoogle = window.adsbygoogle || []).push({});
										</script>
									</div>
								</div>                                        
						<div style="clear:both;height:10px;"></div>
                        <div>
				   <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_bomberman_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/bomberman-spiele/">Bomberman Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(388); ?>
  			            </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_tower_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/turmverteidigung-spiele/">Turmverteidigung Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(392); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_krieg_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/kriegsspiele/">Kriegsspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(390); ?>
			          </div><!-- /post -->
			      </div>						

                        </div>
						<div style="clear:both;height:5px;"></div>
								<div class="box-with-border category-3-ads-box">
									<p class="title">Werbung</p>
									<div class="body">
										<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
										<!-- kostenlosspielenbiz_index_728 -->
										<ins class="adsbygoogle"
											 style="display:inline-block;width:728px;height:90px"
											 data-ad-client="ca-pub-2394577543361208"
											 data-ad-slot="9196115111"></ins>
										<script>
										(adsbygoogle = window.adsbygoogle || []).push({});
										</script>
									</div>
								</div>                                        
						<div style="clear:both;height:10px;"></div>
                        <div>
                             <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_piraten_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/piraten-spiele/">Piraten Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4208); ?>
  			            </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_invaders_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/space-invaders-spiele/">Space Invaders</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4187); ?>
  			            </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_asteroids_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/asteroids/">Asteroids Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(2534); ?>
			          </div><!-- /post -->
			      </div>		        			    
                        <div style="clear:both;height:5px;"></div>
						
						<div class="grid_16_top_4 icol1">  
			            <h3 class="h3_batman_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/batman-spiele/">Batman Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4239); ?>
  			            </div><!-- /post -->
			      </div>
  			      <div class="grid_16_top_4 icol2">  
						<h3 class="h3_roboter_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/roboter-spiele/">Roboter-Spiele</a></h3>
						<div class="postcate"> 
						<?php echo getPostByCategoryTop4AJAX(4240); ?>
			            </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_tanks_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/tanks/">Tanks</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(3067); ?>
			          </div><!-- /post -->
			      </div>
						                        <div style="clear:both;height:5px;"></div>
 <div class="grid_16_top_4 icol1">  
						<h3 class="h3_strategy_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/strategie-spiele/">Strategie Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(389); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_flugzeug_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/flugzeug-spiele/">Flugzeug Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(391); ?>
			          </div><!-- /post -->
			      </div>
				  <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_mafia_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/mafia-spiele/">Mafia Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4209); ?>
			          </div><!-- /post -->
			      </div>

			    <div style="clear:both;height:5px;"></div>
			    <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_baller_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/ballerspiele/">Ballerspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(389); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			       <h3 class="h3_invaders_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/verschiedene-actionspiele/">Verschiedene Actionspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(391); ?>
			          </div><!-- /post -->
			      </div>
			    <div style="clear:both;height:5px;"></div>
                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>