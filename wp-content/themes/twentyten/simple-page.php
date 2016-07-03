<?php
/**
 * Template Name: Simple page
 *
 * A custom page template for static page.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header();
?>
<div id="container">
    <div id="content" role="main">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <div id="page-" class="simple-page">
            <h2 class="page-title"><?php the_title(); ?></h2>
            <div class="page-text standard-margin">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile ?>
    </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>