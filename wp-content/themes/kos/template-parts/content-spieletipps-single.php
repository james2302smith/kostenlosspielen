<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kos
 */

?>
<div class="panel panel-default game-play-box">
	<div class="panel-heading entry-header">
		<?php the_title( '<h1 class="panel-title entry-title">', '</h1>' ); ?>
	</div>
	<div class="panel-body">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<div class="banner-ads-in-single">
					<img src="<?php echo get_template_directory_uri(); ?>/images/sample-banner-ads-2.png" alt="Sample">
				</div>
				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'kos' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kos' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php kos_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</article><!-- #post-## -->
	</div>
</div>
