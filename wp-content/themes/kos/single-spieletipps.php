<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
<div class="container padding-top-0">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content-spieletipps-single', get_post_format() );

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php
//get_sidebar();
get_footer();