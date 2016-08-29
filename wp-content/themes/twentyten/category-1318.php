<?php get_header(); ?>
<?php
global $wp_query, $wp;
global $CATEGORY_ORDER_PARAMS_INVERSE;

$category = Category::getInstance();
$perpage = $category->getItemPerPage();
$orderType = $category->getOrderType();
$catId = $category->getId();

$categoryPath = $wp->query_vars['category_name'];
$baseCategoryURL = SITE_ROOT_URL.'/'.$categoryPath.'/';
?>

    <div class="col1">
    <div class="box">
    <div id="leftcontent" class="grid_12">
    <div style="position:relative;">
    <div
        style="width:100%;height:250px;border-bottom:1px solid #99D6FF;overflow-y:auto;overflow-x:hidden;position:absolute;bottom:0;left:0;">
        <?php dynamic_sidebar('first-footer-widget-area'); ?></div>
    <div>
    <div class="ads_top">
        <div class="float-left box-at-right box-with-border category-ads-box">
            <h4 class="title">WERBUNG</h4>
            <div class="body">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
    <div id="categoryArrangeID-<?php echo $catId; ?>">
        <?php
        $totalPosts = $category->getTotal();
        $pageposts = $category->getItems();
        $noPages = ceil($totalPosts / $perpage);
        $currentPage = $category->getCurrentPage();
        $maxPage = 6;
        $minPage = 1;
        if($noPages <= 6) {
            $minPage = 1;
            $maxPage = $noPages;
        } else {
            $minPage = $currentPage - 2;
            $maxPage = $currentPage + 3;
            if($minPage < 1) {
                $maxPage -= $minPage -1;
                $minPage = 1;
            }
            if($maxPage > $noPages) {
                $minPage -= ($maxPage - $noPages);
                $maxPage = $noPages;
            }
        }
        $prevLink = $baseCategoryURL;
        if(isset($CATEGORY_ORDER_PARAMS_INVERSE[$orderType])) {
            $prevLink .= $CATEGORY_ORDER_PARAMS_INVERSE[$orderType].'/';
        }
        if($currentPage == 1) {
            $prevLink = "javascript:void(0);";
        } elseif($currentPage > 2) {
            $prevLink.=PAGE.'/'.($currentPage - 1).'/';
        }

        $nextLink = $baseCategoryURL;
        if(isset($CATEGORY_ORDER_PARAMS_INVERSE[$orderType])) {
            $nextLink .= $CATEGORY_ORDER_PARAMS_INVERSE[$orderType].'/';
        }
        if($currentPage == $noPages) {
            $nextLink = 'javascript:void(0);';
        } else {
            $nextLink .= PAGE.'/'.($currentPage+1).'/';
        }

        $currentPageURL = '';
        ?>
        <div class="category_top">
            <div class="order left">
                Sortieren nach:
                <a rel="nofollow" href="<?php echo $baseCategoryURL.$currentPageURL ?>" name="<?php echo $catId; ?>-view" class="categoryArrange1 <?php if($orderType == 'view') echo 'order-current' ?>">Meist gespielte</a>
                | <a rel="nofollow" href="<?php echo $baseCategoryURL.$CATEGORY_ORDER_PARAMS_INVERSE['new'].'/'.$currentPageURL ?>" name="<?php echo $catId; ?>-new" class="categoryArrange1 <?php if($orderType == 'new') echo 'order-current' ?>">Am neuesten</a>
                | <a rel="nofollow" href="<?php echo $baseCategoryURL.$CATEGORY_ORDER_PARAMS_INVERSE['best'].'/'.$currentPageURL ?>" name="<?php echo $catId; ?>-best" class="categoryArrange1 <?php if($orderType == 'best') echo 'order-current' ?>">Best bewertete</a>
                | <a rel="nofollow" href="<?php echo $baseCategoryURL.$CATEGORY_ORDER_PARAMS_INVERSE['vote'].'/'.$currentPageURL ?>" name="<?php echo $catId; ?>-vote" class="categoryArrange1 <?php if($orderType == 'vote') echo 'order-current' ?>">Meist bewertete</a>
            </div>
            <div class="paging right">
                <a href="<?php echo $prevLink ?>" class="prev-page <?php if($currentPage == 1) echo 'disable'?>">&lt;</a>
                <?php for($i = $minPage; $i <= $maxPage; $i++):?>
                    <?php
                    $pageLink = $baseCategoryURL;
                    if(isset($CATEGORY_ORDER_PARAMS_INVERSE[$orderType])) {
                        $pageLink .= $CATEGORY_ORDER_PARAMS_INVERSE[$orderType].'/';
                    }
                    if($i == $currentPage) {
                        $pageLink = 'javascript:void(0);';
                    } elseif($i > 1) {
                        $pageLink .= PAGE.'/'.$i.'/';
                    }
                    ?>
                    <a href="<?php echo $pageLink ?>" name="387-1" class="<?php if($i == $currentPage) echo 'active' ?>"><?php echo $i ?></a>
                <?php endfor;?>
                <a href="<?php echo $nextLink ?>" class="next-page <?php if($currentPage == $noPages) echo 'disable'?>">&gt;</a>
            </div>
        </div>
        <div class="ArrangeID_waiting_category"></div>
        <div class="category_list">
            <?php
            $total_score = 0;
            $total_users = 0;
            $counter = 0;
            if ($pageposts):
                foreach ($pageposts as $post):
                    $post_rating_users = get_post_meta($post['ID'], 'ratings_users', true);
                    $post_rating_score = get_post_meta($post['ID'], 'ratings_score', true);
                    $total_users = $total_users + intval($post_rating_users);
                    $total_score = $total_score + intval($post_rating_score);?>
                    <div class="category2_game_item">
                        <a title="<?php echo $post['post_title']; ?>"
                           href="<?php echo SITE_ROOT_URL.'/'.$post['post_name']; ?>.html"><img
                                style="border:1px solid #E9E3E3;"
                                src="<?php echo $post['game_image']; ?>" width="120" height="90"
                                title="<?php echo $post['game_intro']; ?>"
                                alt="<?php echo $post['post_title']; ?>"/></a>

                        <div class="category2_game_item_text">
                            <center><a title="<?php echo $post['post_title']; ?>"
                                       href="<?php echo SITE_ROOT_URL.'/'.$post['post_name']; ?>.html">
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
                            class="category2_game_item_info">
                            <?php if($category->getOrderType() == 'new'){ ?>
                                Online seit: <?php echo date('d.m.Y', strtotime($post['post_date'])) ?>
                            <?php } elseif($category->getOrderType() == 'best'){?>
                                Bewertete: <?php echo rtrim(rtrim(number_format($post['ratings_average'], 1, ',', '.'), '0'), ',') ?>/10
                            <?php }else if($category->getOrderType() == 'vote'){?>
                                <?php echo number_format($post['ratings_users'], 0, ',', '.') ?> Bewertete
                            <?php }else {?>
                                <?php echo number_format($post['game_views'], 0, ',', '.'); ?>
                                x gespielt
                            <?php } ?>
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
            <div class="category_top">
                <div class="paging right">
                    <a href="<?php echo $prevLink ?>" class="prev-page <?php if($currentPage == 1) echo 'disable'?>">&lt;</a>
                    <?php for($i = $minPage; $i <= $maxPage; $i++):?>
                        <?php
                        $pageLink = $baseCategoryURL;
                        if(isset($CATEGORY_ORDER_PARAMS_INVERSE[$orderType])) {
                            $pageLink .= $CATEGORY_ORDER_PARAMS_INVERSE[$orderType].'/';
                        }
                        if($i == $currentPage) {
                            $pageLink = 'javascript:void(0);';
                        } elseif($i > 1) {
                            $pageLink .= PAGE.'/'.$i.'/';
                        }
                        ?>
                        <a href="<?php echo $pageLink ?>" name="387-1" class="<?php if($i == $currentPage) echo 'active' ?>"><?php echo $i ?></a>
                    <?php endfor;?>
                    <a href="<?php echo $nextLink ?>" class="next-page <?php if($currentPage == $noPages) echo 'disable'?>">&gt;</a>
                </div>
            </div>
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
    </div>
    <div style="clear:both;height:5px;"></div>
    </div>
    <div style="padding-bottom:250px;"></div>
    </div>
    </div>
    <!-- /leftcontent -->
    </div>
    <!--/box-->
    </div><!--/col1-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>