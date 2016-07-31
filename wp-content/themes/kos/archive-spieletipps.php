<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kos
 */

get_header(); ?>

<div class="breadcrumbs-box clearfix">
	<div class="container">
		<div class="breadcrumbs">
			<?php if ( function_exists('yoast_breadcrumb') ) {
				$breadcrumbs = yoast_breadcrumb('<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">','</span>',false);
				echo $breadcrumbs;
			} ?>
		</div>
		<div class="pull-right">
			<div id="plusone-div" class="plusone"></div>
			<script type="text/javascript">
				gapi.plusone.render('plusone-div',{"size": "medium", "count": "true"});
			</script>
		</div>
	</div>
</div>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) : ?>
			<div class="panel panel-default panel-bordered">
				<!-- <div class="panel-heading caret-down">
					<?php
						the_archive_title( '<h4 class="panel-title">', '</h4>' );
					?>
				</div> -->
				<div class="panel-body">
					<div class="page-header">
						<?php the_archive_title( '<h1 class="page-title">', '</h1>' );?>
					</div>
					<div class="list-post clearfix">
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
								get_template_part( 'template-parts/content-spieletipps', get_post_format() );

						endwhile;


						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>
					</div>
					<?php numeric_posts_nav(); ?>
			</div>
		</div>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->
<?php
//get_sidebar();
get_footer();
