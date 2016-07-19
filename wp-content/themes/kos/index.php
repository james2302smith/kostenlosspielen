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
	<div class="row">
        <div class="col-md-3">
            <?php render_home_category('denkspiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('abenteuer-spiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('maedchen-spiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('geschicklichkeitsspiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('action-spiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('sport-spiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('abenteuer-spiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('rennspiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('denkspiele');?>
        </div>
        <div class="col-md-3">
            <?php render_home_category('action-spiele');?>
        </div>
		<!--<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default	category-box-item">
				<div class="panel-heading board-header">
					<h4 class="panel-title"><i class="icon-cat-sm icon-cat-sm-denkspiele"></i>Denkspiele</h4>
				</div>
				<div class="panel-body">
					<a class="image" href="#">
						<img class="img-responsive" src="<?php /*echo get_template_directory_uri(); */?>/images/img-cat-sample.png" alt="samples">
					</a>
					<ul class="list-cat-ver clearfix">
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
						<li><a href="#"><span class="name">Baby</span> <span class="number">303</span></a></li>
					</ul>
				</div>
			</div>
		</div>-->
		

	</div>
<?php
get_footer();

