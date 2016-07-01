<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 431;
		//Sportspiele;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Sportspiele: Top 10 Online Spiele</h2>
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
                        <div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_football_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/fussball-spiele/">Fußball Spiele</a></h3>
			            <div class="postcate"> 
						<?php echo getPostByCategoryTop6AJAX(432); ?>
			            </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_basketball_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/basketball-spiele/">Basketball Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(433); ?>
  			            </div><!-- /post -->
			      </div>
		        
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_billard_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/billard-spiele/">Billard Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(342); ?>
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
			            <h3 class="h3_bowling_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/bowling-spiele/">Bowling Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(435); ?>
			          </div><!-- /post -->
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_boxen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/boxen-spiele/">Boxen Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(436); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_golf_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/golf-spiele/">Golf Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(437); ?>
			          </div><!-- /post -->
			      </div>
                    </div>

                    <div style="clear:both;height:5px;"></div>
                    <div>
 			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_ski_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/ski-spiele/">Ski Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(438); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_tennis_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/tennis-spiele/">Tennis Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(434); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_skate_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/skate-spiele/">Skate Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(4651); ?>
			          </div><!-- /post -->
			      </div>

                    </div>
                    <div style="clear:both;height:5px;"></div>
 
					                        <div style="clear:both;height:5px;"></div>

                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>