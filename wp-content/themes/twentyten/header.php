<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo SITE_ROOT_URL ?>/feed/" />
    <link rel="pingback" href="<?php echo SITE_ROOT_URL ?>/xmlrpc.php" />
    <link href="https://plus.google.com/110415531968788281581" rel="publisher" />

    <?php wp_head(); ?>

    <title><?php kos_title(); ?></title>
    <?php kos_meta(); ?>

    <!-- css -->
    <!-- WP-Minify CSS -->
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/jquery-plugins/jquery-modal/jquery.modal.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/style.css" media="screen" />

    <!-- Javascript -->
    <!--[if IE]>
    <script defer type="text/javascript" src="<?php echo SITE_CURRENT_THEME_URL?>/images/pngfix.js"></script>
    <![endif]-->

    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/jquery-plugins/jquery-modal/jquery.modal.js"></script>
    <script type="text/javascript" src="<?php echo SITE_CURRENT_THEME_URL?>/includes/js/main.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/scripts/common.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/scripts/tab_widgets.js"></script>	    
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script type="text/javascript" src="<?php echo SITE_CURRENT_THEME_URL?>/includes/js/index.js"></script>

    <!-- WP-Minify JS -->

    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
          {lang:'de', parsetags:'explicit'}
    </script>
	<!-- Start Visual Website Optimizer Asynchronous Code -->
