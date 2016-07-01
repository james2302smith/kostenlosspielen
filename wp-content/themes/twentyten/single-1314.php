<?php get_header(); ?>
<div id="content" class="fullspan">
 <div class="ads_text">Werbung</div>
    <div class="google_ads_728" style="border: 1px dotted rgb(89, 158, 223);text-align:center;padding-top:10px;padding-bottom:15px;">
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
<div id="leftcontent" class="grid_12_single">
<?php
global $wpdb;
while (have_posts()) : the_post(); ?>
    <?php
    global $post;
    $image=replaceImages($post->game_image,'100');
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
    <div class="postsingle postheader" style="text-align:center;">
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/scripts/single.js"></script>
        <div class="box float-left">
            <h3 class="text-left title game-title"><?php echo $post->post_title; ?></h3>
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
                    <li class="inline-block action report-action">
                        <a href="javascript:void(0)">Melden</a>
                    </li>
                     <li class="inline-block action reload-action">
                        <a href="javascript:window.location.reload()">Neu laden</a>
                    </li>
                </ul>
            </div>

        </div>
        <div class="clear"></div>

    </div><!-- /post -->
  
    <div class="large-screenshot">

        <div class="large-screenimg">
            <?php
            $width= 710;
            $height=530;
            if(strlen($flash)>0) {
                if($flash_width>0){
                    $width=$flash_width;
                }else{
                    $width= 675;
                }
                if($flash_height>0){
                    $height=$flash_height;
                }else{
                    $height=500;
                }
            }
            ?>
            <div id="divGamePad" style="width: 100%; height: 100%;text-align:center; position: relative; width: 735px; height: <?php echo $height ?>px">
                <?php
                if(strlen($flash)>0){
                    ?>
                    <object style="position: absolute; top: 0px; left: 4%;" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="movie_name" align="middle">
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
                <?php   }else{    		?>

                    <iframe frameborder="0" scrolling="no" width="710" height="530" src="<?php echo $iframe; ?>"></iframe>
                <?php };?>
            </div>
        </div><!-- /screenimg -->

    </div><!-- /screenshot-->
    <h3 style="font-size:normal;font-style:italic;float:right;margin-right:40px;clear:both;"><?php echo $post->post_title; ?> Spiel</h3>

    <!-- place for Google Rich Snippet-->
    <?php
    $total_ratings = $wpdb->get_var("SELECT COUNT(rating_id) FROM $wpdb->ratings WHERE 1=1 $postratings_where");
    $total_users = $wpdb->get_var("SELECT SUM(meta_value) FROM $wpdb->postmeta WHERE meta_key = 'ratings_users' AND post_id='".$post->ID."'");
    $total_score = $wpdb->get_var("SELECT SUM((meta_value+0.00)) FROM $wpdb->postmeta WHERE meta_key = 'ratings_score' AND post_id='".$post->ID."'");
    if($total_users == 0) {
        $total_average = 0;
    } else {
        $total_average = $total_score/$total_users;
    }
    ?>
    <div itemscope itemtype="http://data-vocabulary.org/Review-aggregate" class="standard-margin" style="font-style: italic;">
        <img itemprop="photo" src="<?php echo $image; ?>" width="20" height="15" title="<?php echo $post->post_title; ?>" alt="<?php echo $post->post_title; ?>" />
        <span itemprop="itemreviewed"><?php echo $post->post_title; ?></span>
	    	<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
	      	Durchschnitt: <span itemprop="average"><?php echo $total_average; ?></span> von <span itemprop="best">10</span>,
	      	</span>
        <span itemprop="count"><?php echo $total_users; ?></span> Erfahrungsberichte.
    </div>
    <!-- end-->

    <div style="clear:both;height:5px;"></div>


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
    <div class="box box-with-border standard-margin game-recommended-box">
        <h4 class="title">Spieler, die <strong><?php echo $post->post_title; ?></strong> gespielt haben, spielten auch:</h4>
        <div class="body">
            <div class="box float-left box-at-left standard-margin game-recommended">
                <?php
                //TODO: this block code is temporary
                $category2=$post->category2;
                $query='SELECT DISTINCT * FROM kostenlosspielen_posts
                                        WHERE category2 = '.$category2.' AND post_status = \'publish\' AND post_type=\'post\' ORDER BY post_date  DESC LIMIT 0, 4';
                //if(!is_admin()) {     echo $query;    }
                $pageposts = $wpdb->get_results($query, ARRAY_A);
                $counter=0;

                for($i=0;$i<sizeof($pageposts);$i++){
                    $post_image=$pageposts[$i]['game_image'];
                    echo '<div class="meist_game_item">
                                <div class="meist_item_thumbs">
                                    <a target="_blank" title="'.$pageposts[$i]['post_title'].'" href="'.SITE_ROOT_URL.'/'.$pageposts[$i]['post_name'].'.html"><img src="'.$post_image.'" width="120" height="90" alt="'.$pageposts[$i]['post_title'].'" title="'.$pageposts[$i]['game_intro_home'].'" /></a>
                                </div>
                                <div class="meist_item_text">
                                    <div><a title="'.$pageposts[$i]['post_title'].'" href="'.SITE_ROOT_URL.'/'.$pageposts[$i]['post_name'].'.html">'.$pageposts[$i]['post_title'].'</a></div>
                                    <div>'.number_format($pageposts[$i]['game_views'],0,',','.').' x gespielt</div>
                                </div>
                          </div>';

                    //if($i > 0 && $i % 2 == 0) { echo '<div style="clear:both"></div>';}
                }?>
                <div class="clear"></div>
            </div>
            <div class="float-right box-at-right standard-margin-top standard-margin-bottom ads-box">
                <h4 class="title">WERBUNG</h4>
                <div class="">
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
            <div class="clear"></div>
        </div>
    </div>
