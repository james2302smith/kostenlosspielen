<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package kos
 */

get_header(); ?>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">

				<div class="page-content">
					<div class="panel">
						<div class="panel-body">
							<h1 class="page-title text-center"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'kos' ); ?></h1>
							<br>
							<div class="row">
								<div class="col-xs-6 col-xs-push-3">
									<p class="text-center"><img src="<?php echo get_template_directory_uri(); ?>/images/404.png" alt="404 error"></p>
									<h3 class="text-center"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'kos' ); ?></h3>
									<?php
										get_search_form();
									?>
								</div>
							</div>
							<br>
						</div>
					</div>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
</div>

<?php
get_footer();