<script type='text/javascript'>
var _vwo_code=(function(){
var account_id=106866,
settings_tolerance=2000,
library_tolerance=2500,
use_existing_jquery=false,
// DO NOT EDIT BELOW THIS LINE
f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById('_vis_opt_path_hides');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement('script');b.src=a;b.type='text/javascript';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName('head')[0].appendChild(b);},init:function(){settings_timer=setTimeout('_vwo_code.finish()',settings_tolerance);this.load('//dev.visualwebsiteoptimizer.com/j.php?a='+account_id+'&u='+encodeURIComponent(d.URL)+'&r='+Math.random());var a=d.createElement('style'),b='body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}',h=d.getElementsByTagName('head')[0];a.setAttribute('id','_vis_opt_path_hides');a.setAttribute('type','text/css');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();
</script>
<!-- End Visual Website Optimizer Asynchronous Code -->
<!-- Facebook Conversion Code for ks -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6020316462170', {'value':'0.00','currency':'EUR'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6020316462170&amp;cd[value]=0.00&amp;cd[currency]=EUR&amp;noscript=1" /></noscript>

<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '1569078870037148']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1569078870037148&amp;ev=PixelInitialized" /></noscript>

<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<script type="text/javascript">
    window.cookieconsent_options = {"message":"Cookies erleichtern die Bereitstellung unserer Dienste. Mit der Nutzung unserer Dienste erklärst Du dich damit einverstanden, dass wir Cookies verwenden","dismiss":"Verstanden","learnMore":"Mehr erfahren","link":"http://www.kostenlosspielen.biz/datenschutzregelung/","theme":"light-bottom"};
</script>

<script type="text/javascript" src="//s3.amazonaws.com/cc.silktide.com/cookieconsent.latest.min.js"></script>
<!-- End Cookie Consent plugin -->

<!-- MUST INCLUDE THIS LINE TO DESTROY PRELOADER-->
    <script type="text/javascript">
        function removeAdSwf() {
            document.getElementById("preloader").style.visibility = "hidden";
        }
        function noAdsReturned() {
            document.getElementById("preloader").style.visibility = "hidden";
        }
    </script>

</head>

<body <?php body_class(); ?>>
    <!-- Facebook config -->
    <div id="fb-root"></div>
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({
                appId: '<?php echo KOS_FACEBOOK_CLIENT_API ?>',
                cookie: true,
                xfbml: true,
                oauth: true
            });
        };
    </script>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/de_DE/all.js#xfbml=1&appId=624253760968467";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- TOP FIXED BAR -->

    <div class="fixed-top-bar">
        <div class="logo">
            <a href="<?php echo SITE_ROOT_URL.(is_user_logged_in() ? '/?ref=logo' : '') ?>" title="Kostenlos Spielen"><img src="<?php echo SITE_ROOT_URL?>/wp-content/themes/twentyten/image/logo.png" alt="Kostenlos spielen" title="Kostenlos Spielen" /></a>
        </div>
        
			<?php $h1= kos_h1();
			if (strlen($h1)>23) { ?>
				<div class="fixed-top-navigation" style="margin-top:-20px !important;">
					<h1><?php echo $h1; ?></h1>				        
				</div>
			
			<?php
			}else{ ?>
				<div class="fixed-top-navigation">
					<h1><?php echo $h1; ?></h1>				        
				</div>
			<?php } ?>
        <div class="float-right fixed-top-right">
            <!-- Search FORM -->
            <div class="float-left searchform">
                <form method="GET" action="<?php echo SITE_ROOT_URL ?>">
                    <div class="input">
                        <input type="text" name="s" value="<?php echo $_REQUEST['s'] ?>" autocomplete="off" placeholder="Suche nach Spiele…"/>
                        <input type="submit" value="s"/>
                        <ul class="search-suggestion">
                            <li>Search 1</li>
                            <li>Search 2</li>
                            <li>Search 3</li>
                        </ul>
                    </div>
                </form>
            </div>
            <!-- END Search FORM -->

            <!-- RECOMMEND -->
            <div class="float-left recommend-box">
                <?php
                $isLoggedIn = is_user_logged_in();
                ?>
                <ul>
                    <li class = "inline-block common-background recommend <?php echo ('recent-game') ?>">
                        <?php
                        $kosRecent = KosRecents::getInstance();
                        $recentGames = $kosRecent->getRecentGames();
                        ?>
                        <a class="recent-game-link" href="javascript:void(0)" title="Recent game">
                            <?php if(count($recentGames) > 0): ?>
                                <span><?php echo count($recentGames) ?></span>
                            <?php endif ?>
                        </a>
                        <div class="recommend-list">
                            <h3>Kürzlich gespielt</h3>
                            <div class="body">
                                <ul>
                                    <?php if(!$isLoggedIn && false): ?>
                                        <div class="disabled-description">
                                            This function is availble when you logged in!
                                            <br/>
                                            Porttitor urna, lacus risus, sed tortor aliquam cras ultrices, cras porta dolor, et, facilisis facilisis nunc porttitor platea
                                        </div>
                                    <?php elseif(empty($recentGames)) :?>
                                        <li>
                                            <div class="standard-margin disabled-description">
                                                Finde schnell, was du kürzlich gespielt hast: Diese Liste zeigt die letzten 5 Spiele, die du gespielt hast.
                                            </div>
                                        </li>
                                    <?php else: ?>
                                        <?php foreach($recentGames as $game): ?>
                                            <li>
                                                <a href="<?php echo SITE_ROOT_URL.'/'.$game->post_name ?>.html">
                                                    <div class="float-left game-img">
                                                        <img src="<?php echo $game->game_image ?>" />
                                                    </div>
                                                    <div class="float-left game">
                                                        <h4 class="title"><?php echo $game->post_title ?></h4>
                                                        <div class="description">
                                                            <?php echo $game->game_intro_home ?>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </a>
                                            </li>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="footer">
                                <?php if($isLoggedIn && false): ?>
                                    <a href="#">Show all</a>
                                <?php endif;?>
                            </div>
                        </div>
                    </li>
                    <li class="inline-block common-background recommend <?php echo ($isLoggedIn ? 'favorite-game' : 'favorite-game-disabled') ?>">
                        <?php 
                        if(class_exists('KosFavorites')) {
                            $kosFavorites = KosFavorites::getInstance();
                            $kosFavorites->init(1, 5);
                        }
                        ?>
                        <a class="favorite-game-link" href="javascript:void(0)" title="Favorite game <?php if(!$isLoggedIn) echo '- please login to use this function' ?>">
                            <?php if($kosFavorites && count($kosFavorites->getGames()) > 0): ?>
                                <span><?php echo $kosFavorites->getTotal() ?><span>
                            <?php endif ?>
                        </a>
                        <div class="recommend-list">
                            <h3>Lieblingsspiel</h3>
                            <div class="footer text-right">
                                <?php if(($kosFavorites && count($kosFavorites->getGames()) > 0)):?>
                                    <a href="<?php echo SITE_ROOT_URL ?>/favoriten-spiele">Alle Lieblingsspiel</a>
                                <?php endif; ?>
                            </div>
                            <div class="body">
                                <ul>
                                    <?php if(!$isLoggedIn): ?>
                                        <li>
                                            <ul>
                                                <li class="description">Melde dich bitte an, um diese Funktion zu nutzen.</li>
                                                <li class="description">Um deine Lieblingsspiele aus www.kostenlosspielen.biz schneller zu finden, kannst du sie abspeichern.</li>
                                                <li class="description">Wenn dir ein Spiel gefällt, kannst du es zu deiner Favoriten hinzufügen. Dieses Spiel wird dann unter Lieblingsspiele gespeichert.</li>
                                            </ul>
                                        </li>
                                    <?php else :?>
                                        <?php
                                        if($kosFavorites && count($kosFavorites->getGames()) > 0):?>
                                            <?php foreach($kosFavorites->getGames() as $game): ?>
                                            <li>
                                                <a href="<?php echo SITE_ROOT_URL.'/'.$game->post_name ?>.html">
                                                    <div class="float-left game-img">
                                                        <img src="<?php echo $game->game_image ?>" />
                                                    </div>
                                                    <div class="float-left game">
                                                        <h4 class="title"><?php echo $game->post_title ?></h4>
                                                        <div class="description">
                                                            <?php echo $game->game_intro_home ?>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </a>
                                            </li>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <li>
                                                <ul>
                                                    <li class="description">Um deine Lieblingsspiele aus www.kostenlosspielen.biz schneller zu finden, kannst du sie abspeichern.</li>
                                                    <li class="description">Wähle "Zu Favoriten" und du wirst beim nächsten Einloggen das gespeicherte Spiel unter Lieblingsspiele in der Navigationsleiste wiederfinden.</li>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- END RECOMMENDED -->
            <!-- CURRENT USER -->
            <div class="float-left userspaces">
                <?php if(is_user_logged_in()): ?>
                    <?php
                        global $current_user;
                        get_currentuserinfo();
                        $userDisplayName = trim($current_user->first_name.' '.$current_user->last_name);
                        if(!$userDisplayName) {
                            $userDisplayName = $current_user->display_name;
                            if(!$userDisplayName) {
                                $userDisplayName = $current_user->user_login;
                            }
                        }
                    ?>
                    <div class="float-left user-avatar">
                        <!--<img class="avatar" src="<?php /*echo SITE_ROOT_URL*/?>/wp-content/themes/twentyten/image/default_avatar.gif" />-->
                        <?php echo get_avatar(get_current_user_id(),28);?>
                    </div>
                    <div class="float-left user-actions">
                        <a class="display-name" href="javascript:void(0);">
                            <?php echo $userDisplayName ?>
                        </a>
                        <ul>
                            <li>
                                <?php
                                $userId = get_current_user_id();
                                $commentFeed = CommentFeedModel::getInstance($userId);
                                $noUnread = $commentFeed->getNoUnreadFeed();
                                if($noUnread == 0) {
                                    $noUnread = false;
                                } else if($noUnread > 99) {
                                    $noUnread = '99+';
                                }

                                ?>
                                <a href="<?php echo SITE_ROOT_URL ?>/benachrichtigungen">Benachrichtigungen <?php echo $noUnread ? '('.$noUnread.')' : '' ?></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">Einstellungen</a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_ROOT_URL ?>/hilfe">Hilfe/FAQs</a>
                            </li>
                            <li>
                                <a href="<?php echo wp_logout_url(get_permalink()) ?>">Abmelden</a>
                            </li>
                        </ul>
                    </div>
                <?php else :?>
                    <div class="standard-margin-right guestspace">
                        <div class="float-left signin">
                            <a id="social_connect_register_link" class="register" rel="modal:open" href="#authentication_modal_form_register" >
                                Kostenlos registrieren
                            </a>
                            <span>oder</span>
                            <a id="social_connect_login_link" class="login" rel="modal:open" href="#authentication_modal_form_login">
                                Einloggen
                            </a>
                        </div>
                    </div>
                    <div style="width: 0px; height: 0px">
                        <!-- LOGIN FORM -->
                        <?php //echo authentication_modal_form('login') ?>
                        <div id="authentication_modal_form_login" class="authentication-modal-form login-form" style="display: none">
                            <div class="box-with-border form box-form form-login">
                                <h4 class="title standard-margin-bottom">EINLOGGEN</h4>
                                <a class="close-modal common-background" rel="modal:close"></a>
                                <div class="body">
                                    <div class="input-form standard-margin">
                                        <?php echo KosUIHelper::modal_login_form() ?>
                                    </div>
                                    <div class="social standard-margin">
                                        <?php echo KosUIHelper::social_login_buttons()?>
                                    </div>
                                </div>
                                <div class="footer">
                                    Du hast noch kein Konto? <a rel="modal:open" href="#authentication_modal_form_register">Registrieren und zwar KOSTENLOS!</a>
                                </div>
                            </div>
                        </div>

                        <!-- REGISTER FORM -->
                        <?php //echo authentication_modal_form('register') ?>
                        <div id="authentication_modal_form_register" class="authentication-modal-form register-form" style="display: none">
                            <div class="float-left box authentication-intro">
                                <div class="logo text-center">
                                    <img src="http://demo.kostenlosspielen.biz/wp-content/themes/twentyten/image/logo1.png" alt="Kostenlos spielen" title="Kostenlos Spielen">
                                </div>
                                <div class="standard-margin">
                                    <ul>
                                        <li class="standard-margin-top standard-margin-bottom">In 15 Sekunden kostenlos registrieren</li>
                                        <li class="standard-margin-top standard-margin-bottom">Mehr als 15.000 kostenlose Spiele spielen</li>
                                        <li class="standard-margin-top standard-margin-bottom">Viele gute Spiele von uns empfohlen</li>
                                        <li class="standard-margin-top standard-margin-bottom">Lieblingsspiele speichern</li>
                                        <li class="standard-margin-top standard-margin-bottom">Highscore Spiele spielen und speichern</li>
                                        <li class="standard-margin-top standard-margin-bottom">An monatlichen Wettbewerben teilnehmen</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="float-left box box-with-border form box-form form-register">
                                <h4 class="title">Registrieren</h4>
                                <a class="close-modal common-background" rel="modal:close"></a>
                                <div class="body">
                                    <div class="input-form standard-margin">
                                        <?php echo KosUIHelper::modal_register_form() ?>
                                    </div>
                                    <div class="social standard-margin">
                                        <?php echo KosUIHelper::social_login_buttons() ?>
                                    </div>
                                </div>
                                <div class="footer">
                                    Hast du schon ein Konto? <a rel="modal:open" href="#authentication_modal_form_login">Logge dich hier ein</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <!-- END CURRENT USER -->

            <div class="float-left fixed-top-userspace">
                <ul>
                    <?php //social_connect_login_header(); ?>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div><!--/header -->

