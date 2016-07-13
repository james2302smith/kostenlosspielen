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

<div class="signin-register-box">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div class="register-hint">
					<h4>GET AN ACCOUNT AND</h4>
					<ul>
						<li>Save your favorite games</li>
						<li>Interact with other games</li>
						<li>Play Massive Multiplayer Online Games!  </li>
						<li>Play Massive Multiplayer Online Games!  </li>
						<li>Complete and win awards</li>
						<li>Create your own profile picture</li>
					</ul>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-box login-form">
					<h3 class="form-title">Login</h3>
					<hr>
					<div class="body">
						<div class="input-form standard-margin">
							<?php echo KosUIHelper::modal_login_form() ?>
						</div>
						<div class="social standard-margin">
							<?php echo KosUIHelper::social_login_buttons()?>
						</div>
					</div>
				</div>
				<div class="form-box register-form">
					<h3 class="form-title">Resgister</h3>
					<hr>
					<div class="input-form standard-margin">
						<?php echo KosUIHelper::modal_register_form() ?>
					</div>
					<div class="social standard-margin">
						<?php echo KosUIHelper::social_login_buttons() ?>
					</div>
				</div>
			</div>
			<div class="col-sm-3 hidden-xs hidden-sm">
				<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/fig-signin-register.png" alt="">
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>
