<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kos
 */

get_header(); ?>
	<div class="row">
		<div class="col-xs-9 col-lg-10">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
				<div class="popular-games-box">
					<h4 class="board-header"><span class="board"><i class="icon-cm icon-cm-heart-yellow"></i>Populäre Spiele</span></h4>
					<div id="favoriteSlider" class="favorite-slider">
						<?php
							$query='SELECT * FROM kostenlosspielen_posts
									WHERE kostenlosspielen_posts.post_status =  \'publish\'
									AND kostenlosspielen_posts.post_type =  \'post\'
									ORDER BY game_views DESC
									LIMIT 0,32'; 
							$pageposts = $wpdb->get_results($query, ARRAY_A);
							foreach (array_chunk($pageposts, 16) as $row) {
								echo '<div class="row-item">';
								foreach ($row as $post){
								$post_image=$post['game_image'];
								?>
								<div class="top-popular-item">
									<div class="ArrangeID_waiting"></div>
									<a title="<?php echo $post['post_title']; ?>" href="<?php echo SITE_ROOT_URL.'/'.$post['post_name']; ?>.html"><img src="<?php echo $post_image; ?>" width="134" height="100" alt="kostenlos spielen <?php echo $post['post_title']; ?>" title="<?php echo $post['game_intro']; ?>" />
										<span class="title"><?php echo $post['post_title']; ?></span>
									</a>
								</div>
						   <?php
						   		}
						   		echo '</div>';
							}
						   ?>
					</div>
				</div>
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) : ?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>

					<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Panel title</h3>
						</div>
						<div class="panel-body">
							Panel content
						</div>
					</div>
				</main><!-- #main -->
			</div><!-- #primary -->

		</div>
		<div class="col-xs-3 col-lg-2">
			<?php get_sidebar(); ?>
		</div>
	</div>

<?php
get_footer();

