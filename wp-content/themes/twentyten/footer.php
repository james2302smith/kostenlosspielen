
		<div class="fix"></div>
		
	</div><!--/columns -->

        <!-- GOOGLE Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-18181946-13', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>		
        <!-- GOOGLE PLUS -->
        <script type="text/javascript">gapi.plusone.go();</script>
        <!--TWITTER -->
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

				<script type="text/javascript">
                    jQuery(document).ready(function($) {
                        $('.pageAjax').click(function(){
                            var message = $(this).attr("name");
                            var word=message.split("-");
                            var cateid=word[0];
                            var id=word[1];

                            $.ajax({
                                type: "POST",
                                url: "wp-admin/admin-ajax.php",
                                data: {"action": "showAjaxAction", "page":id, "cateid":cateid},
                                beforeSend: function() {jQuery("#loading"+cateid).fadeIn("fast");},
                                success: function(data){
                                    $("#loading"+cateid).fadeOut("slow");
                                    $("#ajaxData"+cateid).html(data);
                                }
                            });
                            return false;
                        });
                        $('.singleCateAjax4').click(function(){
                            var message = $(this).attr("name");
                            var word=message.split("-");
                            var cateid=word[0];
                            var id=word[1];
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_ROOT_URL ?>/wp-admin/admin-ajax.php',
                                data: {"action": "showAjaxCategory4", "page":id, "cateid":cateid},
                                beforeSend: function() {$("#cateSingleCSS"+cateid).fadeIn('fast');},
                                success: function(data){
                                    $("#cateSingleCSS"+cateid).fadeOut('slow');
                                    $("#category"+cateid).html(data);
                                }
                            });
                            return false;
                        });

                        $('.singleCateAjax').click(function(){
                            var message = $(this).attr("name");
                            var word=message.split("-");
                            var cateid=word[0];
                            var id=word[1];
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_ROOT_URL ?>/wp-admin/admin-ajax.php',
                                data: {"action": "showAjaxCategory", "page":id, "cateid":cateid},
                                beforeSend: function() {$("#cateSingleCSS"+cateid).fadeIn('fast');},
                                success: function(data){
                                    $("#cateSingleCSS"+cateid).fadeOut('slow');
                                    $("#category"+cateid).html(data);
                                }
                            });
                            return false;
                        });

                        $('.top-popular-post-page').click(function(){
                            var pageid = $(this).attr("name");
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_ROOT_URL ?>/wp-admin/admin-ajax.php',
                                data: {"action": "showTopPopularGames", "pageid":pageid},
                                beforeSend: function() {$(".ArrangeID_waiting").fadeIn('fast');},
                                success: function(data){
                                    $(".ArrangeID_waiting").fadeOut('slow');
                                    $("#top-popular-post").html(data);
                                }
                            });
                            return false;
                        });

                        $('.similar-games').click(function(){
                            var message = $(this).attr("name");
                            var word=message.split("-");
                            var instruction=word[0];
                            var categoryid=word[1];
                            var num=word[2];
                            //alert(message);
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_ROOT_URL ?>/wp-admin/admin-ajax.php',
                                data: {"action": "showSimilarGames", "instruction":instruction, "categoryid":categoryid,"num":num},
                                beforeSend: function() {$(".ArrangeID_waiting").fadeIn('fast');},
                                success: function(data){
                                    $(".ArrangeID_waiting").fadeOut('slow');
                                    $("#similar-gamesid").html(data);
                                },error: function(errorThrown){
                                    alert(errorThrown);
                                }
                            });
                            return false;
                        });
                        $('.categoryArrange').click(function(){
                            var message = $(this).attr("name");
                            var word=message.split("-");
                            var cateid=word[0];
                            var type=word[1];
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_ROOT_URL ?>/wp-admin/admin-ajax.php',
                                data: {"action": "showCategoryArrange", "cateid":cateid, "type":type},
                                beforeSend: function() {$(".ArrangeID_waiting_category").fadeIn('fast');},
                                success: function(data){
                                    $(".ArrangeID_waiting_category").fadeOut('slow');
                                    $("#categoryArrangeID-"+cateid).html(data);
                                }
                            });
                            return false;
                        });

                        $('.topView').click(function(){
                            var message = $(this).attr("name");
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_ROOT_URL ?>/wp-admin/admin-ajax.php',
                                data: {"action": "topViewGames", "message":message},
                                beforeSend: function() {$(".topView_waiting").fadeIn('fast');},
                                success: function(data){
                                    $(".topView_waiting").fadeOut('slow');
                                    $("#topViewGames").html(data);
                                }
                            });
                            return false;
                        });

                        $('.lineCate').click(function(){
                            var message = $(this).attr("name");
                            var word=message.split("-");
                            var cateid=word[0];
                            var page=word[1];

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_ROOT_URL ?>/wp-admin/admin-ajax.php',
                                data: {"action": "lineCateAjax", "cateid":cateid, "page":page},
                                beforeSend: function() {$("#categoryLine"+cateid).fadeIn('fast');},
                                success: function(data){
                                    $("#categoryLine"+cateid).fadeOut('slow');
                                    $("#categoryHTML"+cateid).html(data);
                                }
                            });
                            return false;
                        });
                    });
				</script>
				<style type='text/css'>
					#cateSingleCSS387, #cateSingleCSS388, #cateSingleCSS389,#cateSingleCSS390, #cateSingleCSS391, #cateSingleCSS392,
					#cateSingleCSS169, #cateSingleCSS395, #cateSingleCSS397,#cateSingleCSS271, #cateSingleCSS399, #cateSingleCSS400,#cateSingleCSS398,#cateSingleCSS401,#cateSingleCSS402,
					#cateSingleCSS406, #cateSingleCSS407, #cateSingleCSS408,#cateSingleCSS425, #cateSingleCSS427, #cateSingleCSS426,
					#cateSingleCSS447, #cateSingleCSS411, #cateSingleCSS413,#cateSingleCSS250, #cateSingleCSS412, #cateSingleCSS414,#cateSingleCSS1949, #cateSingleCSS1742, #cateSingleCSS2796,
					#cateSingleCSS104, #cateSingleCSS419, #cateSingleCSS418,#cateSingleCSS420, #cateSingleCSS1840, #cateSingleCSS1935,
					#cateSingleCSS432, #cateSingleCSS433, #cateSingleCSS342,#cateSingleCSS435, #cateSingleCSS436, #cateSingleCSS437,#cateSingleCSS434, #cateSingleCSS438, #cateSingleCSS439,
					#cateSingleCSS417, #cateSingleCSS3568, #cateSingleCSS421, #cateSingleCSS3237, .ArrangeID_waiting, .ArrangeID_waiting_category, #cateSingleCSS428, #cateSingleCSS429, #cateSingleCSS405, 
					#cateSingleCSS409, #cateSingleCSS2394, #cateSingleCSS3818, #cateSingleCSS3894, #cateSingleCSS2263, .topView_waiting,
					#cateSingleCSS75, #cateSingleCSS3924,#cateSingleCSS3923, #cateSingleCSS3925, #cateSingleCSS3926, #cateSingleCSS3927, 
					#cateSingleCSS1318,#cateSingleCSS4034,#cateSingleCSS1567, #cateSingleCSS4037,#cateSingleCSS4035,#cateSingleCSS4039,#cateSingleCSS1587,
					#cateSingleCSS4036,#cateSingleCSS4038,#cateSingleCSS4050,#cateSingleCSS3090,#cateSingleCSS4045,#cateSingleCSS4049, #categoryLine261,#categoryLine403,#categoryLine439,
					#cateSingleCSS4325,#cateSingleCSS4388,#cateSingleCSS4155, #cateSingleCSS4156,#cateSingleCSS4391,#cateSingleCSS4370,#cateSingleCSS4389,
					#cateSingleCSS4390,#cateSingleCSS415,#cateSingleCSS1264,#cateSingleCSS569,#cateSingleCSS4172,#cateSingleCSS1664,#cateSingleCSS4269,
					#cateSingleCSS1310,#cateSingleCSS4154,#cateSingleCSS4326,#cateSingleCSS4327,#cateSingleCSS4329,#cateSingleCSS403,#cateSingleCSS4328,
					#cateSingleCSS4153,#cateSingleCSS4147,#cateSingleCSS4144,#cateSingleCSS4209,#cateSingleCSS4192,#cateSingleCSS4208,#cateSingleCSS3067,
					#cateSingleCSS4240,#cateSingleCSS4187,#cateSingleCSS2534,#cateSingleCSS4191,#cateSingleCSS4239,#cateSingleCSS393,#cateSingleCSS4301,#cateSingleCSS4800,
					#cateSingleCSS4543,#cateSingleCSS2352,#cateSingleCSS4149,#cateSingleCSS4150,#cateSingleCSS3415,#cateSingleCSS4148,#cateSingleCSS423,
					#loading385, #loading394, #loading404, #loading410, #loading417, #loading422, #loading430, #loading431, #loading261, #loading4033,
					#cateSingleCSS4581, #cateSingleCSS4580, #cateSingleCSS4582, #cateSingleCSS2114, #cateSingleCSS4649,#cateSingleCSS4650,#cateSingleCSS4651,
					#cateSingleCSS3898,#cateSingleCSS5078, #cateSingleCSS4044, #cateSingleCSS4048, #cateSingleCSS4047,
					#cateSingleCSS1006, #cateSingleCSS4046, #cateSingleCSS5438,#cateSingleCSS4241,#cateSingleCSS4329,#cateSingleCSS4005
					
					{ clear:both; background:url(/wp-includes/js/tinymce/themes/advanced/skins/default/img/progress.gif) center top no-repeat; text-align:center;padding:40px 0px 0px 0px; font-size:12px;display:none; font-family:Verdana, Arial, Helvetica, sans-serif; }
				</style>

	<div id="footer">
		<span class="fl">Copyright &copy;&nbsp; <a href="<?php echo SITE_ROOT_URL ?>/">Kostenlos Spielen</a></span>
			<span class="fr">
			      <a rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/impressum/">Impressum</a> | <a href="<?php echo SITE_ROOT_URL ?>/sitemap.xml">Sitemap</a>
			</span>
	</div><!--/footer -->

	</div><!--/page -->
<?php wp_footer(); ?>
<!--<?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds-->
<!--<?php print_r($wpdb->queries); ?>-->
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 980935582;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/980935582/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</body>
</html>