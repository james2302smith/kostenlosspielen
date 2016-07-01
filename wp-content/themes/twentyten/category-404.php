<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 404;
		//Brettspiele;
		//echo $paged;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Brettspiele: Top 10 Online Spiele</h2>
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
								<h3 class="h3_blackjack_index">
								<a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/blackjack-spiele/">Blackjack Spiele</a></h3>
								<div class="postcate">
									<?php echo getPostByCategoryTop6AJAX(406); ?>
								</div>
								<!-- /post -->
							</div>
							<div class="grid_16_top_6 icol2">
								<h3 class="h3_solitaire_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/solitaer-spiele/">Solitär Spiele</a></h3>
								<div class="postcate">
									<?php echo getPostByCategoryTop6AJAX(407); ?>
								</div>
								<!-- /post -->
							</div>
							<div class="grid_16_top_6 icol3">
								<h3 class="h3_memory_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/memory-spiele/">Memory Spiele</a></h3>
								<div class="postcate">
									<?php echo getPostByCategoryTop6AJAX(408); ?>
								</div>
								<!-- /post -->
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
                            <h3 class="h3_poker_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/poker-spiele/">Poker Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(405); ?>
                            </div>
                            <!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol2">
                            <h3 class="h3_tictactoe_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/tic-tac-toe/">Tic Tac Toe</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(1264); ?>
                            </div>
                            <!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol3">
                            <h3 class="h3_verschidene_rennspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/kartenspiele/">Kartenspiele</a>
                            </h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(569); ?>
                            </div>
                            <!-- /post -->
                        </div>
                        </div>
                   <div style="clear:both;height:5px;"></div>
                    <div>
                        <div class="grid_16_top_6 icol1">
                            <h3 class="h3_casino_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/casino-spiele/">Casino Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(4172); ?>
                            </div>
                            <!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol2">
                            <h3 class="h3_roulette_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/roulette-spiele/">Roulette Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(1664); ?>
                            </div>
                            <!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol3">
                            <h3 class="h3_verschidene_rennspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/verschiedene-brettspiele/">Verschiedene
                                    Brettspiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(409); ?>
                            </div>
                            <!-- /post -->
                        </div>
                    </div>		
                   <div style="clear:both;height:10px;"></div>
					
                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>