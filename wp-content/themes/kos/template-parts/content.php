<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kos
 */
$image=$post->game_image;
$author=$post->game_author;
$email=$post->game_email;
$flash=$post->game_flash;
$flash_width=$post->game_width;
$flash_height=$post->game_height;
$iframe=$post->game_iframe;

?>
<br>
<div class="layout-singer-top clearfix">
	<div class="fluid-column">
		<div class="inner">
            <div class="full-screen-modal">
			<div class="panel game-play-box panel-default">
				<div class="panel-heading clearfix">
					<div class="panel-title pull-left"><?php the_title(); ?> </div><span class="stars"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star"></i></span>
					<ul class="game-action pull-right">
						<li><a href="#comment-area">Komment (<?php echo get_comments_number()?>)</a></li>
						<li><a href="#"><i class="icon-cm icon-cm-rank"></i></a></li>
						<li><a href="#"><i class="icon-cm icon-cm-heart-yellow"></i></a></li>
						<li>
                            <a href="#" data-action="fullscreen">
                                <i class="icon-cm icon-cm-resize"></i>
                                <!--<i class="fa fa-expand" aria-hidden="true"></i>-->
                                <i class="fa fa-compress" aria-hidden="true"></i>
                            </a>
                        </li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="large-screenshot" style="margin-top:10px;">

				<div class="large-screenimg">
					<?php

					if(strlen($flash)>0) {
						if($flash_width>0){
							$width=$flash_width;
						}else{
							$width= 650;
						}
						if($flash_height>0){
							$height=$flash_height;
						}else{
							$height=500;
						}
					}
					?>
					<div id="divGamePad">


						<?php
						if(strlen($flash)>0){
							?>

							<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="<?php echo $width; ?>" height="<?php echo $height; ?>" id="movie_name" align="middle">
								<param name="wmode" value="transparent" />
								<param name="movie" value="<?php echo $flash; ?>"/>
								<!--[if !IE]>-->
								<object type="application/x-shockwave-flash" data="<?php echo $flash; ?>" width="100%" height="<?php echo $height; ?>">
									<param name="wmode" value="transparent" />
									<param name="movie" value="<?php echo $flash; ?>"/>
									<!--<![endif]-->
									<a href="http://www.adobe.com/go/getflash">
										<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/>
									</a>
									<div>
										<h2><?php echo $post->post_title; ?></h2>
									</div>

									<!--[if !IE]>-->
								</object>
								<!--<![endif]-->
							</object>
							<?php   }else{          ?>

								<iframe frameborder="0" scrolling="no" width="710" height="530" src="<?php echo $iframe; ?>"></iframe>
								<?php };?>
							</div>
						</div><!-- /screenimg -->

					</div><!-- /screenshot-->
				</div>
			</div><!-- .panel -->
            </div>
		</div>
	</div><!-- .fluild-column -->
	<div class="fixed-column">
		<img src="<?php echo get_template_directory_uri(); ?>/images/sample-banner-ads.png" alt="Sample">
	</div>
</div><!-- .layout-singer-top -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="panel panel-default google-custom-box">
		<div class="panel-body">
			<p>Spieler, die transformers Prestigez gespielt haben, Spielten auch  </p>
		</div>
	</div>

	<div class="panel comment-box panel-default panel-bordered">
		<div class="panel-body">
<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
?>
		</div>
	</div><!-- comment-box -->

	<div class="panel panel-default panel-bordered">
		<div class="panel-heading board-header">
			<h4 class="panel-title">
				<i style="margin-top: 8px;" class="icon-cm icon-cm-question"></i>How to play
			</h4>
		</div>
		<div class="panel-body">
			<div class="entry-content">
				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'kos' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kos' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-## -->
