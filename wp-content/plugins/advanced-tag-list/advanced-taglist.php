<?php
/**
Plugin Name: Advanced Tag List
Version: 1.2
Plugin URI: http://justmyecho.com/2010/07/an-advanced-tag-list-widget/
Description: A widget to display blog tags in list format, instead of cloud.
Author: Robin Dalton
Author URI: http://justmyecho.com
**/

function advanced_taglist_load_widget() {
	register_widget( 'Advanced_Taglist_Widget' );
}

class Advanced_Taglist_Widget extends WP_Widget {
			
	/* Set up some default widget settings. */
	var $defaults = array();

	function Advanced_Taglist_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ataglist', 'description' => __('Display advanced tag lists.', 'ataglist') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'ataglist-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'ataglist-widget', __('Advanced Tag List', 'ataglist'), $widget_ops, $control_ops );
		
		/*$this->defaults = array ('taglist_title' => '',
							'taglist_show_count' => 1,
							'taglist_order' => 1,
							'taglist_limit' => 0,
							'taglist_dropdown' => 0,
							'taglist_cat_inc' => '',
							'taglist_cat_exc' => '',
							'taglist_tag_exc' => '',
							'taglist_cache' => ''
						 );
		
		if(!get_option('ataglist')) {
			add_option('ataglist', $this->defaults);
		}*/
	}
	
	function widget( $args, $instance ) {
			
		extract( $args );		
		$cache = get_option('ataglist');
		$taglist_cache = get_option('taglist_cache');
		echo $before_widget;
		if($instance['taglist_title'] != '') {
			echo $before_title . $instance['taglist_title'] . $after_title;
		}
		
		echo $taglist_cache;
		
		echo $after_widget;	
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		foreach($new_instance as $key => $val) {
			$instance[$key] = strip_tags( $new_instance[$key] );
		}
		$instance['taglist_show_count'] = ( $new_instance['taglist_show_count'] == 1 ) ? 1 : 0;
		$instance['taglist_dropdown'] = ( $new_instance['taglist_dropdown'] == 1 ) ? 1 : 0;

		update_option('ataglist', $instance);
		ataglist_generate_tag_cache();

		return $instance;
	}

	function form( $instance ) {
		
		$instance = wp_parse_args( (array) $instance, $this->defaults ); 
		
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_title' ); ?>"><?php _e('Title:', 'ataglist'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_title' ); ?>" name="<?php echo $this->get_field_name( 'taglist_title' ); ?>" value="<?php echo $instance['taglist_title']; ?>" style="width:225px;" />
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'taglist_show_count' ); ?>" name="<?php echo $this->get_field_name( 'taglist_show_count' ); ?>" value="1"<?php echo ($instance['taglist_show_count'] == 1) ? ' checked="checked"' : ''; ?>>
			<label for="<?php echo $this->get_field_id( 'taglist_show_count' ); ?>"><?php _e('Display Tag Count', 'ataglist'); ?></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_order' ); ?>"><?php _e('Tag List order:', 'ataglist'); ?></label>
			<select id="<?php echo $this->get_field_id( 'taglist_order' ); ?>" name="<?php echo $this->get_field_name( 'taglist_order' ); ?>">
				<option value="1"<?php echo ($instance['taglist_order'] == 1) ? ' selected="selected"' : ''; ?>>Alphabetical</option>
				<option value="2"<?php echo ($instance['taglist_order'] == 2) ? ' selected="selected"' : ''; ?>>Most Popular</option>
				</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_limit' ); ?>"><?php _e('Limit Tags:', 'ataglist'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_limit' ); ?>" name="<?php echo $this->get_field_name( 'taglist_limit' ); ?>" value="<?php echo $instance['taglist_limit']; ?>" style="width:50px;" /><br />
			<span style="font-size:.9em;">(0 = display all tags)</span>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_tag_exc' ); ?>"><?php _e('Exclude Tags:', 'ataglist'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_tag_exc' ); ?>" name="<?php echo $this->get_field_name( 'taglist_tag_exc' ); ?>" value="<?php echo $instance['taglist_tag_exc']; ?>" style="width:225px;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_cat_inc' ); ?>"><?php _e('Include tags from Category:', 'ataglist'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_cat_inc' ); ?>" name="<?php echo $this->get_field_name( 'taglist_cat_inc' ); ?>" value="<?php echo $instance['taglist_cat_inc']; ?>" style="width:225px;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'taglist_cat_exc' ); ?>"><?php _e('Exclude tags from Category:', 'ataglist'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'taglist_cat_exc' ); ?>" name="<?php echo $this->get_field_name( 'taglist_cat_exc' ); ?>" value="<?php echo $instance['taglist_cat_exc']; ?>" style="width:225px;" /><br />
			<span style="font-size:.9em;">* Exclude field is applied only if Include field is empty.</span>
		</p>		
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'taglist_dropdown' ); ?>" name="<?php echo $this->get_field_name( 'taglist_dropdown' ); ?>" value="1"<?php echo ($instance['taglist_dropdown'] == 1) ? ' checked="checked"' : ''; ?>>
			<label for="<?php echo $this->get_field_id( 'taglist_dropdown' ); ?>"><?php _e('Display as a drop down', 'ataglist'); ?></label>
		</p>
		
	<?php
	}
}

