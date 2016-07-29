<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kos
 */

get_header(); ?>
<div class="container">
	<div class="main-layout clearfix">
		<div class="fluid-column">
			<div class="inner">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
						<div class="panel panel-default popular-games-box clearfix">
							<div class="panel-heading board-header">
								<h4 class="panel-title"><span class="board-title"><i class="icon-cm icon-cm-heart-yellow"></i> Populäre Spiele</span></h4>
								<div class="swiper-next fsw-next"><i class="fa fa-arrow-right"></i></div>
        						<div class="swiper-prev fsw-prev"><i class="fa fa-arrow-left"></i></div>
							</div>
							<a class="more-link" href="#">Mehr <i class="fa fa-caret-right" aria-hidden="true"></i></a>
							<div id="favoriteSwiper" class="favorite-swiper swiper-container">
								<div  class="swiper-wrapper">
									<?php
										$query='SELECT * FROM kostenlosspielen_posts
												WHERE kostenlosspielen_posts.post_status =  \'publish\'
												AND kostenlosspielen_posts.post_type =  \'post\'
												ORDER BY game_views DESC
												LIMIT 0,24'; 
										$pageposts = $wpdb->get_results($query, ARRAY_A);
											foreach ($pageposts as $post){
											$post_image=$post['game_image'];
											?>
											<div class="swiper-slide item">
												<div class="ArrangeID_waiting"></div>
												<a title="<?php echo $post['post_title']; ?>" href="<?php echo get_permalink($post['ID']) ?>"><img src="<?php echo $post_image; ?>" width="134" height="100" alt="kostenlos spielen <?php echo $post['post_title']; ?>" title="<?php echo $post['game_intro']; ?>" />
													<span class="title"><?php echo $post['post_title']; ?></span>
												</a>
											</div>
									   <?php
										}
									   ?>
								</div>
							</div>
						</div>
					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
		</div>
		<div class="fixed-column">
			<aside id="secondary" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'fav-cat-menu' ); ?>
			</aside><!-- #secondary -->
		</div>
	</div><!-- .main-layout -->
	<div class="main-bottom clearfix">
		<div class="cate-box-item">
			<?php render_home_category('denkspiele', 'denkspiele');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('abenteuer-spiele', 'abenteuer');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('maedchen-spiele', 'madchen');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('geschicklichkeitsspiele', 'geschick');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('action-spiele', 'action');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('sport-spiele', 'sport');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('abenteuer-spiele', 'abenteuer');?>
		</div>
		<div class="cate-box-item newest-game">
			<div class="panel panel-default panel-bordered">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cm icon-cm-new"></i> <span>News Game</span></h4>
				</div>
				<div class="panel-body no-padding no-bg">
					<ul class="list-new-game-ver">
						<?php
							$args = array( 'numberposts' => '5', 'post_status' => 'publish');
							$recent_posts = wp_get_recent_posts($args);
							//debug($recent_posts);
							foreach( $recent_posts as $recent ){
						?>
							<li>
								<a href="<?php echo get_permalink($recent["ID"]) ?>" class="image img-4x3">
									<img src="<?php echo $recent["game_image"]  ?>" alt="sample">
								</a>
								<h5 class="name"><a href="<?php echo get_permalink($recent["ID"]) ?>"><?php echo $recent["post_title"] ?> <i class="icon-cm icon-cm-new"></i></a></h5>
							</li>
						<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('rennspiele', 'renen');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('denkspiele', 'denkspiele');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('action-spiele', 'action');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('denkspiele', 'denkspiele');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('abenteuer-spiele', 'abenteuer');?>
		</div>
		<div class="cate-box-item">
			<?php render_home_category('maedchen-spiele', 'madchen');?>
		</div>
	</div>
</div> <!-- .container -->
<?php
get_footer();

