<?php
/*
Plugin Name: Category List Widget
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display List of Games' category in sidebar.
Author: Quang Vinh Pham

*/
add_action( 'widgets_init', create_function( '', 'return register_widget("CategoryList");' ) );

class CategoryList extends WP_Widget {
	/** constructor */
	function CategoryList() {
		parent::WP_Widget( 'CategoryList', $name = 'CategoryList' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		global $wpdb, $wp_version, $recent_posts_current_ID, $post;
		$cat_ID = get_query_var('cat');		
		$category_exclude=get_categories('child_of='.$cat_ID.'&hide_empty=1');
		//print_r($category_exclude);
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; 
			$args = array(
			'show_option_all'    => '',
			'orderby'            => 'name',
			'order'              => 'ASC',
			'show_count'         => 1,
			'hide_empty'         => 1,
			'use_desc_for_title' => 1,
			'child_of'           => 0,
			'hierarchical'       => 0,
			'depth'              => 0,
			'current_category'   => 0,
			'pad_counts'         => 0,
			'taxonomy'           => 'category'
		);
		$categories=get_categories($args);
			echo '<div style="overflow: scroll;overflow-x: hidden;height:400px;clear:both;padding-bottom:10px !important;">';
			$count=0;
			echo '<ul>';
			foreach($categories as $category) { 
			$count++;
			if($count % 2==1){
			echo '<li>
			<a target="_blank" rel="nofollow" href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a>
			</li>';
			}else{
			echo '<li class="alt">
			<a target="_blank" rel="nofollow" href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a>
			</li>';
			}
			}
			echo '</ul></div>';
			echo '<div style="margin-left:60px;margin-bottom:5px;margin-top:5px;font-weight:bold;"><a rel="nofollow" href="'.SITE_ROOT_URL.'/?s=" target="_blank">Alle Spielkategorie anzeigen</a></div>';
			//echo $test;
			echo $after_widget;
			echo '<div style="clear:both;"></div>';
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$category_include = esc_attr( $instance[ 'category_include' ] );			
		}
		else {
			$title = __( 'List of Category to show', 'text_domain' );
			$category_include = '75,104,387,405,3237,271,169,395,1310,4144,4191,389,419,1712,5438,2263,3927';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php 
	}

} // class RandomGames
?>