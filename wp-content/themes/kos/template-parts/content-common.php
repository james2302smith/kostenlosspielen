<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kos
 */
//debug($post);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('game-item'); ?>>
	<div class="inner">
		<div class="entry-content">
			<a class="image img-4x3" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<img src="<?php echo $post->game_image; ?>" alt="<?php the_title(); ?>">
			</a>
		</div><!-- .entry-content -->
		<header class="entry-header">
			<?php
				the_title( '<h4 class="entry-title game-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
			?>
            <?php
            $ratingVal = get_post_meta(get_the_ID(), 'ratings_average', true);
            $rating = '0';
            if (is_float($ratingVal)) {
                $rating = number_format(floatval($ratingVal), 1, ',', '.');
                if (strpos($rating, ',') !== false) {
                    $rating = rtrim($rating, '0');
                    $rating = rtrim($rating, ',');
                }
            }
            ?>
			<span class="squre-view"><?php echo $rating?></span>
			<span class="count-played"><i class="icon-cm icon-cm-game-pad-mini"></i> <?php echo number_format($post->game_views, 0, ',', '.') ?></span>
		</header><!-- .entry-header -->
	</div>
</article><!-- #post-## -->
