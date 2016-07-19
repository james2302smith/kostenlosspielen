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
	<div class="main-layout clearfix">
		<div class="fluid-column">
			<div class="inner">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
						<div class="panel panel-default popular-games-box clearfix">
							<div class="panel-heading board-header">
								<h4 class="panel-title"><span class="board-title"><i class="icon-cm icon-cm-heart-yellow"></i> Populäre Spiele</span></h4>
							</div>
							<a class="more-link" href="#">Mehr</a>
							<div id="favoriteSlider" class="favorite-slider">
								<?php
									$query='SELECT * FROM kostenlosspielen_posts
											WHERE kostenlosspielen_posts.post_status =  \'publish\'
											AND kostenlosspielen_posts.post_type =  \'post\'
											ORDER BY game_views DESC
											LIMIT 0,32'; 
									$pageposts = $wpdb->get_results($query, ARRAY_A);
									foreach (array_chunk($pageposts, 16) as $row) {
										echo '<div class="row-item">';
										foreach ($row as $post){
										$post_image=$post['game_image'];
										?>
										<div class="item">
											<div class="ArrangeID_waiting"></div>
											<a title="<?php echo $post['post_title']; ?>" href="<?php echo SITE_ROOT_URL.'/'.$post['post_name']; ?>.html"><img src="<?php echo $post_image; ?>" width="134" height="100" alt="kostenlos spielen <?php echo $post['post_title']; ?>" title="<?php echo $post['game_intro']; ?>" />
												<span class="title"><?php echo $post['post_title']; ?></span>
											</a>
										</div>
								   <?php
								   		}
								   		echo '</div>';
									}
								   ?>
							</div>
						</div>
						<div class="row">
						<div class="col-md-4 col-lg-3">
								<?php render_home_category('denkspiele', 'denkspiele');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('abenteuer-spiele', 'abenteuer');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('maedchen-spiele', 'madchen');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('geschicklichkeitsspiele', 'geschick');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('action-spiele', 'action');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('sport-spiele', 'sport');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('abenteuer-spiele', 'abenteuer');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('rennspiele', 'renen');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('denkspiele', 'denkspiele');?>
							</div>
							<div class="col-md-4 col-lg-3">
								<?php render_home_category('action-spiele', 'action');?>
							</div>
						</div>
					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
		</div>
		<div class="fixed-column">
			<aside id="secondary" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'fav-cat-menu' ); ?>
				<div class="panel panel-default">
					<div class="panel-heading board-header board-lg">
						<h4 class="panel-title"><i class="icon-cm icon-cm-new"></i> <span>News Game</span></h4>
					</div>
					<div class="panel-body no-bg">
						<ul class="list-new-game-ver">
							<li>
								<a href="#" class="image img-4x3">
									<img src="<?php echo get_template_directory_uri(); ?>/images/img-cat-sample.png" alt="sample">
								</a>
								<h5 class="name"><a href="#">Goodgame EMPIRE <i class="icon-cm icon-cm-new"></i></a></h5>
							</li>
							<li>
								<a href="#" class="image img-4x3">
									<img src="<?php echo get_template_directory_uri(); ?>/images/img-cat-sample.png" alt="sample">
								</a>
								<h5 class="name"><a href="#">Goodgame EMPIRE <i class="icon-cm icon-cm-new"></i></a></h5>
							</li>
							<li>
								<a href="#" class="image img-4x3">
									<img src="<?php echo get_template_directory_uri(); ?>/images/img-cat-sample.png" alt="sample">
								</a>
								<h5 class="name"><a href="#">Goodgame EMPIRE <i class="icon-cm icon-cm-new"></i></a></h5>
							</li>
							<li>
								<a href="#" class="image img-4x3">
									<img src="<?php echo get_template_directory_uri(); ?>/images/img-cat-sample.png" alt="sample">
								</a>
								<h5 class="name"><a href="#">Goodgame EMPIRE <i class="icon-cm icon-cm-new"></i></a></h5>
							</li>
							<li>
								<a href="#" class="image img-4x3">
									<img src="<?php echo get_template_directory_uri(); ?>/images/img-cat-sample.png" alt="sample">
								</a>
								<h5 class="name"><a href="#">Goodgame EMPIRE <i class="icon-cm icon-cm-new"></i></a></h5>
							</li>
						</ul>
					</div>
				</div>
			</aside><!-- #secondary -->
		</div>
	</div><!-- .main-layout -->
<?php
get_footer();

