<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
            <div class="panel panel-default game-play-box">
                <div class="panel-heading entry-header">
                    <?php the_title( '<h2 class="panel-title entry-title">', '</h2>' ); ?>
                </div>
                <div class="panel-body">
        			<?php
        			while ( have_posts() ) : the_post();

        				get_template_part( 'template-parts/content', 'page' );

        				// If comments are open or we have at least one comment, load up the comment template.
        				if ( comments_open() || get_comments_number() ) :
        					comments_template();
        				endif;

        			endwhile; // End of the loop.
        			?>
                </div>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php
//get_sidebar();
get_footer();
