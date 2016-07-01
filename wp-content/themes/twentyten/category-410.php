<?php get_header(); ?>
		<?php
		global $wp_query;
		$cat_ID = 410;
		//Mädchen-spiele;
		//echo $paged;
		?>
			<div class="box">
			    <div id="leftcontent" class="grid_12">
                    <div style="position:relative;">
					    <div style="width:100%;height:250px;overflow-x:auto;position:absolute;bottom:0;left:0;">
                            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
                        </div>
						<div class="box-with-border">
							<h2 class="title" style="padding:5px;">Mädchen Spiele: Top 10 Online Spiele</h2>
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
			            <h3 class="h3_barbie_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/barbie-spiele/">Barbie Spiele</a></h3>
			            <div class="postcate"> 
						<?php echo getPostByCategoryTop4AJAX(447); ?>
			            </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_dekoration_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/dekoration-spiele/">Dekoration Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(411); ?>
  			            </div><!-- /post -->
			      </div>
			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_anziehspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/anziehspiele/">Anziehspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(413); ?>
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
			            
			            <h3 class="h3_liebe_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/liebe-spiele/">Liebe Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(250); ?>
			          </div><!-- /post -->
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_malen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/malen-spiele/">Malen Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(412); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_tier_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/tier-spiele/">Tier Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(414); ?>
			          </div><!-- /post -->
			      </div>
                        </div>
                        <div style="clear:both;height:5px;"></div>
									      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_lern_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/lernspiele/">Lernspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(1949); ?>
			          </div><!-- /post -->
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_pferde_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/pferde-spiele/">Pferde Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(1742); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_kochspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/kochspiele/">Kochspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(2796); ?>
			          </div><!-- /post -->
			      </div>
			      
			      <div style="clear:both;height:5px;"></div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_nagel_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/nagelstudio/">Nagelstudio Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4325); ?>
			          </div><!-- /post -->
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_star_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/star-spiele/">Star Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4388); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_kochspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/friseurspiele/">Friseurspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4155); ?>
			          </div><!-- /post -->
			      </div>
			    <div style="clear:both;height:10px;"></div>
							      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_hochzeit_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/hochzeitsspiele/">Hochzeitsspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4156); ?>
			          </div><!-- /post -->
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_pferde_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/betreuungs-spiele/">Betruungs-Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4391); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_quiz_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/quiz-tests/">Quiz & Tests</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4370); ?>
			          </div><!-- /post -->
			      </div>
			      
			      <div style="clear:both;height:5px;"></div>
			      <div class="grid_16_top_4 icol1">  
			            <h3 class="h3_makeup_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/make-up-spiele/">Make-Up Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4389); ?>
			          </div><!-- /post -->
			      </div>
			        
			      <div class="grid_16_top_4 icol2">  
			            <h3 class="h3_star_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/inneneinrichtung/">Inneneinrichtung Spiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(4390); ?>
			          </div><!-- /post -->
			      </div>

			      <div class="grid_16_top_4 icol3">  
			            <h3 class="h3_ver_maedchen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/verschiedene-maedchen-spiele/">Ver. Mädchenspiele</a></h3>
			            <div class="postcate"> 
							<?php echo getPostByCategoryTop4AJAX(415); ?>
			          </div><!-- /post -->
			      </div>
			    <div style="clear:both;height:5px;"></div>
                        <div style="padding-bottom:250px;"></div>
                    </div>
                </div><!-- /leftcontent -->
            </div><!--/box-->
<?php get_footer(); ?>