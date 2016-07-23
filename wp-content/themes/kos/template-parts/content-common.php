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
			<span class="squre-view">81</span>
			<span class="count-played"><i class="icon-cm icon-cm-game-pad-mini"></i> <?php echo $post->game_views ?></span>
		</header><!-- .entry-header -->
	</div>
</article><!-- #post-## -->
