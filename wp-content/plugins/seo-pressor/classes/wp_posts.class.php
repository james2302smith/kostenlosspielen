<?php
if (!class_exists('WPPostsRateKeys_WPPosts')) {
	class WPPostsRateKeys_WPPosts
	{

	   /**
	    * The name of the keyword metadata
	    *
	    * @static 
	    * @var string
	    */
        static $keyword_metadata = '_posts_rate_key';
        
	   /**
	    * The name of the second keyword metadata
	    *
	    * @static 
	    * @var string
	    */
        static $keyword2_metadata = '_posts_rate_key2';
        
	   /**
	    * The name of the third keyword metadata
	    *
	    * @static 
	    * @var string
	    */
        static $keyword3_metadata = '_posts_rate_key3';
        
	   /**
	    * The name of the metadata: post has keyword in first sentence
	    *
	    * @static 
	    * @var string
	    */
        static $key_in_first_sentence_metadata = '_seopressor_key_first_sentence';
        
	   /**
	    * The name of the metadata: post has keyword in first sentence
	    *
	    * @static 
	    * @var string
	    */
        static $key_in_last_sentence_metadata = '_seopressor_key_last_sentence';
        
	   /**
	    * The name of the metadata: post has second keyword in first sentence
	    *
	    * @static 
	    * @var string
	    */
        static $key2_in_first_sentence_metadata = '_seopressor_key2_first_sentence';
        
	   /**
	    * The name of the metadata: post has second keyword in first sentence
	    *
	    * @static 
	    * @var string
	    */
        static $key2_in_last_sentence_metadata = '_seopressor_key2_last_sentence';
        
	   /**
	    * The name of the metadata: post has third keyword in first sentence
	    *
	    * @static 
	    * @var string
	    */
        static $key3_in_first_sentence_metadata = '_seopressor_key3_first_sentence';
        
	   /**
	    * The name of the metadata: post has third keyword in first sentence
	    *
	    * @static 
	    * @var string
	    */
        static $key3_in_last_sentence_metadata = '_seopressor_key3_last_sentence';
        
	   /**
	    * MetaKey setting: allow_meta_keyword
	    *
	    * @static 
	    * @var string
	    */
        static $allow_meta_keyword_metadata = '_seopressor_allow_meta_keyword';
        
        /**
         * MetaKey setting: og_image
         *
         * @static
         * @var string
         */
        static $og_image = '_seopressor_og_image';
        
        /**
         * MetaKey setting: og_image_use
         *
         * @static
         * @var string
         */
        static $og_image_use = '_seopressor_og_image_use';
        
        /**
         * MetaKey setting: allow_meta_keyword
         *
         * @static
         * @var string
         */
        static $allow_keyword_overriding_in_sentences_metadata = '_seopressor_allow_keyword_overriding_in_sentences';
        
	   /**
	    * MetaKey setting: use_for_meta_keyword
	    * Values can be: seopressor_keywords, tags, categories
	    *
	    * @static 
	    * @var string
	    */
        static $use_for_meta_keyword_metadata = '_seopressor_use_for_meta_keyword';
        
	   /**
	    * MetaDescription setting: allow_meta_description
	    *
	    * @static 
	    * @var string
	    */
        static $allow_meta_description_metadata = '_seopressor_allow_meta_description';
        
	   /**
	    * MetaDescription setting: meta_description
	    *
	    * @static 
	    * @var string
	    */
        static $meta_description_metadata = '_seopressor_meta_description';
        
	   /**
	    * MetaTitle setting: allow_meta_title
	    *
	    * @static 
	    * @var string
	    */
        static $allow_meta_title_metadata = '_seopressor_allow_meta_title';
        
	   /**
	    * MetaTitle setting: meta_title
	    *
	    * @static 
	    * @var string
	    */
        static $meta_title_metadata = '_seopressor_meta_title';
        
        /**
         * update_non_hidden_metadata
         */
        static function update_non_hidden_metadata() {
        	global $wpdb;
        	$table_meta =  $wpdb->postmeta;
        	
        	// Query to check
        	$query = "select meta_key from $table_meta where meta_key='posts_rate_key' limit 1";
        	$exist = $wpdb->get_var($query);
        	// If at least one, mean that the update wasn't done yet
        	if ($exist) { // Else, is Null
        		// Update all meta fields
        		
        		$meta_key_old = 'posts_rate_key';
        		$meta_key_new = '_' . $meta_key_old;
        		$tmp_query = "update $table_meta set meta_key='$meta_key_new' where meta_key='$meta_key_old'";
        		$wpdb->query($tmp_query);
        		
        		$meta_key_old = 'posts_rate_key2';
        		$meta_key_new = '_' . $meta_key_old;
        		$tmp_query = "update $table_meta set meta_key='$meta_key_new' where meta_key='$meta_key_old'";
        		$wpdb->query($tmp_query);
        		
        		$meta_key_old = 'posts_rate_key3';
        		$meta_key_new = '_' . $meta_key_old;
        		$tmp_query = "update $table_meta set meta_key='$meta_key_new' where meta_key='$meta_key_old'";
        		$wpdb->query($tmp_query);
        		
        		// Anything that begins with "google_rich_snippet_" or "seop_grs_"
        		$tmp_query = "update $table_meta set meta_key=CONCAT('_', meta_key) 
        							where meta_key like 'google_rich_snippet_%' or meta_key like 'seop_grs_%'";
        		$wpdb->query($tmp_query);        		
        	}
        }
        
        /*
         * Get permalink even for Draft posts
         * 
         * @param	int	$post_id
         */
        static function get_permalink($post_id) {
        	$post = get_post( $post_id );
        	
	        if (in_array($post->post_status, array('draft', 'pending', 'auto-draft'))) {
			    $my_post = clone $post;
			    $my_post->post_status = 'published';
			    $my_post->post_name = sanitize_title($my_post->post_name ? $my_post->post_name : $my_post->post_title, $my_post->ID);
			    $permalink = get_permalink($my_post);
			} else {
			    $permalink = get_permalink($post_id);
			}
			
			return $permalink;
        }
        
        /**
         * Get the Post Featured Image URL
         * 
         * @param 	int 	$post_id
         * @return 	string 	empty if there is no featured image defined
         */
        static function get_featured_image_url($post_id) {
        	
        	if (!function_exists('get_post_thumbnail_id')) {
        		return '';
        	}
        	
        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) ) ;
        	if ($featured_image) {
        		// Has a featured image defined: get the URL
        		return $featured_image[0];
        	}
        	else {
        		return '';
        	}
        }
        
        /**
         * Update MetaTag: _enable_rich_snippets
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_enable_rich_snippets($post_id,$value) {
        	return update_post_meta($post_id, '_enable_rich_snippets', $value);
        }
        
        /**
         * Get MetaTag: _enable_rich_snippets
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_enable_rich_snippets($post_id) {
        	$to_return = get_post_meta($post_id, '_enable_rich_snippets', TRUE);
        	
        	if ($to_return=='') {
        		// No value yet, so is enabled
        		$to_return = '1';
        	}
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _publish_rich_snippets
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_publish_rich_snippets($post_id,$value) {
        	return update_post_meta($post_id, '_publish_rich_snippets', $value);
        }
        
        /**
         * Get MetaTag: _publish_rich_snippets
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_publish_rich_snippets($post_id) {
        	$to_return = get_post_meta($post_id, '_publish_rich_snippets', TRUE);
        	
        	if ($to_return=='') {
        		// No value yet, so is disabled
        		$to_return = '0';
        	}
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _enable_socialseo_facebook
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_enable_socialseo_facebook($post_id,$value) {
        	return update_post_meta($post_id, '_enable_socialseo_facebook', $value);
        }
        
        /**
         * Get MetaTag: _enable_socialseo_facebook
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_enable_socialseo_facebook($post_id) {
        	$to_return = get_post_meta($post_id, '_enable_socialseo_facebook', TRUE);
        	
        	if ($to_return=='') {
        		// No value yet, so is enabled
        		$to_return = '1';
        	}
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _socialseo_facebook_title
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_socialseo_facebook_title($post_id,$value) {
        	return update_post_meta($post_id, '_socialseo_facebook_title', $value);
        }
        
        /**
         * Update MetaTag: _socialseo_facebook_publisher
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_socialseo_facebook_publisher($post_id,$value) {
        	return update_post_meta($post_id, '_socialseo_facebook_publisher', $value);
        }
        
        /**
         * Update MetaTag: _socialseo_facebook_author
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_socialseo_facebook_author($post_id,$value) {
        	return update_post_meta($post_id, '_socialseo_facebook_author', $value);
        }
        
        /**
         * Get MetaTag: _socialseo_facebook_title
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_socialseo_facebook_title($post_id) {
        	$to_return = get_post_meta($post_id, '_socialseo_facebook_title', TRUE);
        	return $to_return;
        }
        
        /**
         * Get MetaTag: _socialseo_facebook_publisher
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_socialseo_facebook_publisher($post_id) {
        	$to_return = get_post_meta($post_id, '_socialseo_facebook_publisher', TRUE);
        	return $to_return;
        }
        
        /**
         * Get MetaTag: _socialseo_facebook_author
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_socialseo_facebook_author($post_id) {
        	$to_return = get_post_meta($post_id, '_socialseo_facebook_author', TRUE);
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _socialseo_facebook_description
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_socialseo_facebook_description($post_id,$value) {
        	return update_post_meta($post_id, '_socialseo_facebook_description', $value);
        }
        
        /**
         * Get MetaTag: _socialseo_facebook_description
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_socialseo_facebook_description($post_id) {
        	$to_return = get_post_meta($post_id, '_socialseo_facebook_description', TRUE);
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _socialseo_twitter_title
         *
         * @param 	int 	$post_id
         * @param 	string	$value
         *
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_socialseo_twitter_title($post_id,$value) {
        	return update_post_meta($post_id, '_socialseo_twitter_title', $value);
        }
        
        /**
         * Get MetaTag: _socialseo_twitter_title
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_socialseo_twitter_title($post_id) {
        	$to_return = get_post_meta($post_id, '_socialseo_twitter_title', TRUE);
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _socialseo_twitter_description
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_socialseo_twitter_description($post_id,$value) {
        	return update_post_meta($post_id, '_socialseo_twitter_description', $value);
        }
        
        /**
         * Get MetaTag: _socialseo_twitter_description
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_socialseo_twitter_description($post_id) {
        	$to_return = get_post_meta($post_id, '_socialseo_twitter_description', TRUE);
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _dublincore_title
         *
         * @param 	int 	$post_id
         * @param 	string	$value
         *
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_dublincore_title($post_id,$value) {
        	return update_post_meta($post_id, '_dublincore_title', $value);
        }
        
        /**
         * Get MetaTag: _dublincore_title
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_dublincore_title($post_id) {
        	$to_return = get_post_meta($post_id, '_dublincore_title', TRUE);
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _dublincore_description
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_dublincore_description($post_id,$value) {
        	return update_post_meta($post_id, '_dublincore_description', $value);
        }
        
        /**
         * Get MetaTag: _dublincore_description
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_dublincore_description($post_id) {
        	$to_return = get_post_meta($post_id, '_dublincore_description', TRUE);
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _enable_socialseo_twitter
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_enable_socialseo_twitter($post_id,$value) {
        	return update_post_meta($post_id, '_enable_socialseo_twitter', $value);
        }
        
        /**
         * Get MetaTag: _enable_socialseo_twitter
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_enable_socialseo_twitter($post_id) {
        	$to_return = get_post_meta($post_id, '_enable_socialseo_twitter', TRUE);
        	
        	if ($to_return=='') {
        		// No value yet, so is enabled
        		$to_return = '1';
        	}
        	return $to_return;
        }
        
        /**
         * Update MetaTag: _enable_dublincore
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_enable_dublincore($post_id,$value) {
        	return update_post_meta($post_id, '_enable_dublincore', $value);
        }
        
        /**
         * Get MetaTag: _enable_dublincore
         *
         * @param 	int 	$post_id
         * @return 	string
         */
        static function get_meta_enable_dublincore($post_id) {
        	$to_return = get_post_meta($post_id, '_enable_dublincore', TRUE);
        	if ($to_return=='') {
        		// No value yet, so is enabled
        		$to_return = '1';
        	}
        	return $to_return;
        }
        
        /**
         * Update MetaDescription setting: meta_description
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_description($post_id,$value) {
        	return update_post_meta($post_id, self::$meta_description_metadata, $value);
        }
        
        /**
         * Update MetaDescription setting: allow_meta_description
         * 
         * @param 	int 	$post_id
         * @param 	string	$value		Can be '1' or '0'
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_allow_meta_description($post_id,$value) {
        	return update_post_meta($post_id, self::$allow_meta_description_metadata, $value);
        }
        
        /**
         * Update MetaTitle setting: meta_title
         * 
         * @param 	int 	$post_id
         * @param 	string	$value
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_meta_title($post_id,$value) {
        	return update_post_meta($post_id, self::$meta_title_metadata, $value);
        }
        
        /**
         * Update MetaTitle setting: allow_meta_title
         * 
         * @param 	int 	$post_id
         * @param 	string	$value		Can be '1' or '0'
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_allow_meta_title($post_id,$value) {
        	return update_post_meta($post_id, self::$allow_meta_title_metadata, $value);
        }
        
        
        /**
         * Update MetaKey setting: allow_keyword_overriding_in_sentences
         *
         * @param 	int 	$post_id
         * @param 	string	$value		Can be '1' or '0'
         *
         * @return 	bool 	False on failure, true if success.
         */
        static function update_allow_keyword_overriding_in_sentences($post_id,$value) {
        	return update_post_meta($post_id, self::$allow_keyword_overriding_in_sentences_metadata, $value);
        }
        
        /**
         * Update MetaKey setting: $og_image
         *
         * @param 	int 	$post_id
         * @param 	string	$value
         *
         * @return 	bool 	False on failure, true if success.
         */
        static function update_og_image($post_id,$value) {
        	return update_post_meta($post_id, self::$og_image, $value);
        }
        
        /**
         * Update MetaKey setting: $og_image_use
         *
         * @param 	int 	$post_id
         * @param 	string	$value
         *
         * @return 	bool 	False on failure, true if success.
         */
        static function update_og_image_use($post_id,$value) {
        	return update_post_meta($post_id, self::$og_image_use, $value);
        }
        
        /**
         * Get MetaKey setting: $og_image
         *
         * @param 	int 	$post_id
         * @param 	string	$value
         *
         * @return 	bool 	False on failure, true if success.
         */
        static function get_og_image($post_id) {
        	return get_post_meta($post_id, self::$og_image, TRUE);
        }
        
        /**
         * Get MetaKey setting: $og_image_use
         *
         * @param 	int 	$post_id
         * @param 	string	$value
         *
         * @return 	bool 	False on failure, true if success.
         */
        static function get_og_image_use($post_id) {
        	return get_post_meta($post_id, self::$og_image_use, TRUE);
        }
        
        /**
         * Update MetaKey setting: allow_meta_keyword
         * 
         * @param 	int 	$post_id
         * @param 	string	$value		Can be '1' or '0'
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_allow_meta_keyword($post_id,$value) {
        	return update_post_meta($post_id, self::$allow_meta_keyword_metadata, $value);
        }
        
        /**
         * Update MetaKey setting: use_for_meta_keyword
         * 
         * @param 	int 	$post_id
         * @param 	string	$value		values can be: seopressor_keywords, tags, categories
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_use_for_meta_keyword($post_id,$value) {
        	return update_post_meta($post_id, self::$use_for_meta_keyword_metadata, $value);
        }
        
        /**
         * Get MetaKey setting: allow_meta_keyword
         * 
         * @param 	int 	$post_id
         * @return	string
         */
        static function get_allow_meta_keyword($post_id) {
        	$metavalue = get_post_meta($post_id, self::$allow_meta_keyword_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Get MetaKey setting: use_for_meta_keyword
         * 
         * @param 	int 	$post_id
         * @return	string	values can be: seopressor_keywords, tags, categories
         */
        static function get_use_for_meta_keyword($post_id) {
        	$metavalue = get_post_meta($post_id, self::$use_for_meta_keyword_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Get MetaDescription setting: allow_meta_description
         * 
         * @param 	int 	$post_id
         * @return	string
         */
        static function get_allow_meta_description($post_id) {
        	$metavalue = get_post_meta($post_id, self::$allow_meta_description_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Get MetaTitle setting: allow_meta_title
         * 
         * @param 	int 	$post_id
         * @return	string
         */
        static function get_allow_meta_title($post_id) {
        	$metavalue = get_post_meta($post_id, self::$allow_meta_title_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Get MetaDescription setting: allow_keyword_overriding_in_sentences
         *
         * @param 	int 	$post_id
         * @return	string
         */
        static function get_allow_keyword_overriding_in_sentences($post_id) {
        	$metavalue = get_post_meta($post_id, self::$allow_keyword_overriding_in_sentences_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Get MetaDescription setting: meta_description
         * 
         * @param 	int 	$post_id
         * @return	string
         */
        static function get_meta_description($post_id) {
        	$metavalue = get_post_meta($post_id, self::$meta_description_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Get MetaTitle setting: meta_title
         * 
         * @param 	int 	$post_id
         * @return	string
         */
        static function get_meta_title($post_id) {
        	$metavalue = get_post_meta($post_id, self::$meta_title_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Get if user check that the Post has the keyword in first sentence
         * 
         * @param 	int 	$post_id
         * @return	bool	return True if checked by user, else False
         */
        static function setting_key_first_sentence($post_id) {
        	$metavalue = get_post_meta($post_id, self::$key_in_first_sentence_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
         * Update the settings that indicates that user explicitly said that the keyword is in last sentence
         * 
         * @param 	int 	$post_id
         * @param 	bool 	$has_keyword	True if the user checks this, else False
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_setting_key_last_sentence($post_id,$has_keyword) {
        	return update_post_meta($post_id, self::$key_in_last_sentence_metadata, $has_keyword);
        }
        
        /**
         * Update the settings that indicates that user explicitly said that the second keyword is in last sentence
         * 
         * @param 	int 	$post_id
         * @param 	bool 	$has_keyword	True if the user checks this, else False
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_setting_key2_last_sentence($post_id,$has_keyword) {
        	if ($has_keyword) {
        		$has_keyword = '1';
        	}
        	else {
        		$has_keyword = '0';
        	}
        	
        	return update_post_meta($post_id, self::$key2_in_last_sentence_metadata, $has_keyword);
        }
        
        /**
         * Update the settings that indicates that user explicitly said that the third keyword is in last sentence
         * 
         * @param 	int 	$post_id
         * @param 	bool 	$has_keyword	True if the user checks this, else False
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_setting_key3_last_sentence($post_id,$has_keyword) {
        	if ($has_keyword) {
        		$has_keyword = '1';
        	}
        	else {
        		$has_keyword = '0';
        	}
        	
        	return update_post_meta($post_id, self::$key3_in_last_sentence_metadata, $has_keyword);
        }
        
        /**
         * Update the settings that indicates that user explicitly said that the keyword is in first sentence
         * 
         * @param 	int 	$post_id
         * @param 	string 	$has_keyword	'1' if the user checks this, else '0'
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_setting_key_first_sentence($post_id,$has_keyword) {
        	return update_post_meta($post_id, self::$key_in_first_sentence_metadata, $has_keyword);
        }
        
        /**
         * Update the settings that indicates that user explicitly said that the second keyword is in first sentence
         * 
         * @param 	int 	$post_id
         * @param 	bool 	$has_keyword	True if the user checks this, else False
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_setting_key2_first_sentence($post_id,$has_keyword) {
        	if ($has_keyword) {
        		$has_keyword = '1';
        	}
        	else {
        		$has_keyword = '0';
        	}
        	
        	return update_post_meta($post_id, self::$key2_in_first_sentence_metadata, $has_keyword);
        }
        
        /**
         * Update the settings that indicates that user explicitly said that the third keyword is in first sentence
         * 
         * @param 	int 	$post_id
         * @param 	bool 	$has_keyword	True if the user checks this, else False
         * 
         * @return 	bool 	False on failure, true if success.
         */
        static function update_setting_key3_first_sentence($post_id,$has_keyword) {
        	if ($has_keyword) {
        		$has_keyword = '1';
        	}
        	else {
        		$has_keyword = '0';
        	}
        	
        	return update_post_meta($post_id, self::$key3_in_first_sentence_metadata, $has_keyword);
        }
        
        /**
         * Get if user check that the Post has the keyword in last sentence
         * 
         * @param 	int 	$post_id
         * @return	bool	return True if checked by user, else False
         */
        static function setting_key_last_sentence($post_id) {
        	$metavalue = get_post_meta($post_id, self::$key_in_last_sentence_metadata, TRUE);
        	return $metavalue;
        }
        
        /**
		 * Get the common query to perform when the list or the count is requested
		 * 
		 * @param	string	$score
		 * @param	string	$post_title
		 * @param	string	$post_type
		 * @param	string	$keyword
		 * @param	string	$post_date		the format if mm/dd/yyyy
		 * 
		 * @param	string	$not_condition	if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @return 	array	first element is the Query, second is the array with the values for the placeholders in query
		 */
		static public function get_common_query($score='',$post_title='',$post_type='',$keyword='',$post_date=''
												,$not_condition=0) {
		
			global $wpdb;
		   	$table =  $wpdb->posts;
		   	$table_meta =  $wpdb->postmeta;
		   	
		   	// Metadata names
		   	$meta_keyword = self::$keyword_metadata;
		   	$meta_keyword2 = self::$keyword2_metadata;
		   	$meta_keyword3 = self::$keyword3_metadata;
		   	$meta_score = WPPostsRateKeys_Central::$cache_score;
		   	
		   	// From and inner joins
			$query = " from $table 
							left outer join $table_meta meta_keyword on ($table.ID=meta_keyword.post_id and meta_keyword.meta_key='$meta_keyword')
							left outer join $table_meta meta_keyword2 on ($table.ID=meta_keyword2.post_id and meta_keyword2.meta_key='$meta_keyword2')
							left outer join $table_meta meta_keyword3 on ($table.ID=meta_keyword3.post_id and meta_keyword3.meta_key='$meta_keyword3')
							left outer join $table_meta meta_score on ($table.ID=meta_score.post_id and meta_score.meta_key='$meta_score')
							";
			$query_params = array();
			
			// Where conditions
			$where_conditions = array();
			if ($score!='') {
				$where_conditions[] = " meta_score.meta_value like %s";
				$query_params[] = "%$score%";
			}
			if ($post_title!='') {
				$where_conditions[] = " $table.post_title like %s";
				$query_params[] = "%$post_title%";
			}
			if ($post_type!='') {
				$where_conditions[] = " $table.post_type like %s";
				$query_params[] = $post_type;
			}
			if ($keyword!='') {
				$where_conditions[] = "( meta_keyword.meta_value like %s or meta_keyword2.meta_value like %s or meta_keyword3.meta_value like %s )";
				$query_params[] = "%$keyword%";
				$query_params[] = "%$keyword%";
				$query_params[] = "%$keyword%";
			}
			if ($post_date!='') {
				$where_conditions[] = " DATE($table.post_date) like %s";
				// Convert in a format suitable to compare with MySql values
				$post_date = date('Y-m-d',strtotime($post_date));
				$query_params[] = "%$post_date%";
			}
			// Return only the Posts of the type: post and page
			$where_conditions[] = " ($table.post_type='post' || $table.post_type='page')";
			// Return only the Posts with the status: publish, draft, future (Scheduled), pending (Pending Review), private
			$where_conditions[] = " ($table.post_status='publish' || $table.post_status='draft' || $table.post_status='future' || $table.post_status='pending' || $table.post_status='private')";
			
			if (count($where_conditions)!=0) {
				if ($not_condition==1) {
					$query .= ' where not (' . implode(' and ',$where_conditions) . ')';
				}
				else {
					$query .= ' where ' . implode(' and ',$where_conditions);
				}
			}
			
			// Return the Query and the parameters to pass to the Prepare query function
			return array($query,$query_params);
		}
		
		
		/**
		 * Return all items to show
		 * 
		 * @param	double	$score
		 * @param	string	$post_title
		 * @param	string	$post_type
		 * @param	string	$keyword
		 * @param	string	$post_date		the format if mm/dd/yyyy
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @param	array	$fields				if defined, list of fields to return
		 * 											, else all fields will be returned
		 * @param	int		$pagination_offset	if defined, the first row index to get
		 * @param	int		$rows				if defined, define how many rows to return
		 * 											, else all rows will be returned
		 * @param	int		$orderby			if defined, define the field to order by
		 * @param	int		$orderdir			if defined, define order direction
		 * 
		 * @return 	array						of DB filled objects
		 */
		static public function search($score='',$post_title='',$post_type='',$keyword='',$post_date=''
										,$not_condition=0
										,$fields=array(),$pagination_offset='',$rows='',$orderby='',$orderdir='') {
		   	
			global $wpdb;
			$table =  $wpdb->posts;
		   	$table_meta =  $wpdb->postmeta;
									
			// Initialize query
			$query = "select $table.ID";
			
			// Set the fields to return
			if (count($fields)==0) {
				// All fields
				$query = "select $table.*,meta_keyword.meta_value as keyword,meta_keyword2.meta_value as keyword2
							,meta_keyword3.meta_value as keyword3,meta_score.meta_value as score";
			}
			else {
				// Only listed fields and ID
				if (in_array('score',$fields)) {
					$query .= ", meta_score.meta_value as score";
				}
				if (in_array('post_title',$fields)) {
					$query .= ", post_title";
				}
				if (in_array('post_type',$fields)) {
					$query .= ", post_type";
				}
				if (in_array('keyword',$fields)) {
					$query .= ", meta_keyword.meta_value as keyword, meta_keyword2.meta_value as keyword2, meta_keyword3.meta_value as keyword3";
				}
				if (in_array('post_date',$fields)) {
					$query .= ", post_date";
				}
			}
			
			// Add common query
			$query_common_data = self::get_common_query($score,$post_title,$post_type,$keyword,$post_date,$not_condition,$fields);
			$query .= $query_common_data[0];
			
			// Pagination and Order
			if ($orderby!='') {
				if ($orderby=='score') {
					$orderby = 'CAST(meta_score.meta_value AS DECIMAL(10,2))';
				}
				if ($orderby=='keyword') {
					$orderby = 'meta_keyword.meta_value';
				}
				
				$query .= " order by $orderby";
				if ($orderdir=='desc') {
					$query .= " $orderdir";
				}
			}
			if ($rows!='') {
				$query .= " LIMIT $pagination_offset,$rows";
			}
			
			// Prepare and Execute query
			$query = $wpdb->prepare($query,$query_common_data[1]);
			
			$results = $wpdb->get_results($query);
			
			return $results;
									
		}
		
		/**
		 * Get the amount that match the filters
		 * 
		 * @param	double	$score
		 * @param	string	$post_title
		 * @param	string	$post_type
		 * @param	string	$keyword
		 * @param	string	$post_date		the format if mm/dd/yyyy
		 * 
		 * @param	string	$not_condition		if 1, will be applied a NOT to the conditions of the query
		 * 
		 * @param	array	$fields				if defined, list of fields to return
		 * 											, else all fields will be returned
		 * 
		 * @return 	int
		 */
		static public function search_count($score='',$post_title='',$post_type='',$keyword='',$post_date=''
										,$not_condition=0) {
		   	global $wpdb;
			$table =  $wpdb->posts;
		   							
			// Initialize query
			$query = "select count($table.ID)";
			
			// Add common query
			$query_common_data = self::get_common_query($score,$post_title,$post_type,$keyword,$post_date,$not_condition); 
			$query .= $query_common_data[0];
			
			// Prepare and Execute query
			$query = $wpdb->prepare($query,$query_common_data[1]);
			$total_rows = $wpdb->get_var($query);
			
			return $total_rows;
		}
        
        /**
         * Function to the href for link_to_post_page_edit_page
         * 
         * @global	string	$wp_version
         * @param 	int		$post_id
         * @param 	string	$is_post_page	Can be the string: 'page' or 'post'
         * @return 	string
         * @static 
         */
        static function get_link_to_post_page_edit_page($post_id) {
        	
        	$href = get_bloginfo ( 'wpurl' ) . '/wp-admin/post.php?action=edit&post=' . $post_id;
        	
			return $href;
        }
        
        /**
         * Function to the update the "posts_rate_key" postmeta value
         * 
         * @param 	int		$post_id
         * @param 	string	$new_keyword
         * @return 	void
         * @static 
         */
        static function update_keyword($post_id,$new_keyword) {
        	
        	$new_keyword = trim($new_keyword);
        	
        	// Use WP function to update the value
        	update_post_meta($post_id, self::$keyword_metadata, $new_keyword);
        }
        
        /**
         * Function to the update the "posts_rate_key2" postmeta value
         * 
         * @param 	int		$post_id
         * @param 	string	$new_keyword
         * @return 	void
         * @static 
         */
        static function update_keyword2($post_id,$new_keyword) {
        	
        	$new_keyword = trim($new_keyword);
        	
        	// Use WP function to update the value
        	update_post_meta($post_id, self::$keyword2_metadata, $new_keyword);
        }
        
        /**
         * Function to the update the "posts_rate_key3" postmeta value
         * 
         * @param 	int		$post_id
         * @param 	string	$new_keyword
         * @return 	void
         * @static 
         */
        static function update_keyword3($post_id,$new_keyword) {
        	
        	$new_keyword = trim($new_keyword);
        	
        	// Use WP function to update the value
        	update_post_meta($post_id, self::$keyword3_metadata, $new_keyword);
        }
        
        /**
         * Function to the get the "posts_rate_key" postmeta value
         * 
         * @param 	int		$post_id
         * @return 	string
         * @static 
         */
        static function get_keyword($post_id) {
        	
        	// Use WP function to get the value
        	$key = trim(get_post_meta($post_id, self::$keyword_metadata, TRUE));
        	
        	// Return the keyword with blank spaces, to macth only a whole word or phrase
        	return $key;
        }
						
        /**
         * Function to the get the "posts_rate_key2" postmeta value
         * 
         * @param 	int		$post_id
         * @return 	string
         * @static 
         */
        static function get_keyword2($post_id) {
        	
        	// Use WP function to get the value
        	$key = trim(get_post_meta($post_id, self::$keyword2_metadata, TRUE));
        	
        	// Return the keyword with blank spaces, to macth only a whole word or phrase
        	return $key;
        }
						
        /**
         * Function to the get the "posts_rate_key3" postmeta value
         * 
         * @param 	int		$post_id
         * @return 	string
         * @static 
         */
        static function get_keyword3($post_id) {
        	
        	// Use WP function to get the value
        	$key = trim(get_post_meta($post_id, self::$keyword3_metadata, TRUE));
        	
        	// Return the keyword with blank spaces, to macth only a whole word or phrase
        	return $key;
        }
						
        /**
         * Function to get Post title and content from database
         * 
         * @global	object	$wpdb			WP object to access database
         * @param 	int		$post_id
         * @return	array	Of strings, first the title
         */
        static function get_wp_post_title_content($post_id) {
			
        	global $wpdb;
			
			$query = "SELECT post_title,post_content FROM $wpdb->posts where ID = $post_id";
			$post_data = $wpdb->get_row( $query );
			if ($post_data)
				return array($post_data->post_title,$post_data->post_content);
        }
	}
}