<?php
/*
Plugin Name: Random Games Widget
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display random games in sidebar.
Author: Quang Vinh Pham

*/
add_action( 'widgets_init', create_function( '', 'return register_widget("RandomGames");' ) );

class RandomGames extends WP_Widget {
	/** constructor */
	function RandomGames() {
		parent::WP_Widget( 'RandomGames', $name = 'RandomGames' );
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
			$query = "SELECT wposts.ID, wposts.post_title, wposts.post_name, wposts.post_date
			FROM $wpdb->posts wposts 
			WHERE post_status = 'publish' AND post_type='post'
			ORDER BY RAND() DESC LIMIT $num";
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			$counter=0;
			echo '<div>';
  		    foreach ($pageposts as $post){
			$post_image=get_post_meta($post['ID'], 'image', true);
			$post_intro=get_post_meta($post['ID'], 'intro_home', true);
			$post_views=get_post_meta($post['ID'], 'pvc_views', true)+0;
  		    	
			$phpdate = strtotime( $post['post_date'] );
				   echo '<div>
				            <div class="widget_games_left"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="bookmark"><img src="'.$post_image.'" width="75" height="57" alt="'.$post['post_title'].'" title="'.$post_intro.'" /></a></div>
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

} // class RandomGames
?>