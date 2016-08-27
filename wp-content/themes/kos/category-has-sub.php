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
                                    the_archive_title( '<h2 class="page-title">', '</h2>' );
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
                    <div class="panel-heading  caret-down">
                        <ul class="cat-actions pull-right">
                            <li><span>Sort by: </span></li>
                            <li class="sort-item <?php echo (get_current_orderby() == 'most' ? 'active' : '')?>"><a href="<?php echo get_category_order_link('most')?>">Melst gesplelte</a></li>
                            <li class="sort-item <?php echo (get_current_orderby() == 'new' ? 'active' : '')?>"><a href="<?php echo get_category_order_link('new')?>">New</a></li>
                            <li class="sort-item <?php echo (get_current_orderby() == 'best' ? 'active' : '')?>"><a href="<?php echo get_category_order_link('best')?>">Bewertete</a></li>
                        </ul>
                        <?php
                        global $wp_query;
                        the_archive_title( '<h4 class="panel-title ">', ' ('.$wp_query->found_posts.')'.'</h4>' );
                        ?>
                    </div>
                    <div class="panel-body">
                        <div class="list-game-default has-sub clearfix">
                            <div class="banner-ads-right">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/sample-banner-ads-2.png" alt="Sample">
                            </div>
                            <div class="cate-box-item">
                                <div class="panel panel-default category-box-item">
                                    <div class="panel-heading">
                                        <h4 class="panel-title" title="Denkspiele"><span>Sub Category</span></h4>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-cat-ver show-full clearfix">
                                            <?php
                                            $category = get_queried_object();
                                            $categories = get_categories(array('child_of' => $category->cat_ID ));
                                            ?>
                                            <?php foreach($categories as $cat):?>
                                                <li>
                                                    <a title="<?php echo $cat->name?>" href="<?php echo get_category_link($cat)?>">
                                                        <span class="name"><?php echo $cat->name?></span>
                                                    </a>
                                                </li>
                                            <?php endforeach;?>
                                            <!--<li>
                                                <a title="Unblock me Spiele" href="http://local.kostenlosspielen.net/spiele/denkspiele/unblock-me-spiele/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/02/kokoris-2.gif" cat-name="Unblock me Spiele">
                                                    <span class="name">Unblock me Spiele</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Sudoku Spiele" href="http://local.kostenlosspielen.net/spiele/denkspiele/sudoku-spiele/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/08/sudoku-original.gif" cat-name="Sudoku Spiele">
                                                    <span class="name">Sudoku Spiele</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Verchiedene Denkspiele" href="http://local.kostenlosspielen.net/spiele/denkspiele/verschiedene-denkspiele/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/08/puzzle-maniax-2.gif" cat-name="Verchiedene Denkspiele">
                                                    <span class="name">Verchiedene Denkspiele</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Wimmelbilder" href="http://local.kostenlosspielen.net/spiele/denkspiele/wimmelbilder/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/08/wolken.gif" cat-name="Wimmelbilder">
                                                    <span class="name">Wimmelbilder</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Zuma" href="http://local.kostenlosspielen.net/spiele/denkspiele/zuma/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/09/sort-my-tiles-uzumaki-naruto-2.gif" cat-name="Zuma">
                                                    <span class="name">Zuma</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Wortspiele" href="http://local.kostenlosspielen.net/spiele/denkspiele/wortspiele/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/10/word-search-gameplay-58.jpg" cat-name="Wortspiele">
                                                    <span class="name">Wortspiele</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Straße bauen" href="http://local.kostenlosspielen.net/spiele/denkspiele/strasse-bauen/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2013/09/wie-viele-teddybaeren.gif" cat-name="Straße bauen">
                                                    <span class="name">Straße bauen</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Schach Spiele" href="http://local.kostenlosspielen.net/spiele/denkspiele/schach-spiele/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2013/09/monster-milch.png" cat-name="Schach Spiele">
                                                    <span class="name">Schach Spiele</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Blocks-Spiele" href="http://local.kostenlosspielen.net/spiele/denkspiele/blocks-spiele/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/08/mosaik.gif" cat-name="Blocks-Spiele">
                                                    <span class="name">Blocks-Spiele</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="4-Gewinnt Spiele" href="http://local.kostenlosspielen.net/spiele/denkspiele/4-gewinnt-spiele/" game-image="http://www.kostenlosspielen.biz/wp-content/uploads/2012/09/connect-four.gif" cat-name="4-Gewinnt Spiele">
                                                    <span class="name">4-Gewinnt Spiele</span>
                                                </a>
                                            </li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
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

                            endif;
                            ?>
                        </div><!-- .list-game-default -->
                        <?php numeric_posts_nav(); ?>
                    </div>
                </div>

            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .container -->
<?php
//get_sidebar();
get_footer();
