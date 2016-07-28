<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'kos' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<div class="panel panel-default">
                <div class="panel-body">
                    <div class="list-game-default clearfix">
                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            if(!is_single( $post )) {
                                get_template_part( 'template-parts/content-common', get_post_format() );
                            }
                            else {
                                get_template_part( 'template-parts/content', get_post_format() );
                            }

                        endwhile;


                        else :

                            get_template_part( 'template-parts/content', 'none' );

                        endif; ?>
                    </div>
                    <?php numeric_posts_nav(); ?>
                </div>
            </div>
		</main><!-- #main -->
	</section><!-- #primary -->
</div>

<?php
get_sidebar();
get_footer();