function ataglist_generate_tag_cache() {
	global $wpdb;
	
	$instance = get_option('ataglist');
	
	if(($instance['taglist_cat_inc'] == '') && ($instance['taglist_cat_exc'] == '') && ($instance['taglist_tag_exc'] == '')) {
		
		/* Do a basic get_tags query if category include/exclude fields are empty */
		$orderby = 'name';
		switch($instance['taglist_order']) {
			case 1:	$orderby = 'name'; break;
			case 2: $orderby = 'count&order=DESC'; break;
		}
		$number = ($instance['taglist_limit'] != 0) ? '&number=' . $instance['taglist_limit'] : '';
		$querystring = 'orderby=' . $orderby . $number;
		
		$tags = get_tags($querystring);
	} else {
		
		/* else do an advanced sql query if category include/exclude exists */
		$termquery = '';
		
		if($instance['taglist_tag_exc'] != '') {
			$thetags = explode(",",$instance['taglist_tag_exc']);
				for($i=0;$i<count($thetags);$i++) {
					$thetags[$i] = trim($thetags[$i]);
				}
			$taglist = implode("','",$thetags);
			$termquery .= "(tr.name NOT IN ('" . $taglist . "') AND xr.taxonomy = 'post_tag') AND";
		}
		if($instance['taglist_cat_inc'] != '') {
			$thecats = explode(",",$instance['taglist_cat_inc']);
				for($i=0;$i<count($thecats);$i++) {
					$thecats[$i] = trim($thecats[$i]);
				}
			$catlist = implode("','",$thecats);				
			$termquery .= "(tl.name IN ('" . $catlist . "') AND xl.taxonomy = 'category') AND";
		} else if ($instance['taglist_cat_exc'] != '') {
			$thecats = explode(",",$instance['taglist_cat_exc']);
				for($i=0;$i<count($thecats);$i++) {
					$thecats[$i] = trim($thecats[$i]);
				}
			$catlist = implode("','",$thecats);	
			$termquery .= "(tl.name NOT IN ('" . $catlist . "') AND xl.taxonomy = 'category') AND";
		}
	
		switch($instance['taglist_order']) {
			case 1:	$orderby = 'tr.name ASC'; break;
			case 2: $orderby = 'xr.count DESC'; break;
		}
		$limit = ($instance['taglist_limit'] == 0) ? '' : 'LIMIT 0,' . $instance['taglist_limit'];
	
		$query = "SELECT tr.term_id, tr.name, tr.slug, xr.count
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->term_relationships rl 
					ON p.ID = rl.object_id
					LEFT JOIN $wpdb->term_taxonomy xl 
					ON rl.term_taxonomy_id = xl.term_taxonomy_id
					LEFT JOIN $wpdb->terms tl
					ON tl.term_id = xl.term_id
					RIGHT JOIN $wpdb->term_relationships rr 
					ON p.ID = rr.object_id
					RIGHT JOIN $wpdb->term_taxonomy xr
					ON rr.term_taxonomy_id = xr.term_taxonomy_id
					RIGHT JOIN $wpdb->terms tr
					ON tr.term_id = xr.term_id
					WHERE $termquery xr.taxonomy = 'post_tag' AND p.post_status = 'publish'
					GROUP BY tr.slug
					ORDER BY $orderby
					$limit";
				
		$tags = $wpdb->get_results( $query );
	}
	
	$instance['taglist_cache'] = '';
	
	if($tags) {
		
		if($instance['taglist_dropdown'] == 1) {
			$instance['taglist_cache'] .= '<select onChange="document.location.href=this.options[this.selectedIndex].value;">';
			foreach($tags as $tag) {
				$instance['taglist_cache'] .= '<option value=" ' . get_tag_link($tag->term_id) . '" >' . $tag->name;
				if($instance['taglist_show_count'] == 1) {
					$instance['taglist_cache'] .= ' (' . $tag->count . ')';
				}
				$instance['taglist_cache'] .= "</option>\n";
   			}
   			$instance['taglist_cache'] .= "</select>";
					
		} else {
		$instance['taglist_cache'] .= '<ul>';		
			foreach($tags as $tag) {
				$instance['taglist_cache'] .= '<li><div class="tagtext"><div class="tagtext_left"><a href="' . get_tag_link($tag->term_id) . '" rel="nofollow">' . $tag->name;
				$instance['taglist_cache'] .= '</a></div>';
				if($instance['taglist_show_count'] == 1) {
    		      $instance['taglist_cache'] .= '<div class="tagtext_right">' . $tag->count . ' Spiele </div>';
        	}
				$instance['taglist_cache'] .= '</div></li>';
			}
			$instance['taglist_cache'].= '</ul>';
		}
	} else {
		$instance['taglist_cache'] .= 'No tags to display.';
	}
	
	update_option('ataglist', $instance);		
	update_option('taglist_cache', $instance['taglist_cache']);
}

