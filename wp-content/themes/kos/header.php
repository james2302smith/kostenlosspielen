<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kos
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="layout-header clearfix">
				<div class="fixed-column site-branding">
					<?php
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
					<?php else : ?>
						<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>"></a></div>
					<?php
					endif;

					?>
				</div><!-- .site-branding -->
				<div class="fluid-column">
					<div class="inner">
						<div class="row">
							<div class="col-xs-6">
								<?php
									$description = get_bloginfo( 'description', 'display' );
										if ( $description || is_customize_preview() ) : ?>
											<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
										<?php
									endif;
								?>
							</div>
							<div class="col-xs-6">
								<div class="header-right">
									<div class="acc-column">
										<div class="pull-right recommend-box">
							                <?php
							                $isLoggedIn = is_user_logged_in();
							                ?>
							                <div class="dropdown pull-right common-background recommend <?php echo ($isLoggedIn ? 'favorite-game' : 'favorite-game-disabled') ?>">
							                    <?php 
							                    if(class_exists('KosFavorites')) {
							                        $kosFavorites = KosFavorites::getInstance();
							                        $kosFavorites->init(1, 5);
							                    }
							                    ?>
							                    <?php if($isLoggedIn): ?>
							                    <button class="btn btn-primary favorite-game-link" data-toggle="dropdown" href="javascript:void(0)" title="Favorite game <?php if(!$isLoggedIn) echo '- please login to use this function' ?>">
							                        <?php if($kosFavorites && count($kosFavorites->getGames()) > 0): ?>
							                        	<span class="fa fa-heart"></span>
							                            <span class="circle-number"><?php echo $kosFavorites->getTotal() ?><span>
							                        <?php endif ?>
							                    </button>
							                    <?php endif; ?>
							                    <div class="dropdown-box recommend-list">
							                        <h3 class="dropdown-title">Lieblingsspiel
														<?php if(($kosFavorites && count($kosFavorites->getGames()) > 0)):?>
							                                <a class="pull-right" href="<?php echo SITE_ROOT_URL ?>/favoriten-spiele">Alle Lieblingsspiel</a>
							                            <?php endif; ?>
							                        </h3>
							                        <div class="body">
							                            <ul class="list-game-favorite">
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
							                                        <li class="game-item">
							                                            <a href="<?php echo SITE_ROOT_URL.'/'.$game->post_name ?>.html">
							                                                <div class="game-img">
							                                                    <img class="img-responsive" src="<?php echo $game->game_image ?>" />
							                                                </div>
							                                                <div class="game-info">
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
							                </div>
							            </div>
										<div class="pull-right user-spaces">
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
							                    <div class="dropdown">
							                        <button class="btn btn-primary display-name" data-toggle="dropdown" >
								                    	<?php echo get_avatar(get_current_user_id(),18);?>
							                            <?php echo $userDisplayName ?>
							                        </button>
								                    <ul class="dropdown-menu pull-right user-actions">
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
								                            <a href="<?php echo SITE_ROOT_URL ?>/benachrichtigungen"><i class="fa fa-bell fa-fw"></i> Benachrichtigungen <?php echo $noUnread ? '('.$noUnread.')' : '' ?></a>
								                        </li>
								                        <li>
								                            <a href="javascript:void(0)"><i class="fa fa-cog fa-fw"></i> Einstellungen</a>
								                        </li>
								                        <li>
								                            <a href="<?php echo SITE_ROOT_URL ?>/hilfe"><i class="fa fa-question-circle fa-fw"></i> Hilfe/FAQs</a>
								                        </li>
								                        <li>
								                            <a href="<?php echo wp_logout_url(get_permalink()) ?>"><i class="fa fa-sign-out fa-fw"></i> Abmelden</a>
								                        </li>
								                    </ul>
							                    </div>
							                <?php else :?>
							                    <div class="guest-space">
							                        <div class="signin">
							                            <a id="social_connect_register_link" class="btn btn-primary btn-xs register" rel="modal:open" href="#authentication_modal_form_register" >Kostenlos registrieren <i class="fa fa-user-plus"></i></a><br><a id="social_connect_login_link" class="btn btn-primary btn-xs margin-top-5 login" rel="modal:open" href="#authentication_modal_form_login">Einloggen <i class="fa fa-sign-in"></i></a>
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
									</div>
									<?php get_search_form(); ?>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="site-main-menu clearfix">
			<div class="container">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'kos' ); ?></button>
					<div class="nav-menu-top clearfix">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'clearfix' ) ); ?>
						<?php //wp_nav_menu( array( 'theme_location' => 'full', 'menu_id' => 'full-menu', 'menu_class' => 'clearfix' ) ); ?>
					</div>
				</nav><!-- #site-navigation -->
			</div>
		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="container">
