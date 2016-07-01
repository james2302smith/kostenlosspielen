<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 261;
		//weitere-spiele;
		//echo $paged;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Weitere Spiele: Top 10 Online Spiele</h2>
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
                                <h3 class="h3_2_spieler_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/2-spieler/">2 Spieler</a></h3>
                                <div class="postcate">
                                    <?php echo getPostByCategoryTop6AJAX(3818); ?>
                                </div><!-- /post -->
                            </div>

                            <div class="grid_16_top_6 icol2">
                                <h3 class="h3_farm_spiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/farm-spiele/">Farm Spiele</a></h3>
                                <div class="postcate">
                                    <?php echo getPostByCategoryTop6AJAX(3894); ?>
                                </div><!-- /post -->
                            </div>

                            <div class="grid_16_top_6 icol3">
                                <h3 class="h3_ritter_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/ritter/">Ritter</a></h3>
                                <div class="postcate">
                                    <?php echo getPostByCategoryTop6AJAX(2263); ?>
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
                                <h3 class="h3_2_spieler_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/zeitmanagement-spiele/">Zeitmanagement Spiele</a></h3>
                                <div class="postcate">
                                    <?php echo getPostByCategoryTop6AJAX(5078); ?>
                                </div><!-- /post -->
                            </div>
                            <div class="grid_16_top_6 icol2">
                                <h3 class="h3_farm_spiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/kinderspiele/">Kinderspiele</a></h3>
                                <div class="postcate">
                                    <?php echo getPostByCategoryTop6AJAX(5438); ?>
                                </div><!-- /post -->
                            </div>
                            <div class="grid_16_top_6 icol3">
                                <h3 class="h3_farm_spiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/weitere/">Weitere Spiele</a></h3>
                                <div class="postcate">
                                    <?php echo getPostByCategoryTop6AJAX(3898); ?>
                                </div><!-- /post -->
                            </div>
                        </div>
                        <div style="clear:both;height:5px;"></div>
                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>