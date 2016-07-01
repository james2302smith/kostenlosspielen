<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 394;
		//geschicklickeitspiele;
		//echo $paged;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Geschicklichkeitsspiele: Top 10 Online Spiele</h2>
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
			            <h3 class="h3_tetris_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/tetris-spiele/">Tetris Spiele</a></h3>
			            <div class="postcate"> 
			       			<?php echo getPostByCategoryTop4AJAX(169); ?>
			            </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_bubbles_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/bubbles-spiele/">Bubbles Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(397); ?>			            	
  			            </div><!-- /post -->
			      </div>
		        
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_pacman_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/pacman-spiele/">Pacman Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(395); ?>
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
			            <h3 class="h3_puzzle_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/puzzle-spiele/">Puzzle Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(271); ?>
			          </div><!-- /post -->
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_parkspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/parkspiele/">Parkspiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(399); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_pinball_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/pinball-spiele/">Pinball Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(400); ?>
			          </div><!-- /post -->
			      </div>		    
                        <div style="clear:both;height:5px;"></div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_breakout_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/breakout-spiele/">Breakout Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(401); ?>
			          </div>
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_reaktion_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/reaktion-spiele/">Reaktion Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(402); ?>
			          </div>
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_snake_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/snake-spiele/">Snake Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(398); ?>
			          </div>
			      </div>
			      <div style="clear:both;height:5px;"></div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_konzentration_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/konzentrationsspiele/">Konzentrationspiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(4269); ?>
			          </div>
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_gold_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/gold-miner/">Gold Miner</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(1310); ?>
			          </div>
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_distanz_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/distanz-rekord/">Distanz-Rekord Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(4154); ?>
			          </div>
			      </div>

			    <div style="clear:both;height:5px;"></div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_ausweich_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/ausweichspiele/">Ausweichspiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(4326); ?>
			          </div>
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_zielen_schiessen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/zielen-schiessen/">Zielen & Schießen Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(4327); ?>
			          </div>
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_sammeln_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/sammeln-spiele/">Sammeln-Spiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(4328); ?>
			          </div>
			      </div>
			      <div style="clear:both;height:5px;"></div>

			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_fangspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/fangspiele/">Fangspiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(4329); ?>
			          </div>
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_zielen_schiessen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/verschiedene-geschicklichkeitsspiele/">Ver. Geschicklichkeitspiele</a></h3>
			            <div class="postcate"> 
			            	<?php echo getPostByCategoryTop4AJAX(403); ?>
			          </div>
			      </div>
			      <div style="clear:both;height:5px;"></div>
			    <div style="clear:both;height:5px;"></div>
                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>