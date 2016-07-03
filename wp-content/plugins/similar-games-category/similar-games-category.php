<?php
/*
Plugin Name: Similar Games Category Widget
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display similar games in a category in sidebar.
Author: Quang Vinh Pham

*/
add_action( 'widgets_init', create_function( '', 'return register_widget("SimilarGamesCategory");' ) );

class SimilarGamesCategory extends WP_Widget {
	/** constructor */
	function SimilarGamesCategory() {
		parent::WP_Widget( 'SimilarGamesCategory', $name = 'SimilarGamesCategory' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		global $wpdb, $wp_version, $post;
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		$num = $instance['num'];
		$cat_ID = get_query_var('cat');
		$cat = get_category($cat_ID);
  		$categoryid=$cat->category_parent;
		$parent=get_category($categoryid);
		$title='<div class="widget-title">Weitere Spiele in '.$parent->name.'</div>';
		//print_r($categories);
			echo $before_title . $title . $after_title; 
			$query = "SELECT wposts.ID, wposts.post_title, wposts.post_name, wposts.post_date, 
			wpostmeta3.meta_value +0 as viewcount
			FROM $wpdb->posts wposts 
			JOIN $wpdb->postmeta wpostmeta3 ON ( wpostmeta3.post_id=wposts.ID )
			WHERE post_status = 'publish' AND post_type='post'
			AND wpostmeta3.meta_key='pvc_views' AND wposts.ID 
			IN ( SELECT object_id FROM kostenlosspielen_term_relationships AS r 
			JOIN kostenlosspielen_term_taxonomy AS x 
			ON x.term_taxonomy_id = r.term_taxonomy_id JOIN kostenlosspielen_terms AS t 
			ON t.term_id = x.term_id WHERE x.taxonomy = 'category' AND t.term_id IN(".$categoryid.") )
			ORDER BY viewcount DESC LIMIT $num";
			//echo $query;
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			$counter=0;
			echo '<div id="similar-gamesid">
			<div class="ArrangeID_waiting"></div>
			<div style="margin:5px 10px 7px 5px;"><a rel="nofollow" href="javascript:void(0);" name="meist-'.$categoryid.'-'.$num.'" class="similar-games"><strong>Meist gespielt</strong></a> | <a rel="nofollow" href="javascript:void(0);" name="best-'.$categoryid.'-'.$num.'" class="similar-games">Best bewertete</a></div>';
  		    foreach ($pageposts as $post){
			$phpdate = strtotime( $post['post_date'] );
			$post_image=replaceImages(get_post_meta($post['ID'], 'image', true),'75');
			$post_intro=get_post_meta($post['ID'], 'intro_home', true);
				
				   echo '<div>
				            <div class="widget_games_left"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank"><img src="'.$post_image.'" width="75" height="56" alt="'.$post['post_title'].'" title="'.$post_intro.'" /></a></div>
				            <div class="widget_games_right">
					            <div><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank">'.$post['post_title'].'</a></div>
					            <div style="margin-bottom:5px;">'.number_format($post['viewcount'],0,',','.').'-mal gespielt</div>
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
		$instance['num'] = strip_tags($new_instance['num']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$num = esc_attr( $instance[ 'num' ] );			
		}
		else {
			$num = 10;
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of Spiele:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" />
		</p>
		<?php 
	}

} // class RandomGames
?>