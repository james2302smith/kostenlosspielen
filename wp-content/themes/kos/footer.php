<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kos
 */

?>
		</div><!-- /.container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info">
				<?php
					   /**
						* Displays a navigation menu
						* @param array $args Arguments
						*/
						$args = array(
							'theme_location' => 'footer-primary',
							'menu' => 'Footer Primary',
							'container' => 'div',
							'container_class' => 'menu-footer-primary-container',
							'container_id' => 'footer-primary',
							'menu_class' => 'menu clearfix',
							'menu_id' => '',
							'echo' => true,
							'fallback_cb' => 'wp_page_menu',
							'before' => '',
							'after' => '',
							'link_before' => '',
							'link_after' => '',
							'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
							'depth' => 0,
							'walker' => ''
						);
						wp_nav_menu( $args );
				?>
				<div class="row footer-middle">
					<div class="col-xs-9 col-lg-10">
						<?php if ( is_active_sidebar( 'footer-tab-content' ) ) : ?>
							<div id="footer-widget">
								<?php dynamic_sidebar( 'footer-tab-content' ); ?>
							</div>
						<?php endif; ?>
						<?php
						   /**
							* Displays a navigation menu
							* @param array $args Arguments
							*/
							$args = array(
								'theme_location' => 'footer-seconds',
								'menu' => 'Footer Seconds',
								'container' => 'div',
								'container_class' => 'menu-footer-seconds-container',
								'container_id' => 'footer-seconds',
								'menu_class' => 'menu clearfix',
								'menu_id' => '',
								'echo' => true,
								'fallback_cb' => 'wp_page_menu',
								'before' => '',
								'after' => '',
								'link_before' => '',
								'link_after' => '',
								'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
								'depth' => 0,
								'walker' => ''
							);
							wp_nav_menu( $args );
						?>
					</div>
				</div><!-- .row -->
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<div id="signinRegisterBox" class="signin-register-box">
	<div class="inner">
		<button onclick="closeLogin(this)" id="closeLoginBox" class="btn btn-default btn-close btn-bordered">Schließen</button>
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<div class="register-hint">
						<h4>Account anmelden und</h4>
						<ul>
							<li><i class="icon-cir icon-cir-green-download"></i>speichere deine Lieblingsspiele.</li>
							<li><i class="icon-cir icon-cir-green-play-multi"></i>interagiere mit anderen Spielern.</li>
							<li><i class="icon-cir icon-cir-green-game-pad"></i>spiele tausende Online Spiele.</li>
							<li><i class="icon-cir icon-cir-green-cup"></i>spiele und gewinne einen Preis.</li>
							<li><i class="icon-cir icon-cir-green-edit"></i>erstelle dein eigenes Profilbild.</li>
						</ul>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-box login-form">
						<h3 class="form-title">Einloggen</h3>
						<div class="social standard-margin">
							<?php echo KosUIHelper::social_login_buttons()?>
						</div>
						<hr>
						<p class="form-desc">Lieber per Email anmelden?</p>
						<div class="body">
							<div class="input-form standard-margin">
								<?php echo KosUIHelper::modal_login_form() ?>
							</div>
						</div>
					</div>
					<div class="form-box register-form">
						<h3 class="form-title">Registrieren</h3>
						<div class="social standard-margin">
							<?php echo KosUIHelper::social_login_buttons()?>
						</div>
						<hr>
						<div class="form-desc">Lieber per Email anmelden?</div>
						<div class="input-form standard-margin">
							<?php echo KosUIHelper::modal_register_form() ?>
						</div>
					</div>
				</div>
				<div class="col-sm-4 hidden-xs hidden-sm">
					<img class="img-responsive squirrel-img pull-right" src="<?php echo get_template_directory_uri(); ?>/images/fig-signin-register.png" alt="">
				</div>
			</div>
		</div>
	</div>
</div>
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

<?php wp_footer(); ?>
</div>
</body>
</html>
