<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 422;
		//Abenteuerspiele;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Abenteuerspiele: Top 10 Online Spiele</h2>
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
                            <h3 class="h3_mario_index"><a rel="nofollow"
                                                          href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/mario-spiele/">Mario Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(75); ?>
                            </div><!-- /post -->
                        </div>

                        <div class="grid_16_top_6 icol2">
                            <h3 class="h3_puzzlen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/puzzlen-laufen/">Puzzlen & Laufen</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(3924); ?>
                            </div><!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol3">
                            <h3 class="h3_flucht_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/fluchtspiele/">Fluchtspiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(3925); ?>
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
                            <h3 class="h3_rollen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/rollenspiele/">Rollenspiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(3923); ?>
                            </div><!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol2">
                            <h3 class="h3_sonic_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/sonic/">Sonic</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(3927); ?>
                            </div><!-- /post -->
                        </div>
                        <div class="grid_16_top_6 icol3">
                            <h3 class="h3_sammeln_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/sammeln-laufen/">Sammeln & Laufen</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop6AJAX(3926); ?>
                            </div><!-- /post -->
                        </div>
                        </div>
                        <div style="clear:both;height:5px;"></div>
						                   <div>
                        <div class="grid_16_top_4 icol1">
                            <h3 class="h3_fliegen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/fliegen-schiessen/">Fliegen & Schießen</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop4AJAX(4301); ?>
                            </div><!-- /post -->
                        </div>
                        <div class="grid_16_top_4 icol2">
                            <h3 class="h3_geister_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/geister-spiele/">Geister-Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop4AJAX(4800); ?>
                            </div><!-- /post -->
                        </div>
                        <div class="grid_16_top_4 icol3">
                            <h3 class="h3_ver_abenteuer_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/spiderman-spiele/">Spiderman Spiele</a></h3>
                            <div class="postcate">
                                <?php echo getPostByCategoryTop4AJAX(4268); ?>
                            </div><!-- /post -->
                        </div>
                    </div>
                    <div class="clear"></div>
 
					                        <div style="clear:both;height:5px;"></div>

                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>