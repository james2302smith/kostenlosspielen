<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 417;
		//Denkspiele;
		//echo $paged;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Denkspiele: Top 10 Online Spiele</h2>
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
			      <div class="grid_16_top_6 icol1">  
			            <h3 class="h3_mahjong_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/mahjong-spiele/">Mahjong Spiele</a></h3>
			            <div class="postcate"> 
						<?php echo getPostByCategoryTop6AJAX(104); ?>
			            </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_6 icol2">  
			            <h3 class="h3_sudoku_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/sudoku-spiele/">Sudoku Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(419); ?>
  			            </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_6 icol3">  
			            <h3 class="h3_schach_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/schach-spiele/">Schach Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(418); ?>
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
			      <div class="grid_16_top_6 icol1">  
			            <h3 class="h3_unblock_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/unblock-me-spiele/">Unblock Me Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(420); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_6 icol2">  
			            <h3 class="h3_raetsel_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/raetsel-spiele/">Rätsel Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(1840); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_6 icol3">  
			            <h3 class="h3_point_and_click_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/point-and-click/">Point and Click</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop6AJAX(1935); ?>
			          </div><!-- /post -->
			      </div>
                        </div>
									      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_3_gewinnt_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/3-gewinnt-spiele/">3-Gewinnt Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(3237); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_3_wimmelbilder_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/wimmelbilder/">Wimmelbilder</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(3568); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_zuma_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/zuma/">Zuma</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(2394); ?>
			          </div><!-- /post -->
			      </div>
				  <div style="clear:both;height:5px;"></div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_minesweeper_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/minesweeper/">Minesweeper Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(2352); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_strasse_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/strasse-bauen/">Straße bauen</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4543); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_wortspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/wortspiele/">Wortspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4149); ?>
			          </div><!-- /post -->
			      </div>
				  <div style="clear:both;height:5px;"></div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_4_gewinnt_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/4-gewinnt-spiele/">4-Gewinnt Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4150); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_blocks_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/blocks-spiele/">Blocks-Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4148); ?>
			          </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_strasse_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/verschiedene-denkspiele/">Verschiedene Denkspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(421); ?>
			          </div><!-- /post -->
			      </div>
                        <div style="clear:both;height:5px;"></div>
                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>