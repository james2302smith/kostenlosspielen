<?php
/*
Plugin Name: Category List Widget Horizontal
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display List of Games' category in footer.
Author: Quang Vinh Pham

*/
add_action( 'widgets_init', create_function( '', 'return register_widget("CategoryListHorizontal");' ) );

class CategoryListHorizontal extends WP_Widget {
	/** constructor */
	function CategoryListHorizontal() {
		parent::WP_Widget( 'CategoryListHorizontal', $name = 'CategoryListHorizontal' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		global $wpdb, $wp_version, $recent_posts_current_ID, $post;
		$cat_ID = get_query_var('cat');		
		$category_exclude=get_categories('child_of='.$cat_ID.'&hide_empty=1');
		//print_r($category_exclude);
		foreach ($category_exclude as $category) {
			$category_listID = $category_listID.$category->cat_ID.',';
		}
		$category_listID = $category_listID.$cat_ID.',385,394,404,410,417,422,430,431,4033,261,393,403,409,415,421,423,429,439';
		//.',3818,3237,4150,413,2534,4582,4326,425,389,447,433,4239,4391,342,406,4148,388,428,435,436,401,397,4172,4191,411,4154,4329,3894,4301,3925,391,2114,4155,432,4800,1310,437,4156,4390,387,569,5438,2796,4269,390,1949,250,4209,104,4389,412,75,408,2352,426,427,4325,4192,395,399,1742,400,4208,1935,405,271,3924,4650,4370,3415';
		;
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; 
			$args = array(
			'show_option_all'    => '',
			'orderby'            => 'count',
			'order'              => 'DESC',
			'show_count'         => 1,
			'hide_empty'         => 1,
			'use_desc_for_title' => 1,
			'child_of'           => 0,
			'hierarchical'       => 0,
			'depth'              => 0,
			'current_category'   => 0,
			'pad_counts'         => 0,
			'number'			 => 50,
			'exclude'			 =>	$category_listID,
			'taxonomy'           => 'category'
		);
		$categories=get_categories($args);
			foreach($categories as $category) { 
			$count++;
			//echo $count;
			if($count % 5==1){
				echo '<p>';
			}
			
			echo '<a rel="nofollow" href="'.get_category_link($category->cat_ID).'"><img src="'.SITE_CURRENT_THEME_URL.'/styles/default/'.$category->slug.'.png" width="20" width="20" alt="'.$category->name.'" title="'.$category->name.'" style="vertical-align: middle;"/></a>
			<a style="margin-right:15px;" rel="nofollow" href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'('.$category->count.')</a>';
			if($count % 5==0){			echo '</p>';}
			}
			echo '<p style="margin-left:560px;margin-bottom:5px;margin-top:5px;font-weight:bold;"><a rel="nofollow" href="'.SITE_ROOT_URL.'/?s=" target="_blank">Alle Spielkategorie anzeigen</a></p>';
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