<div id="wrapper" class="hfeed">
    <?php /*
	<div id="slogan">
	<?php
	if(is_front_page()){
		?>
	<h1><strong><a href="<?php echo SITE_ROOT_URL ?>">Kostenlos Spielen</a></strong></h1>, ohne Gebühren und mit den besten Spielen. Wer mag das nicht? Jung oder alt, groß oder klein, spielen tut jeder gern.
	<?php	}
	if(is_single()){?>
			<h1><?php echo $post->post_title ;?> kostenlos spielen auf <a href="<?php echo SITE_ROOT_URL ?>"><?php echo SITE_ROOT_URL ?></a></h1>
	<?php	}
	if(is_category()){
	$thisCat = get_category(get_query_var('cat'),false);
	$category_title=$thisCat->name;
	{ ?>
		<h1><strong><?php echo $category_title ;?></strong></h1>: Nicht nur junge Leute, sondern auch alte Leute spielen heute noch gern. Unsere <?php echo $category_title ;?> auf <a href="<?php echo SITE_ROOT_URL ?>/"><?php echo KOS_DOMAIN ?></a> sorgen für viel Spaß, aber auch für viel Entspannung.
	<?php }
	}	?>
	</div>
    */ ?>

						

	<div id="header">
		<div id="masthead">
			<div id="access">
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header -->

	<?php
	//build the sub-menu in category level 1
   	  	$thisCat = get_category(get_query_var('cat'),false);
		$cat_ID = $thisCat->term_id;
	if($cat_ID>0){
	$categories=  get_categories('parent='.$cat_ID); 
	$sub_menu='';
		if(sizeof($categories)>0) { 
			$sub_menu=$sub_menu.'<div class="sub-menu-navigation">';
			foreach ($categories as $category) {
				$sub_menu=$sub_menu.'<div class="sub-navigation"><a href="' . get_category_link( $category->term_id ) . '" title="' . $category->name . '" ' . '>' . $category->name.'</a></div>';
			}
			$sub_menu=$sub_menu.'</div>';
			echo $sub_menu; 
		} 
	}
	
   if(is_home()||is_front_page()){?>
   <div class="top-content">
		<div class="top-content-center" id="top-popular-post">
			<div>
				<h2 style="float:left;width: 200px;">Populäre Spiele</h2>
				<div class="top-popular-num-general">
				<?php 
				for($i=1;$i<6;$i++){
					if($i==1){
						echo '<a rel="nofollow" href="javascript:void(0);" name="'.$i.'" class="top-popular-post-page"><strong>'.$i.'</strong></a>&nbsp;';
					}else{
						echo '<a rel="nofollow" href="javascript:void(0);" name="'.$i.'" class="top-popular-post-page">'.$i.'</a>&nbsp;';
					}
				}
				?>			
				</div>
			
				<div class="top-content-games" style="clear:both;">
					<?php 
						$query='SELECT * FROM kostenlosspielen_posts
								WHERE kostenlosspielen_posts.post_status =  \'publish\'
								AND kostenlosspielen_posts.post_type =  \'post\'
								ORDER BY game_views DESC
								LIMIT 0,10'; 
						$pageposts = $wpdb->get_results($query, ARRAY_A);
						foreach ($pageposts as $post){
						$post_image=$post['game_image'];
						?>
						<div class="top-popular-item">
						<div class="ArrangeID_waiting"></div>
						<a title="<?php echo $post['post_title']; ?>" href="<?php echo SITE_ROOT_URL.'/'.$post['post_name']; ?>.html"><img src="<?php echo $post_image; ?>" width="134" height="100" alt="kostenlos spielen <?php echo $post['post_title']; ?>" title="<?php echo $post['game_intro']; ?>" />
						<p><?php echo $post['post_title']; ?></p>
						</a>
						</div>
					   <?php } ?>
				</div>
			</div>
		</div>
		<div class="top-content-right">
			<p style="color:#fff;padding-bottom:5px;margin-left:10px;"><b>Populäre Unterkategorie</b></p>
							<div class="box sidebar">
							<ul class="sidebar-group-list">
								<li><a href="<?php echo SITE_ROOT_URL ?>/brettspiele/solitaer-spiele/" title="Solitär Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/solitaer-spiele.png');"></span>Solitär Spiele</a></li>
								<li class="alt"><a href="<?php echo SITE_ROOT_URL ?>/denkspiele/mahjong-spiele/" title="Mahjong Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/mahjong-spiele.png');"></span>Mahjong Spiele</a></li>
								<li><a href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/bubbles-spiele/" title="Bubbles Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/bubbles-spiele.png');"></span>Bubbles Spiele</a></li>
								<li class="alt"><a href="<?php echo SITE_ROOT_URL ?>/denkspiele/3-gewinnt-spiele/" title="3 Gewinnt Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/3-gewinnt-spiele.png');"></span>3 Gewinnt Spiele</a></li>
								<li><a href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/puzzle-spiele/" title="Puzzle Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/puzzle-spiele.png');"></span>Puzzle-Spiele</a></li>								
								<li class="alt"><a href="<?php echo SITE_ROOT_URL ?>/abenteuer-spiele/mario-spiele/" title="Mario Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/mario-spiele.png');"></span>Mario Spiele</a></li>
								<li><a href="<?php echo SITE_ROOT_URL ?>/sport-spiele/fussball-spiele/" title="Fußball Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/fussball-spiele.png');"></span>Fußball-Spiele</a></li>
								<li class="alt"><a href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/tetris-spiele/" title="Tetris Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/tetris-spiele.png');"></span>Tetris Spiele</a></li>
								<li><a href="<?php echo SITE_ROOT_URL ?>/geschicklichkeitsspiele/pacman-spiele/" title="Pacman Spiele"><span class="thumb br3" style="background-image: url('<?php echo SITE_ROOT_URL ?>/wp-content/themes/twentyten/images/category2/30x30/pacman-spiele.png');"></span>Pacman Spiele</a></li>

							</ul>
							</div>
		</div>
   </div>
   
   <?php }  ?>
   <div style="clear:both;"></div>
   <div class="breadcrumbs">
      
      <?php if ( function_exists('yoast_breadcrumb') ) {
  $breadcrumbs = yoast_breadcrumb('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">','</span>',false);
  echo $breadcrumbs;
	} ?>      
      <div style="float:right;padding-top:0px;">
      	<div id="plusone-div" class="plusone"></div>
		<script type="text/javascript">
		      gapi.plusone.render('plusone-div',{"size": "medium", "count": "true"});
		</script>
      </div>
    </div>
	

	<div id="columns"><!-- START MAIN CONTENT COLUMNS -->

