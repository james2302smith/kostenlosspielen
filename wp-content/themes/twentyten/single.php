<?php
//TODO: mark feed is read
if($_REQUEST['notice-cmt']) {
    $commentId = intval($_REQUEST['notice-cmt']);
    if($commentId > 0) {
        $commentFeed = new CommentFeed();
        $commentFeed->markFeedIsRead(get_current_user_id(), $commentId);
    }
}
?>
<?php get_header(); ?>
<?php
global $wpdb;
while (have_posts()) : the_post(); ?>
    <?php
    global $post;
    $image=$post->game_image;
    $author=$post->game_author;
    $email=$post->game_email;
    $flash=$post->game_flash;
    $flash_width=$post->game_width;
    $flash_height=$post->game_height;
    $iframe=$post->game_iframe;

    //Add to recent games
    $kosRecent = KosRecents::getInstance();
    $kosRecent->addToRecent();
?>
<div id="content" class="fullspan">


<!--top ads tren cung -->
    <div style="width:100%;margin-bottom:10px;">
        <div class="google_ads_728" style="text-align:center;padding-top:10px;padding-bottom:25px;height:80px;">
            <div style="float:left;width: 728px;margin-left:120px;border:1px solid #CDEAFF;">
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
            <div class="ads_text_ngang">Werbung</div>
        </div>
    </div>
<!--ket thuc top ads-->
<!--chia 1 hoac 2 cot theo kich thuoc game -->

    <div id="leftcontent" class="grid_12_single">
    <!-- phan tieu de va game control-->
    <div class="postsingle postheader" style="text-align:center;">
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/scripts/single.js"></script>
        <div class="box float-left">
            <h2 class="text-left title game-title"><?php echo $post->post_title; ?> spielen</h2>
            <div class="text-left body gameview"><?php echo number_format($post->game_views, 0, ',', '.'); ?> x gespielt</div>
        </div>
        <div class="float-right">
            <div class="actions">
                <ul>
                    <?php
                    $isLoggedIn = is_user_logged_in();
                    $isFavorited = false;
                    if($isLoggedIn && class_exists('KosFavorites')) {
                        $kosFavorites = KosFavorites::getInstance();
                        $isFavorited = $kosFavorites->isFavoritedGame();
                    }
                    ?>
                    <li class="inline-block action <?php echo ($isLoggedIn ? 'favorite-action '.($isFavorited ? 'favorite-action-unfavorite' : '') : 'favorite-action-disabled') ?>">
                        <a class="favorite-ajax-action"  data-action="<?php echo ($isFavorited ? 'unfavorite' : 'favorite') ?>" data-url="<?php echo KOS_FAVORITES_AJAX_URL ?>" data-game="<?php echo $post->ID ?>" href="javascript:void(0)"><?php echo ($isFavorited ? 'Dein Favorit' : 'Zu Favoriten') ?></a>
                    </li>
                    <li class="inline-block action share-action">
                        <a href="javascript:void(0)"
                           name="<?php echo $post->post_title ?>"
                           link="<?php echo SITE_ROOT_URL.'/'.$post->post_name?>"
                           picture="<?php echo $image ?>"
                           description="<?php echo $post->game_intro_home ?>"
                            >Spiel teilen</a>
                    </li>
                    <li class="inline-block action reload-action">
                        <a href="javascript:window.location.reload()">Neu laden</a>
                    </li>                    
                </ul>
            </div>
 
        </div>
        <div class="clear"></div>
    </div><!-- /post -->
   <!-- ket thu tieu de va game control-->
     <div class="large-screenshot" style="margin-top:10px;">

        <div class="large-screenimg">
            <?php

            if(strlen($flash)>0) {
                if($flash_width>0){
                    $width=$flash_width;
                }else{
                    $width= 650;
                }
                if($flash_height>0){
                    $height=$flash_height;
                }else{
                    $height=500;
                }
            }
            ?>
            <div id="divGamePad" style="width: 100%; height: 100%;text-align:left; position: relative; padding-left:30px;padding-top:10px;">
                

                <?php
                if(strlen($flash)>0){
                    ?>
                    
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="movie_name" align="middle">
                        <param name="wmode" value="transparent" />
                        <param name="movie" value="<?php echo $flash; ?>"/>
                        <!--[if !IE]>-->
                        <object type="application/x-shockwave-flash" data="<?php echo $flash; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                            <param name="wmode" value="transparent" />
                            <param name="movie" value="<?php echo $flash; ?>"/>
                            <!--<![endif]-->
                            <a href="http://www.adobe.com/go/getflash">
                                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/>
                            </a>
                            <div>
                                <h2><?php echo $post->post_title; ?></h2>
                            </div>

                            <!--[if !IE]>-->
                        </object>
                        <!--<![endif]-->
                    </object>
                <?php   }else{          ?>

                    <iframe frameborder="0" scrolling="no" width="710" height="530" src="<?php echo $iframe; ?>"></iframe>
                <?php };?>
            </div>
        </div><!-- /screenimg -->

    </div><!-- /screenshot-->
    
    <div class="box social vote-and-share-box standard-margin">
        <div class="float-left">
            <div class="float-left title">Wie gefällt Dir das Spiel</div>
            <div class="float-right body">
                <?php if(function_exists('the_ratings')) {
                    the_ratings(
                        'div', 0, true,
                        array(
                            'postratings_template_vote' => '<div class="inline-block images-vote">%RATINGS_IMAGES_VOTE%</div> <div class="inline-block rated-value"><div class="inline-block rated-average">%RATINGS_AVERAGE%</div><div class="inline-block rated-users"><strong>%RATINGS_USERS%</strong>mal bewertet</div></div>%RATINGS_TEXT%',
                            'postratings_template_text' => '<div class="inline-block images-vote">%RATINGS_IMAGES_VOTE%</div> <div class="inline-block rated-value"><div class="inline-block rated-average">%RATINGS_AVERAGE%</div><div class="inline-block rated-users"><strong>%RATINGS_USERS%</strong>mal bewertet</div></div>%RATINGS_TEXT%'
                        ));
                } ?>
            </div>
        </div>
        <div class="float-right social-share">
            <!--<h3 class="title">&nbsp;</h3>-->
            <div class="inline-block facebook-like">
                <div class="fb-like" data-href="<?php echo SITE_ROOT_URL.'/'.$post->post_name ?>.html" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
            </div>
            <!--<div class="inline-block twitter-button">
                <a href="https://twitter.com/share" class="twitter-share-button" data-lang="de" data-count="vertical">Twittern</a>
            </div>-->
            <div class="inline-block google-plus">
                <div class="g-plusone" data-size="medium"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    </div><!-- /leftcontent -->
 


    <!-- phan danh cho quang cao ben phai-->

    <div style='float:left; margin-left:10px; padding:1px; border:1px solid #CDEAFF; width:190px; height:100%;margin-bottom:5px;'>
        <div class='widget-title' style="text-align:center;">Werbung</div>
        <div style='padding-left:28px;padding-top:5px;'>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ads_160x600 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:160px;height:600px"
     data-ad-client="ca-pub-2394577543361208"
     data-ad-slot="2997782572"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        </div>
    </div>
