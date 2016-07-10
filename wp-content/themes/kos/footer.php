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

<?php wp_footer(); ?>

</body>
</html>
