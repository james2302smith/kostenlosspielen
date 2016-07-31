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
                <?php
                    global $wp;
                    $current_url = home_url(add_query_arg(array(),$wp->request));
                ?>
                <div class="fb-share-button" data-href="<?php echo $current_url?>" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                    <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_url)?>&amp;src=sdkpreparse">Share</a>
                </div>
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
                <header class="panel top-game-in-cat">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <a class="image" href="#">
                                    <img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/images/img-game-sample.jpg" alt="Sample" >
                                </a>
                            </div>
                            <div class="col-md-10">
                                <div class="game-info">
                                    <?php
                                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                                    the_archive_description( '<div class="taxonomy-description game-desc">', '</div>' );
                                    ?>
                                    <!--<h5 class="margin-bottom-5">Related Categories:</h5>
                                    <ul class="list-related-cat">
                                        <li><a href="#">Allient</a></li>
                                        <li><a href="#">Dragon</a></li>
                                        <li><a href="#">Zombie</a></li>
                                        <li><a href="#">Devil</a></li>
                                        <li><a href="#">Fantasy</a></li>
                                        <li><a href="#">Halloween</a></li>
                                        <li><a href="#">Horror</a></li>
                                    </ul>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </header><!-- .page-header -->


                <div class="panel panel-default">
                    <div class="panel-heading clearfix caret-down">
                        <ul class="cat-actions pull-right">
                            <li><span>Sort by: </span></li>
                            <li class="sort-item <?php echo (get_current_orderby() == 'vote' ? 'active' : '')?>"><a href="<?php echo get_category_order_link('vote')?>">Melst gesplelte</a></li>
                            <li class="sort-item <?php echo (get_current_orderby() == 'new' ? 'active' : '')?>"><a href="<?php echo get_category_order_link('new')?>">New</a></li>
                            <li class="sort-item <?php echo (get_current_orderby() == 'best' ? 'active' : '')?>"><a href="<?php echo get_category_order_link('best')?>">Bewertete</a></li>
                        </ul>
                        <?php
                        global $wp_query;
                        the_archive_title( '<h4 class="panel-title ">', ' ('.$wp_query->found_posts.')'.'</h4>' );
                        ?>
                    </div>
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
        </div><!-- #primary -->
    </div><!-- .container -->
<?php
//get_sidebar();
get_footer();
