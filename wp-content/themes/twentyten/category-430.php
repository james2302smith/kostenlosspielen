<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 430;
		//Rennspiele;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Rennspiele: Top 10 Online Spiele</h2>
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
                       <div class="grid_16_top_6 icol1">
                            <h3 class="h3_autorennen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/autorennen-spiele/">Autorennen Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(425); ?>
                            </div>
                            <!-- /post -->
                        </div>

                        <div class="grid_16_top_6 icol2">
                            <h3 class="h3_motocross_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/motocross-spiele/">Motocross Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(426); ?>
                            </div>
                            <!-- /post -->
                        </div>

                        <div class="grid_16_top_6 icol3">
                            <h3 class="h3_motorrad_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/motorrad-spiele/">Motorrad Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(427); ?>
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
                            <h3 class="h3_boots_index"><a rel="nofollow"
                                                          href="<?php echo SITE_ROOT_URL ?>/rennspiele/boot-rennen-spiele/">Boot
                                    Rennen Spiele</a></h3>

                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(428); ?>
                            </div>
                            <!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol2">
                            <h3 class="h3_rallye_index"><a rel="nofollow"
                                                           href="<?php echo SITE_ROOT_URL ?>/rennspiele/rallye/">Rallye
                                    Spiele</a></h3>

                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(3415); ?>
                            </div>
                            <!-- /post -->
                        </div>

                        <div class="grid_16_top_6 icol3">
                            <h3 class="h3_formel_index"><a rel="nofollow"
                                                           href="<?php echo SITE_ROOT_URL ?>/rennspiele/formel-1/">Formel-1
                                    Spiele</a></h3>

                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(2114); ?>
                            </div>
                            <!-- /post -->
                        </div>
                    </div>

                    <div style="clear:both;height:5px;"></div>
                    <div>
                        <div class="grid_16_top_6 icol1">
                            <h3 class="h3_zug_index"><a rel="nofollow"
                                                        href="<?php echo SITE_ROOT_URL ?>/rennspiele/zug-spiele/">Zug
                                    Spiele</a></h3>

                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(4649); ?>
                            </div>
                            <!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol2">
                            <h3 class="h3_quad_index"><a rel="nofollow"
                                                         href="<?php echo SITE_ROOT_URL ?>/rennspiele/quad-spiele/">Quad
                                    Spiele</a></h3>

                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(4650); ?>
                            </div>
                            <!-- /post -->
                        </div>

                        <div class="grid_16_top_6 icol3">
                            <h3 class="h3_ver_rennspiele_index"><a rel="nofollow"
                                                                   href="<?php echo SITE_ROOT_URL ?>/rennspiele/pimp-my-ride/">Pimp
                                    My Ride</a></h3>

                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(4005); ?>
                            </div>
                            <!-- /post -->
                        </div>
                    </div>
                    <div style="clear:both;height:5px;"></div>
 
					                        <div style="clear:both;height:5px;"></div>

                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>