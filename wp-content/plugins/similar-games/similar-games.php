<?php
/*
Plugin Name: Similar Games Widget
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display similar games in sidebar.
Author: Quang Vinh Pham

*/
add_action( 'widgets_init', create_function( '', 'return register_widget("SimilarGames");' ) );

class SimilarGames extends WP_Widget {
	/** constructor */
	function SimilarGames() {
		parent::WP_Widget( 'SimilarGames', $name = 'SimilarGames' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		global $wpdb, $wp_version, $post;
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		$num = $instance['num'];
		$postid = get_the_ID();
		$categories=get_the_category( $postid );
		//print_r($categories);
		foreach($categories as $category){
			if ($category->parent >0) {
				$categoryid=$category->cat_ID;
			}
		}

		if ( $title )
			echo $before_title . $title . $after_title; 
			$query = "SELECT DISTINCT wposts.*	FROM kostenlosspielen_posts wposts 
			WHERE wposts.post_status = 'publish' AND wposts.post_type='post' AND wposts.category2 =".(int)$categoryid."
			ORDER BY game_views DESC LIMIT $num";
			//if(!is_admin()) {		echo $query;	}
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			$counter=0;
			echo '<div id="similar-gamesid">
			<div class="ArrangeID_waiting"></div>
			<div style="margin:5px 10px 7px 5px;"><a rel="nofollow" href="javascript:void(0);" name="meist-'.$categoryid.'-'.$num.'" class="similar-games"><strong>Meist gespielt</strong></a> | <a rel="nofollow" href="javascript:void(0);" name="best-'.$categoryid.'-'.$num.'" class="similar-games">Best bewertete</a></div>';
  		    foreach ($pageposts as $post){
			$phpdate = strtotime( $post['post_date'] );
			$post_image=replaceImages($post['game_image'],'75');
				   echo '<div>
				            <div class="widget_games_left"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank"><img src="'.$post_image.'" width="75" height="56" alt="'.$post['post_title'].'" title="'.$post['game_intro'].'" /></a></div>
				            <div class="widget_games_right">
					            <div><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank">'.$post['post_title'].'</a></div>
					            <div style="margin-bottom:5px;">'.number_format($post['game_views'],0,',','.').' x gespielt</div>
			                </div>
				         </div>
				         <div style="clear:both;"></div>';
			}
			echo '</div>';
			echo $after_widget;
			echo '<div style="clear:both;"></div>';
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['num'] = strip_tags($new_instance['num']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$num = esc_attr( $instance[ 'num' ] );			
		}
		else {
			$title = __( 'New title', 'text_domain' );
			$num = 10;
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of Spiele:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" />
		</p>
		<?php 
	}

} // class RandomGames
?>