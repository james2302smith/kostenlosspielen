<?php
/*
Plugin Name: Best Games Category Widget
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display highest games in Homepage and specific category (category1 of games) in sidebar.
Author: Quang Vinh Pham

*/
add_action( 'widgets_init', create_function( '', 'return register_widget("BestGamesCategory");' ) );

class BestGamesCategory extends WP_Widget {
	/** constructor */
	function BestGamesCategory() {
		parent::WP_Widget( 'BestGamesCategory', $name = 'BestGamesCategory' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		global $wpdb, $wp_version, $recent_posts_current_ID;
		global $post;
		//print_r($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		$num = $instance['num'];
		$category_id = $instance['category_id'];
		
		if ( $title )
			echo $before_title . $title . $after_title; 
			if($category_id==0){
				$query="SELECT DISTINCT kostenlosspielen_posts.*, (t1.meta_value+0.00) AS ratings_average, (t2.meta_value+0.00) AS ratings_users
				FROM kostenlosspielen_posts JOIN kostenlosspielen_postmeta AS t1 ON t1.post_id = kostenlosspielen_posts.ID 
				JOIN kostenlosspielen_postmeta AS t2 ON t1.post_id = t2.post_id 
				WHERE kostenlosspielen_posts.post_status = 'publish' AND kostenlosspielen_posts.post_type='post'
				AND t1.meta_key = 'ratings_average' 
				AND t2.meta_key = 'ratings_users' AND t2.meta_value >= 10 
				ORDER BY ratings_average DESC, ratings_users DESC LIMIT $num";
			}else{	
			$query="SELECT DISTINCT kostenlosspielen_posts.*, (t1.meta_value+0.00) AS ratings_average, (t2.meta_value+0.00) AS ratings_users
			FROM kostenlosspielen_posts JOIN kostenlosspielen_postmeta AS t1 ON t1.post_id = kostenlosspielen_posts.ID 
			JOIN kostenlosspielen_postmeta AS t2 ON t1.post_id = t2.post_id 
			WHERE kostenlosspielen_posts.post_status = 'publish' AND kostenlosspielen_posts.post_type='post'
			AND kostenlosspielen_posts.category1 =".$categoryid." AND t1.meta_key = 'ratings_average' 
			AND t2.meta_key = 'ratings_users' AND t2.meta_value >= 2 
			ORDER BY ratings_average DESC, ratings_users DESC LIMIT $num";
			}
				//echo $query;
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			$counter=0;
			echo '<div>';
  		    foreach ($pageposts as $post){
			$post_image=replaceImages($post['game_image'],'75');
			$post_ratings_average = floatval($post['ratings_average']);
				   echo '<div>
				            <div class="widget_games_left"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank"><img src="'.$post_image.'" width="75" height="56" alt="'.$post['post_title'].'" title="'.$post['game_intro'].'" /></a></div>
				            <div class="widget_games_right">
					            <div><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank">'.$post['post_title'].'</a></div>
					            <div>'.$post_ratings_average.' / 10 Punkte</div>
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
		$instance['category_id'] = strip_tags($new_instance['category_id']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$num = esc_attr( $instance[ 'num' ] );
			$category_id = esc_attr( $instance[ 'category_id' ] );			
		}
		else {
			$title = __( 'New title', 'text_domain' );
			$num = 10;
			$category_id = 72;
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
		<p>
		<label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Category ID:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('category_id'); ?>" name="<?php echo $this->get_field_name('category_id'); ?>" type="text" value="<?php echo $category_id; ?>" />
		</p>

		<?php 
	}

} // class BestGamesCategory
?>