<?php
/*
Plugin Name: Newest Games Widget
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display newest games in sidebar.
Author: Quang Vinh Pham

*/
add_action( 'widgets_init', create_function( '', 'return register_widget("NewestGames");' ) );

class NewestGames extends WP_Widget {
	/** constructor */
	function NewestGames() {
		parent::WP_Widget( 'NewestGames', $name = 'NewestGames' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		global $wpdb, $wp_version, $recent_posts_current_ID, $post;
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		$num = $instance['num'];
		if ( $title )
			echo $before_title . $title . $after_title; 
			$query = "SELECT ID, post_title, post_name, post_date	FROM $wpdb->posts 
			WHERE post_status = 'publish' AND post_type='post'
			ORDER BY post_date DESC LIMIT $num";

			/*$query = "SELECT wposts.ID, wposts.post_title, wposts.post_name, wposts.post_date, 
			wpostmeta1.meta_value as image, wpostmeta2.meta_value as intro, wpostmeta3.meta_value + 6922 as viewcount   
			FROM $wpdb->posts wposts 
			JOIN $wpdb->postmeta wpostmeta1 ON ( wpostmeta1.post_id=wposts.ID ) 
			JOIN $wpdb->postmeta wpostmeta2 ON ( wpostmeta2.post_id=wposts.ID )     
			JOIN $wpdb->postmeta wpostmeta3 ON ( wpostmeta3.post_id=wposts.ID )
			WHERE post_status = 'publish' AND post_type='post'
			AND wpostmeta1.meta_key='image'
			AND wpostmeta2.meta_key='intro'
			AND wpostmeta3.meta_key='pvc_views'
			ORDER BY post_date DESC LIMIT $num";*/
			//echo $query;
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			$counter=0;
			echo '<div>';
  		    foreach ($pageposts as $post){
			$post_img = get_post_meta($post['ID'], 'image', true);
			$post_views = get_post_meta($post['ID'], 'pvc_views', true);
			
			$phpdate = strtotime( $post['post_date'] );
				   echo '<div>
				            <div class="widget_games_left"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="bookmark"><img src="'.$post_img.'" width="75" height="57" alt="'.$post['post_title'].'" title="'.$post['post_title'].'" /></a></div>
				            <div class="widget_games_right">
					            <div><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="bookmark">'.$post['post_title'].'</a></div>
        					    <div>Online seit: '.date('d-m-Y', $phpdate).'</div>
					            <div style="margin-bottom:5px;">'.$post_views.'-mal gespielt</div>
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

} // class NewestGames
?>