<div style="padding:10px;">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- m-homepage -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-2394577543361208"
             data-ad-slot="3094330970"
             data-ad-format="autorelaxed"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

    </div>
    <div class="box standard-margin-left comment-and-ads">
        <div class="float-left box-at-left comment-box">
            <div class="game-comments">
                <div class="comment list">
                    <?php kos_comments(); ?>
                </div>
            </div>
        </div>
        <div class="float-right box-at-right box-with-border standard-margin-right game-description-box">
            <h4 class="title">Informationen zum Spiel</h4>
            <div class="body">
                <div class="standard-margin-left game-infomation">
                    <div class="float-left standard-margin-top game-image">
                        <img title="<?php echo $post->post_title; ?>" alt="<?php echo $post->post_title; ?>" src="<?php echo $image; ?>" width="100" height="75"/>
                    </div>
                    <div class="float-left standard-margin-left">
                        <table>
                            <tbody>
                            <tr>
                                <td class="label">
                                    Originalname:
                                </td>
                                <td>
                                    <?php echo $post->post_title ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Online seit:</td>
                                <td>
                                    <?php the_time('d.m.Y') ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Spielaufrufe:</td>
                                <td><?php echo number_format($post->game_views); ?></td>
                            </tr>
                            <tr>
                                <td class="label">Redakteur:</td>
                                <td>
                                    <a rel="nofollow" href="mailto:<?php echo $post->game_email; ?>?subject=Feedback%20zu%20<?php echo $post->post_title; ?>"><?php echo $post->game_author; ?></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Fragen oder Anregungen:</td>
                                <td>
                                    <a rel="nofollow" href="mailto:<?php echo $post->game_email; ?>?subject=Feedback%20zu%20<?php echo $post->post_title; ?>"><?php echo $post->game_email; ?></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Kategorie:</td>
                                <td>
                                    <?php
                                    $category1=$post->category1;
                                    $category2=$post->category2;
                                    $cat=get_category($category1);
                                    ?>
                                    <a href="<?php echo get_category_link($category1)?>"><?php echo $cat->name?></a>,
                                    <?php
                                    $cat=get_category($category2);
                                    ?>
                                    <a href="<?php echo get_category_link($category2)?>"><?php echo $cat->name?></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Stichwörter</td>
                                <td>
                                    <?php
                                    $post_tags = wp_get_post_tags($post->ID);
                                    foreach($post_tags as $post_tag){
                                        ?>
                                        <a href="<?php echo SITE_ROOT_URL ?>/tag/<?php echo $post_tag->slug;?>" rel="nofollow"><u><?php echo $post_tag->name;?></u></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="game-content standard-margin text-justify">
                    <?php the_content() ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <p style="margin-left:10px;font-weight:bold;">Spielkategorie sortiert nach A-Z:</p>
    <div style="clear:both;height:10px;"></div>
    <div class="grid_16_category" style="margin-left:10px;"><p>Spiele sortiert nach A</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/2-spieler/" title="Alle Spiele in 2 Spieler ansehen">2 Spieler</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/3-gewinnt-spiele/" title="Alle Spiele in 3-Gewinnt Spiele ansehen">3-Gewinnt Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/4-gewinnt-spiele/" title="Alle Spiele in 4-Gewinnt Spiele ansehen">4-Gewinnt Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/" title="Alle Spiele in Abenteuer ansehen">Abenteuer</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/" title="Alle Spiele in Action Spiele ansehen">Action Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/anziehspiele/" title="Alle Spiele in Anziehspiele ansehen">Anziehspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/asteroids/" title="Alle Spiele in Asteroids ansehen">Asteroids</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/ausweichen-laufen/" title="Alle Spiele in Ausweichen &amp; Laufen ansehen">Ausweichen &amp; Laufen</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/ausweichspiele/" title="Alle Spiele in Ausweichspiele ansehen">Ausweichspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/autorennen-spiele/" title="Alle Spiele in Autorennen Spiele ansehen">Autorennen Spiele</a></li>
        </ul>
    </div>

    <div class="grid_16_category"><p>Spiele sortiert nach B</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/ballerspiele/" title="Alle Spiele in Ballerspiele ansehen">Ballerspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/barbie-spiele/" title="Alle Spiele in Barbie Spiele ansehen">Barbie Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/baeren-spiele/" title="Alle Spiele in Bären Spiele ansehen">Bären Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/basketball-spiele/" title="Alle Spiele in Basketball Spiele ansehen">Basketball Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/batman-spiele/" title="Alle Spiele in Batman Spiele ansehen">Batman Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/betreuungs-spiele/" title="Alle Spiele in Betreuung ansehen">Betreuungs-Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/biene-spiele/" title="Alle Spiele in Biene Spiele ansehen">Biene Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/billard-spiele/" title="Alle Spiele in Billard Spiele ansehen">Billard Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/blackjack-spiele/" title="Alle Spiele in Blackjack Spiele ansehen">Blackjack Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/blocks-spiele/" title="Alle Spiele in Blocks-Spiele ansehen">Blocks-Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/bomberman-spiele/" title="Alle Spiele in Bomberman Spiele ansehen">Bomberman Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/boot-rennen-spiele/" title="Alle Spiele in Boot Rennen Spiele ansehen">Boot Rennen Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/bowling-spiele/" title="Alle Spiele in Bowling Spiele ansehen">Bowling Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/boxen-spiele/" title="Alle Spiele in Boxen Spiele ansehen">Boxen Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/breakout-spiele/" title="Alle Spiele in Breakout Spiele ansehen">Breakout Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/" title="Alle Spiele in Brettspiele ansehen">Brettspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/bubbles-spiele/" title="Alle Spiele in Bubbles Spiele ansehen">Bubbles Spiele</a></li></ul>
    </div>

    <div
        class="grid_16_category"><p>Spiele sortiert nach C-D-E-F</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/casino-spiele/" title="Alle Spiele in Casino Spiele ansehen">Casino Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/counter-strike/" title="Alle Spiele in Counter Strike ansehen">Counter Strike</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/dekoration-spiele/" title="Alle Spiele in Dekoration Spiele ansehen">Dekoration Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/delfin-spiele/" title="Alle Spiele in Delfin Spiele ansehen">Delfin Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/" title="Alle Spiele in Denkspiele ansehen">Denkspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/distanz-rekord/" title="Alle Spiele in Distanz-Rekord ansehen">Distanz-Rekord</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/donald-duck/" title="Alle Spiele in Donald Duck ansehen">Donald Duck</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/drache-spiele/" title="Alle Spiele in Drache Spiele ansehen">Drache Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/elefanten-spiele/" title="Alle Spiele in Elefanten Spiele ansehen">Elefanten Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/fangspiele/" title="Alle Spiele in Fangspiele ansehen">Fangspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/farm-spiele/" title="Alle Spiele in Farm-Spiele ansehen">Farm-Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/fischspiele/" title="Alle Spiele in Fischspiele ansehen">Fischspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/fliegen-schiessen/" title="Alle Spiele in Fliegen &amp; Schießen ansehen">Fliegen &amp; Schießen</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/fluchtspiele/" title="Alle Spiele in Fluchtspiele ansehen">Fluchtspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/flugzeug-spiele/" title="Alle Spiele in Flugzeug Spiele ansehen">Flugzeug Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/formel-1/" title="Alle Spiele in Formel 1 ansehen">Formel 1</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/friseurspiele/" title="Alle Spiele in Friseurspiele ansehen">Friseurspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/fussball-spiele/" title="Alle Spiele in Fußball Spiele ansehen">Fußball Spiele</a></li>
        </ul></div>
    <div
        class="grid_16_category"><p>Spiele sortiert nach G-H-I-K</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/geister-spiele/" title="Alle Spiele in Geister Spiele ansehen">Geister Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/" title="Alle Spiele in Geschicklichkeitsspiele ansehen">Geschicklichkeitsspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/gold-miner/" title="Alle Spiele in Gold Miner ansehen">Gold Miner</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/golf-spiele/" title="Alle Spiele in Golf Spiele ansehen">Golf Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/haehnchen-spiele/" title="Alle Spiele in Hähnchen Spiele ansehen">Hähnchen Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/hamster-spiele/" title="Alle Spiele in Hamster Spiele ansehen">Hamster Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/hochzeitsspiele/" title="Alle Spiele in Hochzeitsspiele ansehen">Hochzeitsspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/hunde-spiele/" title="Alle Spiele in Hunde Spiele ansehen">Hunde Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/inneneinrichtung/" title="Alle Spiele in Inneneinrichtung ansehen">Inneneinrichtung</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/insekten-spiele/" title="Alle Spiele in Insekten Spiele ansehen">Insekten Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/kampfspiele/" title="Alle Spiele in Kampfspiele ansehen">Kampfspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/kartenspiele/" title="Alle Spiele in Kartenspiele ansehen">Kartenspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/katze-spiele/" title="Alle Spiele in Katze Spiele ansehen">Katze Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/kinderspiele/" title="Alle Spiele in Kinderspiele ansehen">Kinderspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/kochspiele/" title="Alle Spiele in Kochspiele ansehen">Kochspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/konzentrationsspiele/" title="Alle Spiele in Konzentrationsspiele ansehen">Konzentrationsspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/kriegsspiele/" title="Alle Spiele in Kriegsspiele ansehen">Kriegsspiele</a></li>
        </ul></div>
    <div
        style="clear:both;height:15px;"></div><div
        class="grid_16_category" style="margin-left:10px;"><p>Spiele sortiert nach L-M-N</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/lernspiele/" title="Alle Spiele in Lernspiele ansehen">Lernspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/liebe-spiele/" title="Alle Spiele in Liebe Spiele ansehen">Liebe Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/loewen-spiele/" title="Alle Spiele in Löwen Spiele ansehen">Löwen Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/" title="Alle Spiele in Mädchen Spiele ansehen">Mädchen Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/mafia-spiele/" title="Alle Spiele in Mafia Spiele ansehen">Mafia Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/mahjong-spiele/" title="Alle Spiele in Mahjong Spiele ansehen">Mahjong Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/make-up-spiele/" title="Alle Spiele in Make-Up Spiele ansehen">Make-Up Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/malen-spiele/" title="Alle Spiele in Malen Spiele ansehen">Malen Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/mario-spiele/" title="Alle Spiele in Mario Spiele ansehen">Mario Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/memory-spiele/" title="Alle Spiele in Memory Spiele ansehen">Memory Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/mickey-spiele/" title="Alle Spiele in Mickey Spiele ansehen">Mickey Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/minesweeper/" title="Alle Spiele in Minesweeper ansehen">Minesweeper</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/motocross-spiele/" title="Alle Spiele in Motocross Spiele ansehen">Motocross Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/motorrad-spiele/" title="Alle Spiele in Motorrad Spiele ansehen">Motorrad Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/nagelstudio/" title="Alle Spiele in Nagelstudio ansehen">Nagelstudio</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/naruto-spiele/" title="Alle Spiele in Naruto Spiele ansehen">Naruto Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/ninja-spiele/" title="Alle Spiele in Ninja Spiele ansehen">Ninja Spiele</a></li>
        </ul></div>
    <div
        class="grid_16_category"><p>Spiele sortiert nach P-Q-R</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/pacman-spiele/" title="Alle Spiele in Pacman Spiele ansehen">Pacman Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/parkspiele/" title="Alle Spiele in Parkspiele ansehen">Parkspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/penguin-spiele/" title="Alle Spiele in Penguin Spiele ansehen">Penguin Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/pferde-spiele/" title="Alle Spiele in Pferde Spiele ansehen">Pferde Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/pimp-my-ride/" title="Alle Spiele in Pimp My Ride ansehen">Pimp My Ride</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/pinball-spiele/" title="Alle Spiele in Pinball Spiele ansehen">Pinball Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/piraten-spiele/" title="Alle Spiele in Piraten Spiele ansehen">Piraten Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/point-and-click/" title="Alle Spiele in Point and Click ansehen">Point and Click</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/poker-spiele/" title="Alle Spiele in Poker Spiele ansehen">Poker Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/puzzle-spiele/" title="Alle Spiele in Puzzle Spiele ansehen">Puzzle Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/puzzlen-laufen/" title="Alle Spiele in Puzzlen &amp; Laufen ansehen">Puzzlen &amp; Laufen</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/quad-spiele/" title="Alle Spiele in Quad Spiele ansehen">Quad Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/quiz-tests/" title="Alle Spiele in Quiz &amp; Tests ansehen">Quiz &amp; Tests</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/rallye/" title="Alle Spiele in Rallye ansehen">Rallye</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/raetsel-spiele/" title="Alle Spiele in Rätsel Spiele ansehen">Rätsel Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/ratte-spiele/" title="Alle Spiele in Ratte Spiele ansehen">Ratte Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/reaktion-spiele/" title="Alle Spiele in Reaktion Spiele ansehen">Reaktion Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/" title="Alle Spiele in Rennspiele ansehen">Rennspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/ritter/" title="Alle Spiele in Ritter ansehen">Ritter</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/roboter-spiele/" title="Alle Spiele in Roboter-Spiele ansehen">Roboter-Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/rollenspiele/" title="Alle Spiele in Rollenspiele ansehen">Rollenspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/roulette-spiele/" title="Alle Spiele in Roulette Spiele ansehen">Roulette Spiele</a></li>
        </ul></div>

    <div class="grid_16_category"><p>Spiele sortiert nach S-T</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/sammeln-fliegen/" title="Alle Spiele in Sammeln &amp; Fliegen ansehen">Sammeln &amp; Fliegen</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/sammeln-laufen/" title="Alle Spiele in Sammeln &amp; Laufen ansehen">Sammeln &amp; Laufen</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/sammeln-spiele/" title="Alle Spiele in Sammeln Spiele ansehen">Sammeln Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/schach-spiele/" title="Alle Spiele in Schach Spiele ansehen">Schach Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/skate-spiele/" title="Alle Spiele in Skate Spiele ansehen">Skate Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/ski-spiele/" title="Alle Spiele in Ski Spiele ansehen">Ski Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/snake-spiele/" title="Alle Spiele in Snake Spiele ansehen">Snake Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/sniper-spiele/" title="Alle Spiele in Sniper Spiele ansehen">Sniper Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/solitaer-spiele/" title="Alle Spiele in Solitär Spiele ansehen">Solitär Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/sonic/" title="Alle Spiele in Sonic ansehen">Sonic</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/space-invaders-spiele/" title="Alle Spiele in Space invaders ansehen">Space invaders</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/spiderman-spiele/" title="Alle Spiele in Spiderman Spiele ansehen">Spiderman Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/" title="Alle Spiele in Sport Spiele ansehen">Sport Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/springen-schiessen/" title="Alle Spiele in Springen &amp; Schießen ansehen">Springen &amp; Schießen</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/star-spiele/" title="Alle Spiele in Star Spiele ansehen">Star Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/strasse-bauen/" title="Alle Spiele in Straße bauen ansehen">Straße bauen</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/strategie-spiele/" title="Alle Spiele in Strategie Spiele ansehen">Strategie Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/sudoku-spiele/" title="Alle Spiele in Sudoku Spiele ansehen">Sudoku Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/tanks/" title="Alle Spiele in Tanks ansehen">Tanks</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/tennis-spiele/" title="Alle Spiele in Tennis Spiele ansehen">Tennis Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/tetris-spiele/" title="Alle Spiele in Tetris Spiele ansehen">Tetris Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/tic-tac-toe/" title="Alle Spiele in Tic Tac Toe ansehen">Tic Tac Toe</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/tier-spiele/" title="Alle Spiele in Tier Spiele ansehen">Tier Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/" title="Alle Spiele in Tiere &amp; Cartoon ansehen">Tiere &amp; Cartoon</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/tiere-cartoon/tom-jerry/" title="Alle Spiele in Tom &amp; Jerry ansehen">Tom &amp; Jerry</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/turmverteidigung-spiele/" title="Alle Spiele in Turmverteidigung Spiele ansehen">Turmverteidigung Spiele</a></li>
        </ul></div>
    <div class="grid_16_category"><p>Spiele sortiert nach U-Z</p>
        <ul><li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/unblock-me-spiele/" title="Alle Spiele in Unblock me Spiele ansehen">Unblock me Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/verschiedene-denkspiele/" title="Alle Spiele in Verchiedene Denkspiele ansehen">Verchiedene Denkspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/verschiedene-abenteuer-spiele/" title="Alle Spiele in Verschiedene Abenteuerspiele ansehen">Verschiedene Abenteuerspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/verschiedene-actionspiele/" title="Alle Spiele in Verschiedene Actionspiele ansehen">Verschiedene Actionspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/brettspiele/verschiedene-brettspiele/" title="Alle Spiele in Verschiedene Brettspiele ansehen">Verschiedene Brettspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/verschiedene-geschicklichkeitsspiele/" title="Alle Spiele in Verschiedene Geschick ansehen">Verschiedene Geschick</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/maedchen-spiele/verschiedene-maedchen-spiele/" title="Alle Spiele in Verschiedene Mädchenspiele ansehen">Verschiedene Mädchenspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/verschiedene-rennspiele/" title="Alle Spiele in Verschiedene Rennspiele ansehen">Verschiedene Rennspiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/sport-spiele/verschiedene-sport-spiele/" title="Alle Spiele in Verschiedene Sportspiele ansehen">Verschiedene Sportspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/weitere/" title="Alle Spiele in Weitere ansehen">Weitere</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/" title="Alle Spiele in Weitere Spiele ansehen">Weitere Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/wimmelbilder/" title="Alle Spiele in Wimmelbilder ansehen">Wimmelbilder</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/wortspiele/" title="Alle Spiele in Wortspiele ansehen">Wortspiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/weitere-spiele/zeitmanagement-spiele/" title="Alle Spiele in Zeitmanagement Spiele ansehen">Zeitmanagement Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/zielen-schiessen/" title="Alle Spiele in Zielen &amp; Schießen ansehen">Zielen &amp; Schießen</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/action-spiele/zombie-spiele/" title="Alle Spiele in Zombie Spiele ansehen">Zombie Spiele</a></li>
            <li class="white"> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/rennspiele/zug-spiele/" title="Alle Spiele in Zug Spiele ansehen">Zug Spiele</a></li>
            <li> <a target="_blank" rel="nofollow" href="<?php echo SITE_ROOT_URL ?>/denkspiele/zuma/" title="Alle Spiele in Zuma ansehen">Zuma</a></li>
        </ul></div>
    <div style="clear:both;height:15px;"></div>

<?php endwhile; ?>

</div><!-- /leftcontent -->

<?php get_sidebar(); ?>
</div><!-- /content -->
<?php get_footer(); ?>

