<?php get_header(); ?>
<?php 
/*
Template Name: Startseite
*/
?>
<div class="box">
	<div id="leftcontent_full" class="grid_12">
		<div style="position:relative;">
			<div style="width:100%;height:250px;border-bottom:1px solid #99D6FF;overflow-y:auto;overflow-x:hidden;position:absolute;bottom:0;left:0;">
			<?php dynamic_sidebar( 'first-footer-widget-area' ); ?></div>	
			
			<div class="box-with-border category-3-ads-box">							
					<p class="title">Werbung</p>
						<div class="body">
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
			</div>
			<div style="clear:both;height:1px;"></div>

			<div>
			   <div class="grid_16_top_4 icol1">  
			        <h3 class="h3_denk_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/">Denkspiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(417); ?>
					</div><!-- /post -->
			  </div>
			  <div class="grid_16_top_4 icol2">  
		            <h3 class="h3_geschick_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/">Geschicklichkeitsspiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(394); ?>
					</div><!-- /post -->			  
			  </div>
			  <div class="grid_16_top_4 icol3">  
			        <h3 class="h3_karten_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/">Brettspiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(404); ?>
				  </div><!-- /post -->
			  </div>						
            </div>
			<div style="clear:both;height:1px;"></div>
			<div class="box-with-border category-3-ads-box">							
					<p class="title">Werbung</p>
						<div class="body">
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
			</div>
			<div style="clear:both;height:1px;"></div>
			<div>
			   <div class="grid_16_top_4 icol1">  
					<h3 class="h3_action_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/">Action Spiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(385); ?>
					</div><!-- /post -->
			  </div>
			  <div class="grid_16_top_4 icol2">  
			        <h3 class="h3_maedchen_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/">Mädchen Spiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(410); ?>
					</div><!-- /post -->			  
			  </div>
			  <div class="grid_16_top_4 icol3">  
			        <h3 class="h3_jump_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/">Abenteuer Spiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(422); ?>
				  </div><!-- /post -->
			  </div>						
            </div>
			<div style="clear:both;height:1px;"></div>
			<div>
			   <div class="grid_16_top_4 icol1">  
			        <h3 class="h3_rennspiele_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/">Rennspiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(430); ?>
					</div><!-- /post -->
			  </div>
			  <div class="grid_16_top_4 icol2">  
			        <h3 class="h3_sport_index"><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/">Sport Spiele</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(431); ?>
					</div><!-- /post -->			  
			  </div>
			  <div class="grid_16_top_4 icol3">  
			        <h3><a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/">Weitere Spiele kostenlos spielen</a></h3>
					<div class="postcate"> 
						<?php echo getPostByCategoryHome(261); ?>
				  </div><!-- /post -->
			  </div>						
            </div>
			<div style="clear:both;height:1px;"></div>			
			<div style="padding-bottom:250px;"></div>
		</div>
	</div><!-- /leftcontent --> 
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.pageAjax').click(function(){
			var message = $(this).attr("name");
			var word=message.split("-");
			var cateid=word[0];
			var id=word[1];
			$.ajax({
				type: 'POST',
				url: 'wp-admin/admin-ajax.php',
				data: {"action": "showAjaxAction", "page":id, "cateid":cateid},
				beforeSend: function() {$("#loading"+cateid).fadeIn('fast');},
				success: function(data){
					$("#loading"+cateid).fadeOut('slow');
					$("#ajaxData"+cateid).html(data);
				}
			});
			return false;
		});
	});
	</script>
</div><!--/box-->
<?php get_footer(); ?>