function jme_taglist_options_page() {
	$taglist = get_option('ataglist');
	
	if($_POST['save_settings']) {
		
		$taglist['taglist_show_count'] = ($_POST['taglist_show_count'] == 1) ? 1 : 0;
		$taglist['taglist_order'] = $_POST['taglist_order'];
		$taglist['taglist_limit'] = $_POST['taglist_limit'];
		$taglist['taglist_tag_exc'] = htmlspecialchars($_POST['taglist_tag_exc']);
		$taglist['taglist_cat_exc'] = htmlspecialchars($_POST['taglist_cat_exc']);
		$taglist['taglist_cat_inc'] = htmlspecialchars($_POST['taglist_cat_inc']);
		$taglist['taglist_dropdown'] = ($_POST['taglist_dropdown'] == 1) ? 1 : 0;
		
		update_option('ataglist', $taglist);
		ataglist_generate_tag_cache();
		$taglist = get_option('ataglist');
		echo '<div id="message" class="updated fade"><p>Your options have been saved.</p></div>';
	}
?>
<style type="text/css">
.wrap table.tbloptions td {padding:10px 0;}
</style>
<div class="wrap">
<div id="poststuff">
	<form method="post" name="jme_taglist_options">
	
	<h2>Advanced Tag List</h2>
		<p><?php _e('Use the <i>Advanced Tag List</i> Widget to add the widget to sidebar, or paste this code into your template where you want the widget to display:','ataglist'); ?> <br />
	<code>&lt;?php if(function_exists('jme_taglist')) { jme_taglist(); } ?&gt;</code></p>

	<div class="postbox">
		<div class="inside">	

		<table class="tbloptions">
		
			<tr>
				<td width="220"><?php _e('Display Tag Count', 'ataglist'); ?></td>
				<td><input type="checkbox" name="taglist_show_count" value="1"<?php echo ($taglist['taglist_show_count'] == 1) ? ' checked="checked"' : ''; ?>></td>
			</tr>
			
			<tr>
				<td><?php _e('Tag List Order', 'ataglist'); ?>:</td>
				<td><select name="taglist_order">
					<option value="1"<?php echo ($taglist['taglist_order'] == 1) ? ' selected="selected"' : ''; ?>>Alphabetical</option>
					<option value="2"<?php echo ($taglist['taglist_order'] == 2) ? ' selected="selected"' : ''; ?>>Most Popular</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><?php _e('Limit Tags', 'ataglist'); ?>:</td>
				<td><input type="text" name="taglist_limit" value="<?php echo $taglist['taglist_limit']; ?>" style="width:50px;" /><br />
					<span style="font-size:.8em;">(0 = display all tags)</span>
				</td>
			</tr>		

			<tr>
				<td><?php _e('Exclude Tags', 'ataglist'); ?>:</td>
				<td><input type="text" name="taglist_tag_exc" value="<?php echo $taglist['taglist_tag_exc']; ?>" style="width:300px;" />
				</td>
			</tr>
			
			<tr>
				<td><?php _e('Include tags from Category', 'ataglist'); ?>:</td>
				<td><input type="text" name="taglist_cat_inc" value="<?php echo $taglist['taglist_cat_inc']; ?>" style="width:300px;" />
				</td>
			</tr>			

			<tr>
				<td><?php _e('Exclude tags from Category', 'ataglist'); ?>:</td>
				<td><input type="text" name="taglist_cat_exc" value="<?php echo $taglist['taglist_cat_exc']; ?>" style="width:300px;" /><br />
					<span style="font-size:.8em;">* Exclude field is applied only if Include field is empty.</span>
				</td>
			</tr>

			<tr>
				<td><?php _e('Display as a drop down', 'ataglist'); ?>:</td>
				<td><input type="checkbox" name="taglist_dropdown" value="1"<?php echo ($taglist['taglist_dropdown'] == 1) ? ' checked="checked"' : ''; ?>>
				</td>
			</tr>
			
		</table>
		<p class="submit"><input type="submit" name="save_settings" class="button-primary" value="<?php _e('Save Options', 'ataglist'); ?>" /></p>
		</div>
	</div>
	</form>
</div>
</div>	
<?php 
}

function jme_taglist() {
	$cache = get_option('ataglist');
	echo $cache['taglist_cache'];
}

function jme_add_taglist_options_page() {
	add_options_page( __('Advanced TagList Options', 'ataglist'), __('Advanced Tag List', 'ataglist'), 'manage_options', basename(__FILE__), 'jme_taglist_options_page');
}

add_action('admin_menu', 'jme_add_taglist_options_page');
add_action('widgets_init', 'advanced_taglist_load_widget');
add_action('edit_post', 'ataglist_generate_tag_cache');
add_action('delete_post', 'ataglist_generate_tag_cache');
add_action('publish_post', 'ataglist_generate_tag_cache');
?>