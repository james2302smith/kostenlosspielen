<?php get_header(); ?>
<?php
global $wp_query;
$cat_ID = get_query_var('cat');
?>

    <div class="col1">
        <div class="box">
            <div id="leftcontent" class="grid_12">
                <div style="position:relative;">
                    <div
                        style="width:100%;height:250px;border-bottom:1px solid #99D6FF;overflow-y:auto;overflow-x:hidden;position:absolute;bottom:0;left:0;">
                        <?php dynamic_sidebar('first-footer-widget-area'); ?>
                    </div>
                    <div>
                        <div class="ads_top">
                            <div class="float-left box-at-right box-with-border category-ads-box">
                                <h4 class="title">WERBUNG</h4>

                                <div class="body">
                                    <script async
                                            src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <!-- ads-336x280 -->
                                    <ins class="adsbygoogle"
                                         style="display:inline-block;width:336px;height:280px"
                                         data-ad-client="ca-pub-2394577543361208"
                                         data-ad-slot="5079646976"></ins>
                                    <script>
                                        (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>
                                </div>
                            </div>
                            <div class="float-right box-at-right box-with-border category-ads-box">
                                <h4 class="title">WERBUNG</h4>

                                <div class="body">
                                    <script async
                                            src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <!-- ads-336x280 -->
                                    <ins class="adsbygoogle"
                                         style="display:inline-block;width:336px;height:280px"
                                         data-ad-client="ca-pub-2394577543361208"
                                         data-ad-slot="5079646976"></ins>
                                    <script>
                                        (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="categoryArrangeID-<?php echo $cat_ID; ?>">
                        <div class="category_top">Sortieren nach:
                            <a rel="nofollow" href="javascript:void(0);" name="<?php echo $cat_ID; ?>-view"
                               class="categoryArrange" style="text-decoration:none;"><strong>Meist gespielte
                                    Spiele</strong></a>
                            | <a rel="nofollow" href="javascript:void(0);" name="<?php echo $cat_ID; ?>-new"
                                 class="categoryArrange">Am neuesten Spiele</a>
                            | <a rel="nofollow" href="javascript:void(0);" name="<?php echo $cat_ID; ?>-best"
                                 class="categoryArrange">Best bewertete Spiele</a>
                            | <a rel="nofollow" href="javascript:void(0);" name="<?php echo $cat_ID; ?>-vote"
                                 class="categoryArrange">Meist bewertete Spiele</a>
                        </div>
                        <div class="ArrangeID_waiting_category"></div>
                        <div class="category_list">
                            <?php
                            $query = "SELECT * FROM kostenlosspielen_posts wposts	WHERE post_status = 'publish' AND post_type='post' AND wposts.category2=" . $cat_ID . "
			ORDER BY game_views DESC";
                            $pageposts = $wpdb->get_results($query, ARRAY_A);
                            $total_score = 0;
                            $total_users = 0;
                            $counter = 0;
                            ?>
                            <?php if ($pageposts):
                                foreach ($pageposts as $post):
                                    $post_rating_users = get_post_meta($post['ID'], 'ratings_users', true);
                                    $post_rating_score = get_post_meta($post['ID'], 'ratings_score', true);
                                    $total_users = $total_users + intval($post_rating_users);
                                    $total_score = $total_score + intval($post_rating_score);
                                    ?>


                                    <div class="category2_game_item">

                                        <a title="<?php echo $post['post_title']; ?>"
                                           href="<?php echo SITE_ROOT_URL . '/' . $post['post_name']; ?>.html"><img
                                                style="border:1px solid #E9E3E3;"
                                                src="<?php echo $post['game_image']; ?>" width="120" height="90"
                                                title="<?php echo $post['game_intro']; ?>"
                                                alt="<?php echo $post['post_title']; ?>"/></a>

                                        <div class="category2_game_item_text">
                                            <center><a title="<?php echo $post['post_title']; ?>"
                                                       href="<?php echo SITE_ROOT_URL . '/' . $post['post_name']; ?>.html">
                                                    <?php
                                                    if (strlen($post['post_title']) < 22) {
                                                        echo $post['post_title'];
                                                    } else {
                                                        echo substr($post['post_title'], 0, 20) . '..';
                                                    }
                                                    ?>
                                                </a></center>
                                        </div>
                                        <div
                                            class="category2_game_item_info"><?php echo number_format($post['game_views'], 0, ',', '.'); ?>
                                            x gespielt
                                        </div>
                                    </div>
                                    <?php
                                    $counter++;
                                    if ($counter == 15) {
                                        ?>
                                        <div style="clear:both;height:5px;"></div>
                                        <div class="ads_text">Werbung</div>
                                        <div style="margin-left:6px;padding-top:7px;">
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
                                        <div style="clear:both;height:10px;"></div>

                                    <?php
                                    }
                                endforeach;

                            endif; ?>
                            <?php
                            if ($counter < 15) {
                                ?>
                                <div style="clear:both;height:5px;"></div>
                                <div class="ads_text">Werbung</div>
                                <div style="margin-left:6px;">
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
                                <div style="clear:both;height:5px;"></div>

                            <?php
                            }?>

                            <div>

                                <div style="clear:both;"></div>

                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <!-- /end of category_list -->

                    <div style="clear:both;height:5px;"></div>
                </div>
                <div style="padding-bottom:250px;"></div>
            </div>
        </div>
        <!-- /leftcontent -->
    </div><!--/box-->
    </div><!--/col1-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>