<?php
    
endwhile; ?>
    <div style="clear:both;margin-top:5px;"></div>
<!--bat dau hien thi cac game tuong tu-->
    <div class="box box-with-border game-recommended-box">
        <h4 class="title">Spieler, die <strong><?php echo $post->post_title; ?></strong> gespielt haben, spielten auch:</h4>
        <div class="body">
<!--bat dau suggest Google -->
        
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- match_kostenlosspielen -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-2394577543361208"
             data-ad-slot="6479946171"
             data-ad-format="autorelaxed"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
 <!--ket thuc suggest Google -->
          
        </div>
    </div>
<!--top ads tren cung -->
    <div style="width:100%;margin-bottom:10px;">
        <div class="google_ads_728" style="text-align:center;padding-top:10px;padding-bottom:25px;height:80px;">
            <div style="float:left;width: 728px;margin-left:120px;border:1px solid #CDEAFF;">
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
            <div class="ads_text_ngang">Werbung</div>
        </div>
    </div>
<!--ket thuc top ads-->	
<!--Ket thuc hien thi cac game tuong tu-->
     <div class="box standard-margin-left comment-and-ads comment-box">
		<div class="game-comments">
                <div class="comment list">
                    <?php kos_comments($post->post_title); ?>
                </div>
        </div>
  
        <div class="clear"></div>
    </div>
<!--Ket thuc Comment, How-to -->
<!--Content tren cung -->
        <div class="box-with-border game-description-box" style="margin-top:10px;">
			<center><h2 class="title"><?php echo $post->post_title; ?>: Spielbeschreibung & Steuerung</h2></center>
            <div class="body" style="clear:both;">
                <div class="game-content standard-margin text-justify">                        
					<img style="float:left;padding: 5px 15px 10px 5px;" title="<?php echo $post->post_title; ?>" alt="<?php echo $post->post_title; ?>"  src="<?php echo $image; ?>" width="200" height="150" />
					<?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<!--Ket thuc Content tren cung -->
 </div><!-- /content -->


<?php get_footer(); ?>