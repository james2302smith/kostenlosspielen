<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */

if (include('custom_widgets.php')){
     add_action("widgets_init", "load_custom_widgets");
}
function load_custom_widgets() {
    unregister_widget("WP_Widget_Text");
    register_widget("WP_Widget_Text_Custom");
}
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
	add_custom_image_header( '', 'twentyten_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'twentyten' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'twentyten' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'twentyten' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'twentyten' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'twentyten' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'twentyten' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'twentyten' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */

 function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {

	// Located in the right column.
	register_sidebar( array(
		'name' => __( 'Right Column Widget Area', 'twentyten' ),
		'id' => 'right-widget-area',
		'description' => __( 'The right column widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'twentyten' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>' , 
		'after_widget' => '</div>',
	) );
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/*kostenlosspielen.biz*/
add_filter( 'request', 'my_request_filter' );
function my_request_filter( $query_vars ) {
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }
    return $query_vars;
}
function getCategoryID($input){
	$input=trim(strtolower($input));
	
	if($input=='mahjong'||$input=='magjong'||$input=='majon'||$input=='mahjongg'||$input=='mahjong spiele'||$input=='mahjongg spiele') {$id=104;}
	if($input=='solitär'||$input=='solitär spiele'||$input=='solitaire') {$id=407;}
	if($input=='bubble'||$input=='bubbles'||$input=='bubble spiele'||$input=='bubbles spiele') {$id=397;}
	if($input=='mario'||$input=='super mario'||$input=='mario spiele'||$input=='marios') {$id=75;}
	if($input=='3 gewinnt'||$input=='3 gewinnt spiele'||$input=='3gewinnt'||$input=='drei gewinnt'||$input=='3 gewint'
	||$input=='jewels'||$input=='jewel'||$input=='bejeweled'	) {$id=3237;}
	if($input=='schach'||$input=='schach spiele') {$id=418;}
	if($input=='tetris'||$input=='tetris spiele') {$id=169;}
	if($input=='wimmelbilder'||$input=='wimmel'||$input=='wimmelbild'||$input=='wimmelspiele'||$input=='wimmelbild spiele') {$id=3568;}
	if($input=='unblock'||$input=='unblock me'||$input=='blöcke löschen') {$id=420;}	
	if($input=='fussball'||$input=='fußball') {$id=432;}
	if($input=='kochspiele'||$input=='kochen') {$id=2796;}
	if($input=='action') {$id=385;}
	if($input=='geschicklichkeit'||$input=='geschick') {$id=394;}
	if($input=="karten"||$input=="karten spiele"||$input=="kartenspiele") {$id=404;}
	if($input=="mädchen"){$id=410;}
	if($input=="denken"||$input=="denk"){$id=417;}
	if($input=="rennen"||$input=="rennspiele"){$id=430;}
	if($input=="sport"){$id=431;}
	if($input=="puzzle"){$id=271;}
	if($input=="parken"||$input=="parkspiele"||$input=="auto parken"){$id=399;}
	if($input=="poker"||$input=="pokerspiele"||$input=="poker spiele"){$id=405;}
	if($input=="zuma"||$input=="zuma spiele"){$id=2394;}
	if($input=="golf"||$input=="golf spiele"){$id=437;}
	if($input=="farm"||$input=="farm spiele"||$input=="bauernhof"||$input=="bauernhof spiele"){$id=3894;}
	if($input=="ritter"||$input=="knight") {$id=2263;}
	if($input=="2 spiele"||$input=="2 spieler") {$id=3818;}
	if($input=="rollenspiele"||$input=="rpg") {$id=3923;}
	if($input=="ballerspiele"||$input=="schießen"||$input=="schießspiele"||$input=="schiessen"){$id=389;}
	return $id;
}
function getPostByCategoryNext($cateID){
	global $post;
	$args = array( 'numberposts' => 3, 'offset'=> 3, 'category' => $cateID,  'order'=> 'DESC', 'orderby' => 'post_date' );
	$myposts = get_posts( $args );
	$postText='';
	foreach( $myposts as $post ) {
	setup_postdata($post);
	$postText= $postText.'<div style="clear:both;margin-top:5px;">
				                <div style="float:left;width:70px;padding-left:5px;">
				                <a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'"  ><img src="'.get_post_meta($post->ID, "image", $single = true).'" width="67" height="50" title="'.get_the_title($post->ID).'" alt="'.get_the_title($post->ID).'" /></a>
				                </div>
				                <div style="float:right;width:260px;padding-right:5px;">

				                <div class="theme">
				                    <a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'"  >'.get_the_title($post->ID).'</a>
				                    <div style="clear:both;"></div> 
				                </div>
				                <div class="description_css">'.get_post_meta($post->ID, "intro", $single = true).'</div>
				                </div>
				            </div>'; 
           
	}
	
	return $postText;
}

function getCountByCategory($cateID){
	global $post, $wpdb;
	$sql="SELECT count FROM kostenlosspielen_term_taxonomy WHERE term_id = ".$cateID;
	$result = $wpdb->get_var($sql);
	return $result;
}

function getPostByCategoryTop($cateID){
	global $post, $wpdb;
	$query='SELECT ID, post_title, post_name, f1.meta_value +0 AS viewcount, 
			f2.meta_value as intro, f3.meta_value as image
			FROM kostenlosspielen_posts
			JOIN kostenlosspielen_term_relationships ON 
			( kostenlosspielen_posts.ID = kostenlosspielen_term_relationships.object_id ) 
			JOIN kostenlosspielen_term_taxonomy 
			ON ( kostenlosspielen_term_relationships.term_taxonomy_id = kostenlosspielen_term_taxonomy.term_taxonomy_id ) 
			JOIN kostenlosspielen_terms ON ( kostenlosspielen_terms.term_id = kostenlosspielen_term_taxonomy.term_id ) 
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_terms.term_id =  '.$cateID.'
			AND kostenlosspielen_term_taxonomy.taxonomy =  \'category\'
			AND kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'pvc_views\'	
			AND f2.meta_key =  \'intro\'
			AND f3.meta_key =  \'image\'
			ORDER BY post_date DESC
			LIMIT 0,4'; 
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
	if($count==0 ||$count==1){
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		if($count==0){
		$postText= $postText.'<div class="category_index_item">';
		}else{
			$postText= $postText.'<div class="category_index_item_2">';
		}
		$postText= $postText.'
			<a rel="follow" title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post['image'].'" width="101" height="76" title="'.$post['intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">
			'.$title_text.'
			</a></center>
			<center>'.number_format($post['viewcount'],0,',','.').' x gespielt</center>
		';
	    $postText= $postText.'</div>';
	}else{
		if($count==2){
			$postText= $postText.'<div style="clear:both;"></div><div class="category_index_list">';			
		}
		$postText= $postText.'<div class="index_list_item"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="nofollow">'.$post['post_title'].'</a></div>';
	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
}
function getPostByCategoryTop4($cateID){
	
	global $post, $wpdb;
	$query='SELECT ID, post_title, post_name, f1.meta_value +0 AS viewcount, 
			f2.meta_value as intro, f3.meta_value as image
			FROM kostenlosspielen_posts
			JOIN kostenlosspielen_term_relationships ON 
			( kostenlosspielen_posts.ID = kostenlosspielen_term_relationships.object_id ) 
			JOIN kostenlosspielen_term_taxonomy 
			ON ( kostenlosspielen_term_relationships.term_taxonomy_id = kostenlosspielen_term_taxonomy.term_taxonomy_id ) 
			JOIN kostenlosspielen_terms ON ( kostenlosspielen_terms.term_id = kostenlosspielen_term_taxonomy.term_id ) 
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_terms.term_id =  '.$cateID.'
			AND kostenlosspielen_term_taxonomy.taxonomy =  \'category\'
			AND kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'pvc_views\'	
			AND f2.meta_key =  \'intro\'
			AND f3.meta_key =  \'image\'
			ORDER BY post_date DESC
			LIMIT 0,7'; 
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
	
	if($count<4){
		$postText= $postText.'<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
			<a rel="follow" title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post['image'].'" width="101" height="76" title="'.$post['intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a rel="follow" title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">
			'.$title_text.'
			</a></center>
			<center>'.number_format($post['viewcount'],0,',','.').' x gespielt</center>
		';
	    $postText= $postText.'</div>';
	}else{
		if($count==4){
			$postText= $postText.'<div style="clear:both;"></div><div class="category_index_list">';			
		}
		$postText= $postText.'<div class="index_list_item"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="nofollow" >'.$post['post_title'].'</a></div>';
	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
}
function getPostOptimierung4($cat_ID){
	global $post;		
	global $wp_query, $wpdb;
	$postText='';
	$count=0;

	$query_popular_games = "
	SELECT ID, post_title, post_name, meta_value AS image_url FROM $wpdb->posts
	JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
	JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
	JOIN $wpdb->terms ON($wpdb->terms.term_id = $wpdb->term_taxonomy.term_id)
	JOIN $wpdb->postmeta ON ($wpdb->postmeta.post_id = $wpdb->posts.ID)
	WHERE $wpdb->terms.term_id = '".$cat_ID."'
	AND $wpdb->term_taxonomy.taxonomy = 'category'
	AND $wpdb->posts.post_status = 'publish'
	AND $wpdb->posts.post_type = 'post'
	AND $wpdb->postmeta.meta_key = 'image'
	ORDER BY post_date DESC LIMIT 7";  
	
	$pageposts = $wpdb->get_results($query_popular_games, OBJECT);

	foreach ($pageposts as $post){
	//print_r($post);

		if(strlen($post->post_title)<17){
			$title_text=$post->post_title;	
		}else{
			$title_text=substr($post->post_title,0,15).'..';
		}
	
	if($count<4){
		$postText= $postText.'<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
			<a title="'.$post->post_title.'" href="'.SITE_ROOT_URL.'/'.$post->post_name.'.html"><img src="'.$post->image_url.'" width="101" height="76" title="'.$post->title.'" alt="'.$post->post_title.'" /></a>
			<center><a title="'.$post->post_title.'" href="'.SITE_ROOT_URL.'/'.$post->post_name.'.html">
			'.$title_text.'
			</a></center>
		';
	    $postText= $postText.'</div>';
	}else{
		if($count==4){
			$postText= $postText.'<div style="clear:both;"></div><div class="category_index_list">';			
		}
		$postText= $postText.'<div class="index_list_item"><a title="'.$post->post_title.'" href="'.SITE_ROOT_URL.'/'.$post->post_name.'.html" rel="nofollow" >'.$post->post_title.'</a></div>';
	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
	
}
function getPostByCategoryTopLine4($cateID){
	global $post, $wpdb;
	$query='SELECT ID, post_title, post_name, f1.meta_value +0 AS viewcount, 
			f2.meta_value as intro, f3.meta_value as image
			FROM kostenlosspielen_posts
			JOIN kostenlosspielen_term_relationships ON 
			( kostenlosspielen_posts.ID = kostenlosspielen_term_relationships.object_id ) 
			JOIN kostenlosspielen_term_taxonomy 
			ON ( kostenlosspielen_term_relationships.term_taxonomy_id = kostenlosspielen_term_taxonomy.term_taxonomy_id ) 
			JOIN kostenlosspielen_terms ON ( kostenlosspielen_terms.term_id = kostenlosspielen_term_taxonomy.term_id ) 
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_terms.term_id =  '.$cateID.'
			AND kostenlosspielen_term_taxonomy.taxonomy =  \'category\'
			AND kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'pvc_views\'	
			AND f2.meta_key =  \'intro\'
			AND f3.meta_key =  \'image\'
			ORDER BY post_date DESC
			LIMIT 0,7'; 
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
	
	if($count<4){
		$postText= $postText.'<div class="category_index_item" id="category_index_item_line'.$count.'">';
		$postText= $postText.'
			<a rel="follow" title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post['image'].'" width="101" height="76" title="'.$post['intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a rel="follow" title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">
			'.$title_text.'
			</a></center>
			<center>'.number_format($post['viewcount'],0,',','.').' x gespielt</center>
		';
	    $postText= $postText.'</div>';
	}else{
		if($count==4){
			$postText= $postText.'<div style="clear:both;"></div><div class="category_index_list">';			
		}
		$postText= $postText.'<div class="index_list_item"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="nofollow" >'.$post['post_title'].'</a></div>';
	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
}
function getPostByCategoryTop6($cateID){
	global $post, $wpdb;
	$query='SELECT ID, post_title, post_name, f1.meta_value +0 AS viewcount, 
			f2.meta_value as intro, f3.meta_value as image
			FROM kostenlosspielen_posts
			JOIN kostenlosspielen_term_relationships ON 
			( kostenlosspielen_posts.ID = kostenlosspielen_term_relationships.object_id ) 
			JOIN kostenlosspielen_term_taxonomy 
			ON ( kostenlosspielen_term_relationships.term_taxonomy_id = kostenlosspielen_term_taxonomy.term_taxonomy_id ) 
			JOIN kostenlosspielen_terms ON ( kostenlosspielen_terms.term_id = kostenlosspielen_term_taxonomy.term_id ) 
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_terms.term_id =  '.$cateID.'
			AND kostenlosspielen_term_taxonomy.taxonomy =  \'category\'
			AND kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'pvc_views\'	
			AND f2.meta_key =  \'intro\'
			AND f3.meta_key =  \'image\'
			ORDER BY post_date DESC
			LIMIT 0,9'; 
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
	if($count<6){
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
			
		$postText= $postText.'<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post['image'].'" width="101" height="76" title="'.$post['intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" >
			'.$title_text.'
			</a></center>
			<center>'.number_format($post['viewcount'],0,',','.').' x gespielt</center>
		';
	    $postText= $postText.'</div>';
	}else{
		if($count==6){
			$postText= $postText.'<div style="clear:both;"></div><div class="category_index_list">';			
		}
		$postText= $postText.'<div class="index_list_item"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="nofollow" >'.$post['post_title'].'</a></div>';
	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
}


function getPostByCategory($cateID){
	global $post;
	$args = array( 'numberposts' => 5, 'offset'=> 0, 'category' => $cateID, 'order'=> 'DESC', 'orderby' => 'post_date' );
	$myposts = get_posts( $args );
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
	setup_postdata($post);
	if($count==0 ||$count==1||$count==2){
		if($count==0){
		$postText= $postText.'<div class="index_item">';
		}elseif($count==1){
			$postText= $postText.'<div class="index_item_2">';
		}else{
			$postText= $postText.'<div class="index_item_3">';
		}
		
		$postText= $postText.'<div class="index_item_thumbs">
			<a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'" ><img src="'.get_post_meta($post->ID, "image", $single = true).'" width="101" height="76" title="'.get_the_title($post->ID).'" alt="'.get_the_title($post->ID).'" /></a>
			<center><a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'" >'.get_the_title($post->ID).'</a></center>
		</div>
		<div class="index_item_text">'.get_post_meta($post->ID, "intro", $single = true).'</div>		
		';
	    $postText= $postText.'</div>';
	}else{
		if($count==3){
			$postText= $postText.'<div class="index_list">';			
		}

		$postText= $postText.'<div class="index_list_item"><a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'" rel="nofollow" >'.get_the_title($post->ID).'</a></div>';

	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
}
function getPostByCategoryIndex($cateID){
	global $post;
	$args = array( 'numberposts' => 5, 'offset'=> 0, 'category' => $cateID, 'order'=> 'DESC', 'orderby' => 'post_date' );
	$myposts = get_posts( $args );
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
	setup_postdata($post);
	if($count==0 ||$count==1||$count==2){
		if($count==0){
		$postText= $postText.'<div class="index_item">';
		}elseif($count==1){
			$postText= $postText.'<div class="index_item_2">';
		}elseif($count==2){
			$postText= $postText.'<div class="index_item_2">';
		}
		$postText= $postText.'<div class="index_item_thumbs">
			<a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'"  ><img src="'.get_post_meta($post->ID, "image", $single = true).'" width="101" height="76" title="'.get_the_title($post->ID).'" alt="'.get_the_title($post->ID).'" /></a>
			<center><a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'"  >'.get_the_title($post->ID).'</a></center>
		</div>';
		//echo get_post_meta($post->ID, "intro", $single = true);
		if((get_post_meta($post->ID, "intro_home", $single = true)==NULL)||(get_post_meta($post->ID, "intro_home", $single = true)=='')){
			$postText= $postText.'<div class="index_item_text">'.get_post_meta($post->ID, "intro", $single = true).'</div>';			
		}else{
			$postText= $postText.'<div class="index_item_text">'.get_post_meta($post->ID, "intro_home", $single = true).'</div>';
		}
				
	    $postText= $postText.'</div>';
	}else{
		if($count==3){
			$postText= $postText.'<div class="index_list_index">';			
		}
		$postText= $postText.'<div class="index_list_item"><a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'" rel="nofollow" >'.get_the_title($post->ID).'</a></div>';
	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
}
function getPostByCategoryHomeAJAX($cateID){
	global $post, $wpdb;
	$query='SELECT * FROM kostenlosspielen_posts WHERE category1 =  '.$cateID.'
			AND post_status =  \'publish\'	AND post_type =  \'post\'
			ORDER BY post_date DESC	LIMIT 0,3'; 
			//echo $query;
			//if(current_user_can( 'manage_options' )) {		echo $query;	}
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	$postText= $postText.'<div id="ajaxData'.$cateID.'">';
	$postText= $postText.'<div id="loading'.$cateID.'"></div>'; 
	foreach( $myposts as $post ) {
	//print_r($post);
		if($count==0){
		$postText= $postText.'<div class="index_item">';
		}elseif($count==1){
			$postText= $postText.'<div class="index_item_2">';
		}elseif($count==2){
			$postText= $postText.'<div class="index_item_2">';
		}
		$post_image=$post['game_image'];
		$postText= $postText.'<div class="index_item_thumbs">
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" title="'.$post['post_title'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">'.$post['post_title'].'</a>';

		$postText= $postText.'</center>
		</div>';
	    $postText= $postText.'</div>';
		$count++; 
	}
	$postText= $postText.'<div class="index_list_index">Seite: ';	
	$max=5;
	for($i=1;$i<=$max;$i++){
		if($i==1){
			$postText= $postText.'<a rel="nofollow" id="page1" href="javascript:void(0);" class="pageAjax" name="'.$cateID.'-1"><strong>1</strong></a> &nbsp;';		
		}else{
			$postText= $postText.'<a rel="nofollow" id="page'.$i.'" href="javascript:void(0);" class="pageAjax" name="'.$cateID.'-'.$i.'">'.$i.'</a> &nbsp;';
		}
	}
	$postText= $postText.'<a rel="nofollow" href="'.get_category_link($cateID).'" class="twodot">..</a>';
	$postText= $postText.'</div></div>'; //div of ajaxData
	
	return $postText;
}   
wp_enqueue_script('jquery');
function getPostByCategoryHome($cateID){
	global $post, $wpdb;
	
	$query='SELECT * FROM kostenlosspielen_posts WHERE category1 =  '.$cateID.'
			AND post_status =  \'publish\'	AND post_type =  \'post\'
			ORDER BY game_views DESC LIMIT 0,4'; 
			//echo $query;			
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText= $postText.'<div id="ajaxData'.$cateID.'">';
	$postText= $postText.'	<div id="loading'.$cateID.'"></div>'; 	
	$count=0;
	$postText=$postText.'	<div id="cateSingleCSS'.$cateID.'"></div>
							<div id="category'.$cateID.'">';
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		$post_image=$post['game_image'];
		$postText= $postText.'	<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
									<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
									<center style="margin-top:3px;"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" >'.$title_text.'</a></center>';
	    $postText= $postText.'	</div>';
	$count++; 
	}
	$postText=$postText.'		<div class="index_mehr_left"><strong>Seite</strong>: ';
	$max=3;
	
	for($i=1;$i<=$max;$i++){
		if($i==1){
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="pageAjax"><strong><u>'.$i.'</u></strong></a> &nbsp;';	
		}else{
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="pageAjax">'.$i.'</a> &nbsp;';	
		}
	}
	$category_url=get_category_link($cateID);
	$postText=$postText.'		<a rel="nofollow" href="'.$category_url.'" class="twodot">..</a>';
    $postText=$postText.'		</div>
	<div class="index_mehr_cate"><a rel="nofollow" href="'.$category_url.'">Mehr</a></div>
	</div>'; 		//div of category
	$postText=$postText.'</div>'; //div all
	return $postText;
}

function getPostByCategoryTop4AJAX($cateID){
	global $wpdb;
	$query='SELECT * FROM kostenlosspielen_posts
			WHERE category2 =  '.$cateID.'
			AND post_status =  \'publish\'
			AND post_type =  \'post\'
			ORDER BY game_views DESC
			LIMIT 0,4'; 
	//if(current_user_can( 'manage_options' )) {		echo $query;	}			
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	$postText=$postText.'<div id="cateSingleCSS'.$cateID.'"></div><div id="category'.$cateID.'">';
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		$post_image=$post['game_image'];
		$postText= $postText.'<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
			<center class="category_text"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" >'.$title_text.'</a></center>
		';
	    $postText= $postText.'</div>';
	$count++; 
	}
	$postText=$postText.'<div class="index_mehr_left"><strong>Seite</strong>: ';
	$max=3;
	if($cateID==435||$cateID==406||$cateID==3924||$cateID==409||$cateID==418) {$max=2;}
	if($cateID==1664||$cateID==1264||$cateID==436) {$max=1;}
	for($i=1;$i<=$max;$i++){
		if($i==1){
		$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax4"><strong><u>'.$i.'</u></strong></a> &nbsp;';	
		}else{
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax4">'.$i.'</a> &nbsp;';		
		}
	}
	$category_url=get_category_link($cateID);
	$postText=$postText.'<a rel="nofollow" href="'.$category_url.'" class="twodot">..</a>';
    $postText=$postText.'</div><div class="index_mehr_cate"><a rel="nofollow" href="'.$category_url.'">Mehr</a></div></div>';
	return $postText;
}
function getPostByCategoryTop6AJAX($cateID){
	global $wpdb;
	$query='SELECT * FROM kostenlosspielen_posts
			WHERE category2 =  '.$cateID.'
			AND post_status =  \'publish\'
			AND post_type =  \'post\'
			ORDER BY post_date DESC
			LIMIT 0,6'; 
	//if(current_user_can( 'manage_options' )) {		echo $query;	}			
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	$postText=$postText.'<div id="cateSingleCSS'.$cateID.'"></div><div id="category'.$cateID.'">';
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		$post_image=$post['game_image'];
		$postText= $postText.'<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
			<center class="category_text"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" >'.$title_text.'</a></center>
		';
	    $postText= $postText.'</div>';
	$count++; 
	}
	$postText=$postText.'<div class="index_mehr_left"><strong>Seite</strong>: ';
	$max=3;
	if($cateID==435||$cateID==406||$cateID==3924||$cateID==409||$cateID==418) {$max=2;}
	if($cateID==1664||$cateID==1264||$cateID==436) {$max=1;}
	for($i=1;$i<=$max;$i++){
		if($i==1){
		$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax"><strong><u>'.$i.'</u></strong></a> &nbsp;';	
		}else{
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax">'.$i.'</a> &nbsp;';		
		}
	}
	$category_url=get_category_link($cateID);
	$postText=$postText.'<a rel="nofollow" href="'.$category_url.'" class="twodot">..</a>';
    $postText=$postText.'</div><div class="index_mehr_cate"><a rel="nofollow" href="'.$category_url.'">Mehr</a></div></div>';
	return $postText;
}
function showTopPopularGames(){
	$pageid = $_POST['pageid'];
	global $post, $wpdb;
	$start=($pageid-1)*10;
	$returnText=
			'<div>
				<h2 style="float:left;width: 200px;">Populäre Spiele</h2>
				<div class="top-popular-num-general">';
				
				for($i=1;$i<6;$i++){
					if($i==$pageid){
						$returnText=$returnText. '<a rel="nofollow" href="javascript:void(0);" name="'.$i.'" class="top-popular-post-page"><strong>'.$i.'</strong></a>&nbsp;';
					}else{
						$returnText=$returnText. '<a rel="nofollow" href="javascript:void(0);" name="'.$i.'" class="top-popular-post-page">'.$i.'</a>&nbsp;';
					}
				}
	$returnText=$returnText.'			
				</div>			
				<div class="top-content-games" style="clear:both;">';
						$query='SELECT * FROM kostenlosspielen_posts
								WHERE kostenlosspielen_posts.post_status =  \'publish\'
								AND kostenlosspielen_posts.post_type =  \'post\'
								ORDER BY game_views							
								DESC LIMIT '.$start.',10'; 
						$pageposts = $wpdb->get_results($query, ARRAY_A);
						foreach ($pageposts as $post){
						$post_image=$post['game_image'];
	$returnText=$returnText.'					
						<div class="top-popular-item">
						<div class="ArrangeID_waiting"></div>
						<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" alt="kostenlos spielen '. $post['post_title'].'" title="'.$post['game_intro'].'"/>
						<p>'.$post['post_title'].'</p>
						</a>
						</div>';
					   } 
	$returnText=$returnText.'			</div>
			</div>';	
	

				$returnText=$returnText.'<script type="text/javascript">
				    jQuery(document).ready(function($){
				        $(\'.top-popular-post-page\').click(function(){
                            var pageid = $(this).attr("name");
                            $.ajax({
                                type: \'POST\',
                                url: \''.SITE_ROOT_URL.'/wp-admin/admin-ajax.php\',
                                data: {"action": "showTopPopularGames", "pageid":pageid},
                                beforeSend: function() {$(".ArrangeID_waiting").fadeIn(\'fast\');},
                                success: function(data){
                                    $(".ArrangeID_waiting").fadeOut(\'slow\');
                                    $("#top-popular-post").html(data);
                                }
                            });
                            return false;
                        });
				    });
				</script>';
				
	echo $returnText;
	die();
}
function showSimilarGames(){
	$instruction = $_POST['instruction'];
	$categoryid = $_POST['categoryid'];
	$num = $_POST['num'];
	global $post, $wpdb;
	if($instruction=='meist'){
			$returnText=$returnText.'<div class="ArrangeID_waiting"></div>
			<div style="margin:5px 10px 7px 5px;"><a rel="nofollow" href="javascript:void(0);" name="meist-'.$categoryid.'-'.$num.'" class="similar-games"><strong>Meist gespielt</strong></a> | <a rel="nofollow" href="javascript:void(0);" name="best-'.$categoryid.'-'.$num.'" class="similar-games">Best bewertete</a></div>';
			$query = "SELECT *	FROM kostenlosspielen_posts
			WHERE post_status = 'publish' AND post_type='post'
			AND category2 =".$categoryid."
			ORDER BY game_views DESC LIMIT $num";
			//echo $query;
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			foreach ($pageposts as $post){
			$post_image=replaceImages(get_post_meta($post['ID'], 'image', true),'75');
			$post_intro=get_post_meta($post['ID'], 'intro_home', true);
				
				   $returnText=$returnText.'<div>
				            <div class="widget_games_left"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank"><img src="'.$post_image.'" width="75" height="56" alt="'.$post['post_title'].'" title="'.$post_intro.'" /></a></div>
				            <div class="widget_games_right">
					            <div><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank">'.$post['post_title'].'</a></div>
					            <div style="margin-bottom:5px;">'.number_format($post['game_views'],0,',','.').' x gespielt</div>
			                </div>
				         </div>
				         <div style="clear:both;"></div>';
			}
	}elseif($instruction=='best'){
			$returnText=$returnText.'<div class="ArrangeID_waiting"></div>
			<div style="margin:5px 10px 7px 5px;"><a rel="nofollow" href="javascript:void(0);" name="meist-'.$categoryid.'-'.$num.'" class="similar-games">Meist gespielt</a> | <a rel="nofollow" href="javascript:void(0);" name="best-'.$categoryid.'-'.$num.'" class="similar-games"><strong>Best bewertete</strong></a></div>';
			
			$query="SELECT DISTINCT kostenlosspielen_posts.*,(t1.meta_value+0.00) AS ratings_average, (t2.meta_value+0.00) AS ratings_users
			FROM kostenlosspielen_posts JOIN kostenlosspielen_postmeta AS t1 ON t1.post_id = kostenlosspielen_posts.ID 
			JOIN kostenlosspielen_postmeta AS t2 ON t1.post_id = t2.post_id 
			WHERE kostenlosspielen_posts.post_status = 'publish' AND kostenlosspielen_posts.post_type='post'
			AND kostenlosspielen_posts.category2 =".$categoryid." AND t1.meta_key = 'ratings_average' 
			AND t2.meta_key = 'ratings_users' AND t2.meta_value >= 2 
			ORDER BY ratings_average DESC, ratings_users DESC LIMIT $num";	
			//echo $query;
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			//print_r($pageposts);
			foreach ($pageposts as $post){
			$post_image=replaceImages($post['game_image'],'75');
			$post_ratings_average = floatval($post['ratings_average']);
		    $returnText=$returnText.'<div>
				            <div class="widget_games_left"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank">
							<img src="'.$post_image.'" width="75" height="56" alt="'.$post['post_title'].'" title="'.$post['game_intro'].'" /></a></div>
				            <div class="widget_games_right">
					            <div><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" target="_blank">'.$post['post_title'].'</a></div>
					            <div>'.$post_ratings_average.' / 10 Punkte</div>
								<div style="margin-bottom:5px;">'.number_format($post['game_views'],0,',','.').' x gespielt</div>
			                </div>
				         </div>
				         <div style="clear:both;"></div>';
			}
			
			//$returnText='test vinh vinh';

	}
	$returnText=$returnText.'<script type="text/javascript">
	            jQuery(document).ready(function($){
	                $(\'.similar-games\').click(function(){
					    var message = $(this).attr("name");
					    var word=message.split("-");
					    var instruction=word[0];
					    var categoryid=word[1];
					    var num=word[2];
					    $.ajax({
					        type: \'POST\',
					        url: \''.SITE_ROOT_URL.'/wp-admin/admin-ajax.php\',
					        data: {"action": "showSimilarGames", "instruction":instruction, "categoryid":categoryid, "num":num},
					        beforeSend: function() {$(".ArrangeID_waiting").fadeIn(\'fast\');},
					        success: function(data){
					            $(".ArrangeID_waiting").fadeOut(\'slow\');
					            $("#similar-gamesid").html(data);
					        }
					    });
					    return false;
					});
	            });
				</script>';
	//ob_clean();
	echo $returnText;
	die();
}
function showCategoryArrange(){
	$type = $_POST['type'];
	$cat_ID = $_POST['cateid'];
	global $post, $wpdb;
	if($type=='new'){
		 $returnText='<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-view" class="categoryArrange">Meist gespielte Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-new" class="categoryArrange" style="text-decoration:none;"><strong>Am neuesten Spiele</strong></a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-best" class="categoryArrange">Best bewertete Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-vote" class="categoryArrange">Meist bewertete Spiele</a>
		    	  </div><div class="ArrangeID_waiting_category"></div>';
	$query='SELECT * FROM kostenlosspielen_posts
			WHERE kostenlosspielen_posts.category2='.$cat_ID.'
			AND kostenlosspielen_posts.post_status =  "publish"
			AND kostenlosspielen_posts.post_type =  "post"
			ORDER BY post_date DESC'; 
				  
	}elseif($type=='view'){
		 $returnText='<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-view" class="categoryArrange" style="text-decoration:none;"><strong>Meist gespielte Spiele</strong></a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-new" class="categoryArrange">Am neuesten Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-best" class="categoryArrange">Best bewertete Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-vote" class="categoryArrange">Meist bewertete Spiele</a>
		    	  </div><div class="ArrangeID_waiting_category"></div>';
		$query="SELECT * FROM kostenlosspielen_posts wposts	WHERE post_status = 'publish' AND post_type='post' AND wposts.category2=".$cat_ID." 
			ORDER BY game_views DESC";
	}elseif($type=='best'){
		 $returnText='<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-view" class="categoryArrange">Meist gespielte Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-new" class="categoryArrange">Am neuesten Spiele</a>
					 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-best" class="categoryArrange" style="text-decoration:none;"><strong>Best bewertete Spiele</strong></a>					 
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-vote" class="categoryArrange">Meist bewertete Spiele</a>
		    	  </div><div class="ArrangeID_waiting_category"></div>';
			$query="SELECT DISTINCT kostenlosspielen_posts.*, (t1.meta_value+0.00) AS ratings_average, 			(t2.meta_value+0.00) AS ratings_users
			FROM kostenlosspielen_posts JOIN kostenlosspielen_postmeta AS t1 ON t1.post_id = kostenlosspielen_posts.ID 
			JOIN kostenlosspielen_postmeta AS t2 ON t1.post_id = t2.post_id 
			WHERE t1.meta_key = 'ratings_average' AND t2.meta_key = 'ratings_users' 
			AND kostenlosspielen_posts.post_status = 'publish' 
			AND kostenlosspielen_posts.post_type = 'post' 
			AND kostenlosspielen_posts.category2 = ".$cat_ID." 
			AND t2.meta_value >= 1
			ORDER BY ratings_average DESC, ratings_users DESC";
	}elseif($type=='vote'){
		 $returnText='<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-view" class="categoryArrange">Meist gespielte Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-new" class="categoryArrange">Am neuesten Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-best" class="categoryArrange">Best bewertete Spiele</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="'.$cat_ID.'-vote" class="categoryArrange" style="text-decoration:none;"><strong>Meist bewertete Spiele</strong></a>
		    	  </div><div class="ArrangeID_waiting_category"></div>';
		$query='SELECT DISTINCT kostenlosspielen_posts.*, (f4.meta_value+0.00) as ratings_users
			FROM kostenlosspielen_posts	JOIN kostenlosspielen_postmeta f4 ON ( f4.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_posts.category2='.$cat_ID.'
			AND kostenlosspielen_posts.post_status =  \'publish\' 
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f4.meta_key =  \'ratings_users\' ORDER BY ratings_users DESC'; 
	}
			//echo $query;
	$counter=0;
	$returnText=$returnText.'<div class="category_list">';      					

	$pageposts = $wpdb->get_results($query, ARRAY_A);

	foreach ($pageposts as $post):
			$returnText=$returnText.'<div class="category2_game_item">      					
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">
			<img style="border:1px solid #E9E3E3;" src="'.$post['game_image'].'" width="120" height="90" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
			<div class="category2_game_item_text">
				<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">';
			if(strlen($post['post_title'])<22){
					$returnText=$returnText.$post['post_title'];		
				}else{
					$returnText=$returnText.substr($post['post_title'],0,20).'..';
				}
				$returnText=$returnText.'</a></center>
				</div>
			<div class="category2_game_item_info">';
			if($type=='new'){
				$returnText=$returnText.'Online seit:'.mysql2date('d/m/Y', $post['post_date']);
			}elseif($type=='view'){
				$returnText=$returnText.number_format($post['game_views'],0,',','.').' x gespielt';
			}elseif($type=='best'){
				$returnText=$returnText.$post['ratings_average'].'/10 Punkte';
			}elseif($type=='vote'){
				$returnText=$returnText.$post['ratings_users'].' x bewertet';
			}
			$returnText=$returnText.'</div></div>	';
		
	endforeach;
	$returnText=$returnText.'<div style="clear:both;"></div></div>';
	$returnText= $returnText.'				<script type="text/javascript">
	            jQuery(document).ready(function($){
	                $(\'.categoryArrange\').click(function(){
					    var message = $(this).attr("name");
					    var word=message.split("-");
					    var cateid=word[0];
					    var type=word[1];
					    $.ajax({
					        type: \'POST\',
					        url: \''.SITE_ROOT_URL.'/wp-admin/admin-ajax.php\',
					        data: {"action": "showCategoryArrange", "cateid":cateid, "type":type},
					        beforeSend: function() {$(".ArrangeID_waiting_category").fadeIn(\'fast\');},
					        success: function(data){
					            $(".ArrangeID_waiting_category").fadeOut(\'slow\');
					            $("#categoryArrangeID-"+cateid).html(data);
					        }
                        });
					    return false;
					});
	            });
	            </script>
';
	echo $returnText;
	die();
	
	
}
function showAjaxAction(){
	$page = $_POST['page'];
	$cateID = $_POST['cateid'];
	global $post, $wpdb;
	$start=($page-1)*4;
	$query='SELECT * FROM kostenlosspielen_posts WHERE category1 =  '.$cateID.'
			AND post_status =  \'publish\' AND post_type =  \'post\' 
			ORDER BY game_views DESC LIMIT '.$start.',4'; 
			//echo $query;
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$returnText='';
	$count=0;
	$returnText= $returnText.'<div id="ajaxData'.$cateID.'">';
	$returnText= $returnText.'<div id="loading'.$cateID.'"></div>'; 
	foreach( $myposts as $post ) {				
	$post_image=$post['game_image'];
if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
	$returnText= $returnText.'	<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$returnText= $returnText.'
									<a title="'.$title_text.'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" title="'.$post['game_intro'].'" alt="'.$title_text.'" /></a>
									<center style="margin-top:3px;"><a title="'.$title_text.'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" >'.$title_text.'</a></center>';
	    $returnText= $returnText.'	</div>';		

		$count++; 
	}
	$returnText= $returnText.'<div class="index_list_index">Seite: ';		
	$max=3;
	for($i=1;$i<=$max;$i++){
		if($i==$page){
			$returnText= $returnText.'<a rel="nofollow" id="page'.$i.'" href="javascript:void(0);" class="pageAjax" name="'.$cateID.'-'.$i.'"><strong>'.$i.'</strong></a> &nbsp;';
		}else{
			$returnText= $returnText.'<a rel="nofollow" id="page'.$i.'" href="javascript:void(0);" class="pageAjax" name="'.$cateID.'-'.$i.'">'.$i.'</a> &nbsp;';
		}
	}
	$returnText= $returnText.'<a rel="nofollow" href="'.get_category_link($cateID).'" class="twodot">..</a>';
	$returnText= $returnText.'</div></div>'; //div of ajaxData
	
		$returnText= $returnText.'<script type="text/javascript">
		                jQuery(document).ready(function($){
		                    $(\'.pageAjax\').click(function(){
							    var message = $(this).attr("name");
							    var word=message.split("-");
							    var cateid=word[0];
							    var id=word[1];
							    $.ajax({
							        type: "POST",
							        url: "wp-admin/admin-ajax.php",
							        data: {"action": "showAjaxAction", "page":id, "cateid":cateid},
							        beforeSend: function() {$("#loading"+cateid).fadeIn("fast");},
							        success: function(data){
							            $("#loading"+cateid).fadeOut("slow");
							            $("#ajaxData"+cateid).html(data);
							        }
							    });
							    return false;
							});
		                });
					</script>
	';
	
	echo $returnText;
	die();
}
function showAjaxCategory() {
	$page = $_POST['page'];
	$cateID = $_POST['cateid'];
	global $post, $wpdb;
	$start=($page-1)*6;
	$query='SELECT DISTINCT * FROM kostenlosspielen_posts
			WHERE category2 = '.$cateID.' AND post_status =  \'publish\'
			AND post_type =  \'post\' ORDER BY post_date DESC LIMIT '.$start.',6'; 
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	$postText=$postText.'<div id="category'.$cateID.'">';
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		$post_image=$post['game_image'];
		$postText= $postText.'<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" >
			'.$title_text.'
			</a></center>
		';
	    $postText= $postText.'</div>';
	$count++; 
	}
	if($cateID!=1264){
		$postText=$postText.'<div class="index_mehr_left">';
	}else{
		$postText=$postText.'<div class="index_mehr_left"><strong>Seite</strong>: ';
	}
	$max=3;
	if($cateID==435||$cateID==406||$cateID==3924||$cateID==409||$cateID==418) {$max=2;}
	if($cateID==1664||$cateID==1264||$cateID==436) {$max=1;}

	for($i=1;$i<=$max;$i++){
		if($i==$page){
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax"><strong><u>'.$i.'</u></strong></a> &nbsp;';
		}else{
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax">'.$i.'</a> &nbsp;';	
		}
	}
	$category_url=get_category_link($cateID);
	$postText=$postText.'<a rel="nofollow" href="'.$category_url.'" class="twodot">..</a>';
    $postText=$postText.'</div><div class="index_mehr_cate"><a href="'.$category_url.'" rel="nofollow">Mehr</a></div></div>';
	$postText=$postText.'<script type="text/javascript">
	            jQuery(document).ready(function($){
	                $(\'.singleCateAjax\').click(function(){
					    var message = $(this).attr("name");
					    var word=message.split("-");
					    var cateid=word[0];
					    var id=word[1];
					    $.ajax({
					        type: \'POST\',
					        url: \''.SITE_ROOT_URL.'/wp-admin/admin-ajax.php\',
					        data: {"action": "showAjaxCategory", "page":id, "cateid":cateid},
					        beforeSend: function() {$("#cateSingleCSS"+cateid).fadeIn(\'fast\');},
					        success: function(data){
					            $("#cateSingleCSS"+cateid).fadeOut(\'slow\');
					            $("#category"+cateid).html(data);
					        }
                        });
					    return false;
					});
	            });
				</script>
';				
	echo $postText;
	die();
}
function showAjaxCategory4() {
	$page = $_POST['page'];
	$cateID = $_POST['cateid'];
	global $post, $wpdb;
	$start=($page-1)*4;
	$query='SELECT DISTINCT * FROM kostenlosspielen_posts
			WHERE category2 = '.$cateID.' AND post_status =  \'publish\'
			AND post_type =  \'post\' ORDER BY game_views DESC LIMIT '.$start.',4'; 
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	$postText=$postText.'<div id="category'.$cateID.'">';
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		$post_image=$post['game_image'];
		$postText= $postText.'<div class="category_index_item" id="category_index_item_top'.$count.'">';
		$postText= $postText.'
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="134" height="100" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" >
			'.$title_text.'
			</a></center>
		';
	    $postText= $postText.'</div>';
	$count++; 
	}
	if($cateID!=1264){
		$postText=$postText.'<div class="index_mehr_left">';
	}else{
		$postText=$postText.'<div class="index_mehr_left"><strong>Seite</strong>: ';
	}
	$max=3;
	if($cateID==435||$cateID==406||$cateID==3924||$cateID==409||$cateID==418) {$max=2;}
	if($cateID==1664||$cateID==1264||$cateID==436) {$max=1;}

	for($i=1;$i<=$max;$i++){
		if($i==$page){
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax4"><strong><u>'.$i.'</u></strong></a> &nbsp;';
		}else{
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="singleCateAjax4">'.$i.'</a> &nbsp;';	
		}
	}
	$category_url=get_category_link($cateID);
	$postText=$postText.'<a rel="nofollow" href="'.$category_url.'" class="twodot">..</a>';
    $postText=$postText.'</div><div class="index_mehr_cate"><a href="'.$category_url.'" rel="nofollow">Mehr</a></div></div>';
	$postText=$postText.'<script type="text/javascript">
	            jQuery(document).ready(function($){
	                $(\'.singleCateAjax4\').click(function(){
					    var message = $(this).attr("name");
					    var word=message.split("-");
					    var cateid=word[0];
					    var id=word[1];
					    $.ajax({
					        type: \'POST\',
					        url: \''.SITE_ROOT_URL.'/wp-admin/admin-ajax.php\',
					        data: {"action": "showAjaxCategory4", "page":id, "cateid":cateid},
					        beforeSend: function() {$("#cateSingleCSS"+cateid).fadeIn(\'fast\');},
					        success: function(data){
					            $("#cateSingleCSS"+cateid).fadeOut(\'slow\');
					            $("#category"+cateid).html(data);
					        }
                        });
					    return false;
					});
	            });
				</script>
';				
	echo $postText;
	die();
}

add_action('wp_ajax_showAjaxCategory', 'showAjaxCategory');
add_action('wp_ajax_nopriv_showAjaxCategory', 'showAjaxCategory');
add_action('wp_ajax_showAjaxCategory4', 'showAjaxCategory4');
add_action('wp_ajax_nopriv_showAjaxCategory4', 'showAjaxCategory4');
add_action('wp_ajax_showAjaxAction', 'showAjaxAction');
add_action('wp_ajax_nopriv_showAjaxAction', 'showAjaxAction');
add_action('wp_ajax_showCategoryArrange', 'showCategoryArrange');
add_action('wp_ajax_nopriv_showCategoryArrange', 'showCategoryArrange');
add_action('wp_ajax_showTopPopularGames', 'showTopPopularGames');
add_action('wp_ajax_nopriv_showTopPopularGames', 'showTopPopularGames');
add_action('wp_ajax_showSimilarGames', 'showSimilarGames');
add_action('wp_ajax_nopriv_showSimilarGames', 'showSimilarGames');
add_action('wp_ajax_topViewGames', 'topViewGames');
add_action('wp_ajax_nopriv_topViewGames', 'topViewGames');
add_action('wp_ajax_lineCateAjax', 'lineCateAjax');
add_action('wp_ajax_nopriv_lineCateAjax', 'lineCateAjax');

function topViewGames(){
	$message = $_POST['message'];
	global $post, $wpdb;
	/*if($message=='all'){$returnText='all';}
	if($message=='month'){$returnText='month';}
	if($message=='week'){$returnText='week';}
	if($message=='yesterday'){$returnText='yesterday';}*/
	$returnText='';
	if($message=='all'){
	$returnText=$returnText.'<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="all" class="topView"><strong>Gesamt</strong></a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="month" class="topView">Monat</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="week" class="topView">Woche</a>
 		    	     | <a rel="nofollow" href="javascript:void(0);" name="yesterday" class="topView">Gestern</a>
		    	  </div>
		    	  <div class="topView_waiting"></div>';

	
	$query='SELECT ID, post_title, post_name, post_date, f1.meta_value +0 AS viewcount, 
			f2.meta_value as intro_home, f3.meta_value as image
			FROM kostenlosspielen_posts 
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'pvc_views\'
			AND f2.meta_key =  \'intro_home\'
			AND f3.meta_key =  \'image\'
			ORDER BY viewcount DESC
			LIMIT 0,100'; 	
	}elseif($message=='month'){
		$returnText=$returnText.'<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="all" class="topView">Gesamt</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="month" class="topView"><strong>Monat</strong></a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="week" class="topView">Woche</a>
 		    	     | <a rel="nofollow" href="javascript:void(0);" name="yesterday" class="topView">Gestern</a>
		    	  </div>
		    	  <div class="topView_waiting"></div>';
	}elseif($message=='week'){
		$returnText=$returnText.'<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="all" class="topView">Gesamt</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="month" class="topView">Monat</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="week" class="topView"><strong>Woche</strong></a>
 		    	     | <a rel="nofollow" href="javascript:void(0);" name="yesterday" class="topView">Gestern</a>
		    	  </div>
		    	  <div class="topView_waiting"></div>';

	}elseif($message=='yesterday'){
		
		$returnText=$returnText.'<div class="category_top">Sortieren nach: <a rel="nofollow" href="javascript:void(0);" name="all" class="topView">Gesamt</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="month" class="topView">Monat</a>
		    	  	 | <a rel="nofollow" href="javascript:void(0);" name="week" class="topView">Woche</a>
 		    	     | <a rel="nofollow" href="javascript:void(0);" name="yesterday" class="topView"><strong>Gestern</strong></a>
		    	  </div>
		    	  <div class="topView_waiting"></div>';
				  $startTime=time()-86400;
		
		$query='SELECT ID, post_title, post_name, post_date, f1.meta_value +0 AS viewcount, 
			f2.meta_value as intro_home, f3.meta_value as image
			FROM kostenlosspielen_posts 
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'pvc_views\'
			AND f2.meta_key =  \'intro_home\'
			AND f3.meta_key =  \'image\'
			AND post_date > '.$startTime.'
			ORDER BY viewcount DESC
			LIMIT 0,100'; 	
		
				  
	}
	//print_r($query);
	$counter=0;
	$pageposts = $wpdb->get_results($query, ARRAY_A);
	foreach ($pageposts as $post){
		if($counter % 5 ==0){
			$returnText=$returnText.'<div class="meist_game_item_1">';
		}else{
			$returnText=$returnText.'<div class="meist_game_item">';
		}
		$returnText=$returnText.'<div class="meist_item_thumbs">
			                <a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="nofollow"><img src="'.$post['image'].'" width="120" height="89" alt="'.$post['post_title'].'" title="'.$post['intro_home'].'" /></a>
      					</div>
      					<div class="meist_item_text">
      						<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="nofollow">'.$post['post_title'].'</a>
      						<center>'.number_format($post['viewcount'],0,',','.').' x gespielt</center>
      					</div>';
		$returnText=$returnText.'</div>';
		$counter++;
	}
	$returnText=$returnText.'
	<script type="text/javascript">
	            jQuery(document).ready(function($){
	                $(\'.topView\').click(function(){
					    var message = $(this).attr("name");
					    $.ajax({
					        type: \'POST\',
					        url: \''.SITE_ROOT_URL.'/wp-admin/admin-ajax.php\',
					        data: {"action": "topViewGames", "message":message},
					        beforeSend: function() {$(".topView_waiting").fadeIn(\'fast\');},
					        success: function(data){
					            $(".topView_waiting").fadeOut(\'slow\');
					            $("#topViewGames").html(data);
					        }
					    });
					    return false;
					});
	            });
				</script>';
					
				  

	echo $returnText;
	die();

}

function getPostByCategory6($cateID){
	global $post;
	$args = array( 'numberposts' => 7, 'offset'=> 0, 'category' => $cateID, 'order'=> 'DESC', 'orderby' => 'post_date' );
	$myposts = get_posts( $args );
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
	setup_postdata($post);
	if($count<4){
		$postText= $postText.'<div class="index_item6_'.$count.'">';
		
		$postText= $postText.'<div class="index_item_thumbs">
			<a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'" ><img src="'.get_post_meta($post->ID, "image", $single = true).'" width="101" height="76" title="'.get_the_title($post->ID).'" alt="'.get_the_title($post->ID).'" /></a>
			<center><a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'" >'.get_the_title($post->ID).'</a></center>
		</div>';
	    $postText= $postText.'</div>';
	}else{
		if($count==4){
			$postText= $postText.'<div class="category_index_list">';			
		}
		$postText= $postText.'<div class="index_list_item"><a title="'.get_the_title($post->ID).'" href="'.get_permalink($post->ID).'" >'.get_the_title($post->ID).'</a></div>';
	}
	$count++; 
	}
    $postText= $postText.'</div>';
	return $postText;
}

function getPostByCategory2($cateID){
	global $post, $wpdb;
	$query='SELECT ID, post_title, post_name, f1.meta_value +0 AS viewcount, 
			f2.meta_value as intro, f3.meta_value as image
			FROM kostenlosspielen_posts
			JOIN kostenlosspielen_term_relationships ON 
			( kostenlosspielen_posts.ID = kostenlosspielen_term_relationships.object_id ) 
			JOIN kostenlosspielen_term_taxonomy 
			ON ( kostenlosspielen_term_relationships.term_taxonomy_id = kostenlosspielen_term_taxonomy.term_taxonomy_id ) 
			JOIN kostenlosspielen_terms ON ( kostenlosspielen_terms.term_id = kostenlosspielen_term_taxonomy.term_id ) 
			JOIN kostenlosspielen_postmeta f1 ON ( f1.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f2 ON ( f2.post_id = kostenlosspielen_posts.ID ) 
			JOIN kostenlosspielen_postmeta f3 ON ( f3.post_id = kostenlosspielen_posts.ID ) 
			WHERE kostenlosspielen_terms.term_id =  '.$cateID.'
			AND kostenlosspielen_term_taxonomy.taxonomy =  \'category\'
			AND kostenlosspielen_posts.post_status =  \'publish\'
			AND kostenlosspielen_posts.post_type =  \'post\'
			AND f1.meta_key =  \'pvc_views\'	
			AND f2.meta_key =  \'intro\'
			AND f3.meta_key =  \'image\'
			ORDER BY post_date DESC
			LIMIT 0,24'; 
	$myposts = $wpdb->get_results($query, ARRAY_A);
	$postText='';
	$count=0;
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		if($count<21){
			$postText= $postText.'<div class="index_item2_thumbs" id="index_item2_thumbs_'.$count.'">
			<a rel="follow" title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post['image'].'" width="101" height="76" title="'.$post['intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">
			'.$title_text.'
			</a></center>
			<center>'.(intval(get_post_meta($post->ID,'pvc_views',true))+0).' x gespielt</center>
			</div>';
		}else{
			if($count==21){
				$postText= $postText.'<div class="index_list">';			
			}
			$postText= $postText.'<div class="index_list_item"><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="nofollow" >'.$post['post_title'].'</a></div>';
		}
		$count++; 
	}
	$postText= $postText.'</div>';
	return $postText;
}
function lineCateAjax(){
	
	global $post, $wpdb;
	$page = $_POST['page'];
	$cateID = $_POST['cateid'];
	if($cateID==261){
	$query='SELECT * FROM kostenlosspielen_posts
			WHERE category1 = 261
			AND post_status =  \'publish\' AND post_type =  \'post\'
			ORDER BY post_date DESC
			LIMIT '.(($page-1)*6).',6';
	}else{
	$query='SELECT * FROM kostenlosspielen_posts
			WHERE category2 = '.$cateID.'
			AND post_status =  \'publish\' AND post_type =  \'post\'
			ORDER BY post_date DESC	LIMIT '.(($page-1)*6).',6';
	}
			
	$myposts = $wpdb->get_results($query, ARRAY_A);	
	$postText='';
	$count=0;
	$postText='<div id="categoryHTML'.$cateID.'">';
	$postText=$postText.'<div id="categoryLine'.$cateID.'"></div>';
	foreach( $myposts as $post ) {
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		$post_image=replaceImages($post['game_image'],'100');
		$category_class='category_index_item_thumbs_'.$count;
		$postText= $postText.'<div class="category_index_item_thumbs" id="'.$category_class.'">';	
		$postText= $postText.'
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="100" height="75" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">
			'.$title_text.'
			</a></center>
			<center>'.number_format($post['game_views'],0,',','.').' x gespielt</center>
		</div>';
	}
	$max=18;
	if($cateID==261||$cateID==423){$max=8;}
	if($cateID==415){$max=6;}
	if($cateID==421){$max=16;}
	if($cateID==3898){$max=3;}
	if($cateID==439){$max=5;}
	$postText=$postText.'<div class="index_mehr_left_line"><strong>Seite</strong>: ';

	
	for($i=1;$i<=$max;$i++){
		if($i==$page){
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="lineCate"><strong>'.$i.'</strong></a> &nbsp;';	
		}else{
			$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="lineCate">'.$i.'</a> &nbsp;';	
		}
	}
	$category_url=get_category_link($cateID);
	$postText=$postText.'<a rel="nofollow" href="'.$category_url.'" class="twodot">..</a>';
    $postText=$postText.'</div><div class="index_mehr"><a rel="nofollow" href="'.$category_url.'">Mehr</a></div>';
	$postText=$postText.'</div>';
	$postText=$postText.'<script type="text/javascript">
	            jQuery(document).ready(function($){
	                $(\'.lineCate\').click(function(){
					    var message = $(this).attr("name");
					    var word=message.split("-");
					    var cateid=word[0];
					    var page=word[1];

					    $.ajax({
					        type: \'POST\',
					        url: \''.SITE_ROOT_URL.'/wp-admin/admin-ajax.php\',
					        data: {"action": "lineCateAjax", "cateid":cateid, "page":page},
					        beforeSend: function() {$("#categoryLine"+cateid).fadeIn(\'fast\');},
					        success: function(data){
					            $("#categoryLine"+cateid).fadeOut(\'slow\');
					            $("#categoryHTML"+cateid).html(data);
					        }
					    });
					    return false;
					});
	            });
				</script>';

	echo $postText;
	die();


}

function getPostByCategoryLine($cateID){
	global $post, $wpdb;
	if($cateID==261){
		$category='category1';
	}else{
		$category='category2';
	}
	$query='SELECT * FROM kostenlosspielen_posts WHERE '.$category.' =  '.$cateID.'
			AND post_status =  \'publish\' AND post_type =  \'post\'
			ORDER BY post_date DESC	LIMIT 0,6'; 			
	//if(!is_admin()) {		echo $query;	}
	$myposts = $wpdb->get_results($query, ARRAY_A);	
	$postText='';
	$count=0;
	$postText='<div id="categoryHTML'.$cateID.'">';
	$postText=$postText.'<div id="categoryLine'.$cateID.'"></div>';
	foreach( $myposts as $post ) {
		$post_image=replaceImages($post['game_image'],'100');
		if(strlen($post['post_title'])<17){
			$title_text=$post['post_title'];	
		}else{
			$title_text=substr($post['post_title'],0,15).'..';
		}
		$category_class='category_index_item_thumbs_'.$count;
		$postText= $postText.'<div class="category_index_item_thumbs" id="'.$category_class.'">';	
		$postText= $postText.'
			<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html"><img src="'.$post_image.'" width="100" height="75" title="'.$post['game_intro'].'" alt="'.$post['post_title'].'" /></a>
			<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html">
			'.$title_text.'
			</a></center>';
			
		//echo date('Y-m-d', strtotime($post['post_date']));
		if ((date('Y-m-d') == date('Y-m-d', strtotime($post['post_date'])))||
		(date('Y-m-d') == date('Y-m-d', (strtotime($post['post_date'])+86400)))
		) {
			$postText= $postText.'<center><img src="'.SITE_ROOT_URL.'/wp-content/uploads/neue-spiele.gif" alt="Neue Spiele" title="Neue Spiele" height="10" width="29" /></center>';
		}
		$postText= $postText.'</div>';
	}
	$max=17;
	if($cateID==261||$cateID==423){$max=8;}
	if($cateID==415){$max=6;}
	if($cateID==421){$max=16;}
	if($cateID==3898){$max=3;}
	if($cateID==439){$max=5;}

	$postText=$postText.'<div class="index_mehr_left_line"><strong>Seite</strong>: ';

	
	for($i=1;$i<=$max;$i++){
			if($i==1) {
				$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="lineCate"><strong><u>'.$i.'</u></strong></a> &nbsp;';	
			}else{
				$postText=$postText.'<a rel="nofollow" href="javascript:void(0);" name="'.$cateID.'-'.$i.'" class="lineCate">'.$i.'</a> &nbsp;';	
			}
	}
	$category_url=get_category_link($cateID);
	$postText=$postText.'<a href="'.$category_url.'" class="twodot" rel="nofollow">..</a>';
    $postText=$postText.'</div><div class="index_mehr"><a href="'.$category_url.'" rel="nofollow">Mehr</a></div>';
	$postText=$postText.'</div>';
	return $postText;
}
function kos_h1(){
	global $post, $wpdb, $wp_query;
	
	if ( is_home()||is_front_page() ) {
        $title= 'Kostenlos spielen ohne Anmeldung';
	}elseif ( is_page() ) {
   		$title=get_the_title();
	}elseif ( is_tag() ) {
	   	$title='kostenlose Spiele nach '.wp_title('',false,true);	   	
	}elseif ( is_single() ) {
		$title=get_the_title();
	}elseif ( is_category() ) {
		$title=single_cat_title('',false );
	}
		return $title;

}
function kos_title(){
    //#nttuyen hack
    //Recalculate title of page when is category
    $category = Category::getInstance();
    if($category) {
        $categoryInfo = $category->getCategoryInfo();
        $title = 'Die '.$categoryInfo['name'].' kostenlos spielen - Seite '.$category->getCurrentPage().' | kostenlosspielen.biz';
        if($category->getOrderType() == 'best') {
            $title = 'Best bewertete '.$categoryInfo['name'].' spielen - Seite '.$category->getCurrentPage().' | kostenlosspielen.biz';
        } else if($category->getOrderType() == 'vote') {
            $title = 'Die meist bewertete '.$categoryInfo['name'].' spielen - Seite '.$category->getCurrentPage().' | kostenlosspielen.biz';
        } else if($category->getOrderType() == 'new') {
            $title = 'Am neuesten '.$categoryInfo['name'].' spielen - Seite '.$category->getCurrentPage().' | kostenlosspielen.biz ';
        }

        echo $title;
        return;
    }
    //#nttuyen end hack


	global $post, $wpdb, $wp_query;
  $paged_var = get_query_var( 'page' );
  $subpaged_var = get_query_var( 'paged' );
	if ( is_home()||is_front_page() ) {
        $title= 'Kostenlos spielen ohne Anmeldung -> 9999+ Spiele genießen';
	}elseif ( is_page() ) {
   		$title=get_the_title().'auf www.kostenlosspielen.biz';
	}elseif ( is_tag() ) {
	   	$title='kostenlose Spiele nach '.wp_title('',false,true).'- '.get_bloginfo( 'name' );	   	
	}elseif ( is_single() ) {
		if(is_single('bubble-shooter')){
			$title='Bubble Shooter kostenlos spielen ohne Anmeldung';	
		}elseif(is_single('1314')){
			$title='Spider Solitär, online Spider Solitaire|kostenlosspielen.biz';	
		}elseif(is_single('1323')){
			$title='Online Freecell Solitär spielen auf kostenlosspielen.biz';	
		}elseif(is_single('4860')){
			$title='Scrabble, Scrabble online kostenlos spielen | kostenlosspielen.biz';	
		}elseif(is_single('moorhuhn-original')){
			$title='Moorhuhn, Moorhuhn Original online spielen | kostenlosspielen.biz';	
		}else{
	    	$title=get_the_title().' kostenlos spielen auf kostenlosspielen.biz';	
		}
		

	}elseif ( is_archive() ){
	   	if(is_category('verschiedene-actionspiele')){
	   		$title='Verschiedene Action Spiele kostenlos spielen | Action Spiele';
	   	}elseif(is_category('verschiedene-rennspiele')){
	   		$title='Verschiedene Rennspiele kostenlos spielen | kostenlosspielen.biz';
	   	}elseif(is_category('verschiedene-geschicklichkeitsspiele')){
	   		$title='Verschiedene Geschicklichkeitsspiele kostenlos spielen | Spiele';
	   	}elseif(is_category('verschiedene-karten')){
	   		$title='Verschiedene Kartenspiele kostenlos spielen | kostenlos spielen';
	   	}elseif(is_category('verschiedene-maedchen')){
	   		$title='Verschiedene Mädchen Spiele kostenlos spielen | kostenlos spielen';
	   	}elseif(is_category('verschiedene-denkspiele')){
	   		$title='Verschiedene Denkspiele kostenlos spielen | kostenlosspielen.biz';
	   	}elseif(is_category('verschiedene-abenteuer-spiele')){
	   		$title='Verschiedene Abenteuer kostenlos spielen | kostenlosspielen.biz';
	   	}elseif(is_category('verschiedene-sport-spiele')){
	   		$title='Verschiedene Sport Spiele kostenlos spielen |kostenlosspielen.biz';
	   	}elseif(is_category('abenteuer-spiele')){
	   		$title='Abenteuer kostenlos spielen auf www.kostenlosspielen.biz';
	   	}elseif(is_category('flugzeug-spiele')){
	   		$title='Flugzeug Spiele kostenlos spielen | kostenlosspielen.biz';
	   	}elseif(is_category('boot-rennen')){
	   		$title='Boot Rennen Spiele kostenlos spielen | kostenlosspielen.biz';
		}elseif(is_category('rennspiele')){
	   		$title='Rennspiele kostenlos spielen auf www.kostenlosspielen.biz';
	   	}elseif(is_category('solitaer')){
	   		$title='Solitär Spiele kostenlos spielen auf www.kostenlosspielen.biz';
		}elseif(is_category('mario-spiele')){
			$title='Mario Spiele, online kostenlose Mario Spiele | kostenlosspielen.biz';
		}elseif(is_category('2 Spieler')){
			$title='Die 2 Spieler Spiele kostenlos spielen | www.kostenlosspielen.biz';
		}elseif(is_category('maedchen-spiele')){
			$title='Mädchen Spiele, kostenlose Spiele für Mädchen | kostenlosspielen.biz';
		}elseif(is_category('mahjong-spiele')){
			$title='Mahjong, Mahjong Spiele kostenlos spielen | kostenlosspielen.biz';
		}elseif(is_category('bubbles-spiele')){
			$title='Bubbles, Bubble-Spiele kostenlos spielen | kostenlosspielen.biz';
		}elseif(is_category('solitaer-spiele')){
			$title='Solitär, Solitär Spiele kostenlos spielen | kostenlosspielen.biz';
		}elseif(is_category('pferde-spiele')){
			$title='Pferdespiele, online Pferedespiele spielen | kostenlosspielen.biz';
		}elseif(is_date()){
			if ( is_day() ) {
				$title ='Kostenlose Spiele am '. get_the_time('F jS, Y').' | '. get_bloginfo( 'name') ;  
			}elseif ( is_month() ) {
				$title ='Kostenlose Spiele am '. get_the_time('F, Y').' | '. get_bloginfo( 'name') ;
			}elseif ( is_year() ) {
				$title ='Kostenlose Spiele am '. get_the_time('Y').' | '. get_bloginfo( 'name') ;	
			}
	   	}else{
			$category=single_cat_title('',false );
			$title=$category.' kostenlos spielen | kostenlosspielen.biz';
		}	
	   		   	
	}elseif( is_search() ){
		$title=wp_title('').' Spiele | '.get_bloginfo( 'name' );
	}elseif( is_feed() ){
		$title='RSS Feed | '.get_bloginfo( 'name' );
	}
	if($paged_var>0) {
		$title=$title.' | Seite:'.$paged_var;
	}
	if($subpaged_var>0) {
		$title=$title.' | Seite:'.$subpaged_var;
	}

	echo $title;
}
function kos_meta(){
  global $post;
  global $wpdb;
  $category = Category::getInstance();

  //basic setup
  echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n";
  if( is_tag() || ($category && $category->getOrderType() != 'view')){
	echo '<meta name="robots" content="noindex, follow" />' . "\n";
  } else {
  	echo '<meta name="robots" content="index, follow" />' . "\n";  	
  }

  //robots setup
  //description + canonical + keyword setup
  $description='';
  $description='Bubble Shooter, Solitär, Mahjong, Puzzle, 3-Gewinnt, Mario, Tetris, Mädchenspiele..-> Sofort kostenlos spielen. &#10004; Keine Kosten auf kostenlosspielen.biz.';
    if ( is_home()||is_front_page() ) {
        echo '<link rel="canonical" href="http://www.kostenlosspielen.biz/" />' . "\n";
        echo '<meta name="keywords" content="kostenlos spielen, Gratis Spiele, mahjong kostenlos, tetris spielen, Auto spiele, barbie spiele, mario spiele, billard spielen, kostenlose spiele, kostenlos spielen ohne anmeldung" />' . "\n";;
  }elseif( is_tag() ){

    $tag_name=get_query_var('tag');
    $tag = get_term_by('slug', $tag_name, 'post_tag');
    $term_uid = $tag->term_id;
	echo '<link rel="canonical" href="'.get_bloginfo('home').'/tag/'.$tag->slug.'/" />' . "\n";
    $queryAll="SELECT COUNT(*) FROM $wpdb->posts,$wpdb->term_taxonomy,$wpdb->term_relationships WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type='post' AND $wpdb->term_taxonomy.term_id=".$term_uid." AND $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id AND $wpdb->term_relationships.object_id=$wpdb->posts.id AND $wpdb->term_taxonomy.taxonomy='post_tag'";
    $numposts = $wpdb->get_var($queryAll);
    $keywords='';
   	$description='Alle Spiele:'.$numposts;		
    $description=$description.', kostenlose Spiele auf kostenlosspielen.biz nach '.ucfirst($tag_name).' Spielkategorie';
    $query_tag_games = "SELECT $wpdb->posts.* FROM $wpdb->posts,$wpdb->term_taxonomy,$wpdb->term_relationships WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type='post' AND $wpdb->term_taxonomy.term_id=".$term_uid." AND $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id AND $wpdb->term_relationships.object_id=$wpdb->posts.id AND $wpdb->term_taxonomy.taxonomy='post_tag' LIMIT 5";
      $pageposts = $wpdb->get_results($query_tag_games, OBJECT);
      $description.= ',Top 5:';
      $count=0;
      foreach($pageposts as $top5){
        if($count==0){
          $description.=$top5->post_title;
          $keywords.=$top5->post_title.' Spiel';
        }else{
          $description.=','.$top5->post_title;
          $keywords.=','.$top5->post_title.' Spiel';
        }
        $count++;
      }
      echo '<meta name="keywords" content="'.$keywords.', '.$tag_name.'" />'. "\n";
  }elseif ( is_single() ) {
		$query='SELECT * FROM kostenlosspielen_posts WHERE ID='.$post->ID; 
		$post = $wpdb->get_row($query);
	//print_r($post);
	$description=trim(strip_tags($post->game_intro));
    if(substr($description, -1)=='.'||substr($description,-1)=='!'||substr($description,-1)=='?'){
    	$description.=' Kategorie:';
    }else{
    	$description.='. Kategorie:';	
    }
    
    $post_tags = wp_get_post_tags($post->ID);
    $count=0;
    $keywords='';
    foreach($post_tags as $post_tag){
        if($count<3){   
          if($count==0){
            $description.=$post_tag->name;
          }else{
            $description.=';'.$post_tag->name;
          }
        }
        $count++;
      $keywords.=','.$post_tag->name;
    }
    echo '<link rel="canonical" href="'.SITE_ROOT_URL.'/'.$post->post_name.'.html" />' . "\n";
    echo '<meta name="keywords" content="'.$post->post_name.' Spiel'.$keywords.'" />'. "\n";
  }elseif ( is_page() ) {
   	echo '<link rel="canonical" href="'.get_page_link().'" />' . "\n";
    if(is_page('7')){
      // Verlinken Sie uns
        echo '<meta name="keywords" content="impressum, kostenlos spielen, mahjong kostenlos, tetris spielen, Auto spiele, barbie spiele, mario spiele, billard spielen, kostenlose spiele, kostenlos spielen ohne anmeldung" />'. "\n";     
      $description='Die Impressum von www.kostenlosspielen.biz - große Auswahl an allen möglichen Flashgames.';
    }if(is_page('66')){
      // Verlinken Sie uns
        echo '<meta name="keywords" content="verlinken, kostenlos spielen, mahjong kostenlos, tetris spielen, Auto spiele, barbie spiele, mario spiele, billard spielen, kostenlose spiele, kostenlos spielen ohne anmeldung" />'. "\n";     
      $description='Unser Website gefällt Ihnen? Dann würden wir uns freuen, wenn Sie ein Banner oder einen Textlink von www.kostenlosspielen.biz auf Ihrer Seite einbinden.';
    }elseif(is_page('68')){
      // Partnerseite
        echo '<meta name="keywords" content="partnerseite, kostenlos spielen, mahjong kostenlos, tetris spielen, Auto spiele, barbie spiele, mario spiele, billard spielen, kostenlose spiele, kostenlos spielen ohne anmeldung" />'. "\n";      
      $description='Die Website oder Firma arbeiten mit www.kostenlosspielen.biz, um den Nutzern ein Entertainmentsystem mit der besten Qualität  anzubieten.';
    }elseif(is_page('853')){// Meist gespielt Spiele
	        echo '<meta name="keywords" content="kostenlos spielen, mahjong kostenlos, tetris spielen, Auto spiele, barbie spiele, mario spiele, billard spielen, kostenlose spiele, kostenlos spielen ohne anmeldung" />'. "\n";      
	      	$description='Top 100 meist gespielte kostenlose Spiele kostenlos spielen, z.B Klassikers Mahjong, Blockout Tetris, Mario Rennen, Jump Mario, Barbie Hochzeit';
    }
  }elseif(is_archive()){
  	if(is_category()){	
	  	$thisCat = get_category(get_query_var('cat'),false);
		$parentCatID = $thisCat->category_parent;
		if($parentCatID==0) {
			$link_url=get_bloginfo('home').'/'.$thisCat->slug.'/';		
		}else{
			$parentCat=get_category($parentCatID);
			$link_url=get_bloginfo('home').'/'.$parentCat->slug.'/'.$thisCat->slug.'/';
		}
        if(empty($category)) {
       	    echo '<link rel="canonical" href="'.$link_url.'" />' . "\n";
        }
        if($category) {
            $start = ($category->getCurrentPage() - 1)*$category->getItemPerPage() + 1;
            $end = $start + count($category->getItems()) - 1;
            $categoryInfo = $category->getCategoryInfo();
            if($category->getOrderType() == 'view') {
                $description = 'Die '.$categoryInfo['name'].' auf www.kostenlosspielen.biz von '.$start.' bis '.$end.', z.B';
                $currentCategoryLink = $category->getBaseURL().'/';
                if($category->getCurrentPage() > 1) {
                    $currentCategoryLink .= PAGE.'/'.$category->getCurrentPage().'/';
                }
                echo '<link rel="canonical" href="'.$currentCategoryLink.'" />' . "\n";
            } else if($category->getOrderType() == 'best') {
                $description = 'Die best bewertete '.$categoryInfo['name'].' von '.$start.' bis '.$end.', z.B';
            } else if($category->getOrderType() == 'vote') {
                $description = 'Die meist bewertete '.$categoryInfo['name'].' von '.$start.' bis '.$end.', z.B';
            } else {
                $description = 'Am neuesten '.$categoryInfo['name'].' von '.$start.' bis '.$end.', z.B';
            }
            $games = $category->getItems();
            $number = 0;
            foreach($games as $game) {
                $description .= ', '.$game['post_title'];
                $number++;
                if($number >= 4) {
                    break;
                }
            }
        }elseif(is_category('Action Spiele')){
	  		$description='Die Action Spiele kostenlos spielen, Alle Spiele: 269, z.B Ballerspiele, Krieg Spiele, Bomberman, Kampfspiele, Flugzeug Spiele und weitere Spiele';
	  	}elseif(is_category('Geschicklichkeitsspiele')){
	  		$description='Die Geschicklichkeitsspiele kostenlos spielen, Alle Spiele: 368, z.B Tetris Spiele, Bubbles Spiele, Puzzle Spiele, Pacman Spiele, Pinball, Reaktion';	
	  	}elseif(is_category('Mädchen Spiele')){
	  		$description='Die Mädchen Spiele kostenlos spielen, Alle Spiele: 197, z.B Dekoration Spiele, Anziehspiele, Liebe Spiele, Tier Spiele, Malen und weitere Spiele';	
	  	}elseif(is_category('Denkspiele')){
	  		$description='Die Denkspiele kostenlos spielen, Alle Spiele: 278, z.B Mahjong Spiele, Sudoku online, Schach online, Unblock Me und weitere Spiele';	
	  	}elseif(is_category('abenteuer-spiele')){
	  		$description='Die kostenlose Abenteuer Spiele kostenlos spielen, Alle Spiele: 387, z.B Mario, Puzzlen & Laufen, Rollenspiele, Sonic, Sammeln & Laufen';	
	  	}elseif(is_category('Rennspiele')){
	  		$description='Die Rennspiele kostenlos spielen, Alle Spiele: 98, z.B Autorennen Spiele, Motocross Online, Motorradspiele, Bootsrennen und weitere Spiele';	
	  	}elseif(is_category('Sport Spiele')){
	  		$description='Die Sport Spiele kostenlos spielen, Alle Spiele: 135, z.B Fußball Spiele, Billard Spiele, Boxen Spiele, Bowling, Golf, Ski, Tennis und weitere Spiele';	
	  	}elseif(is_category('Weitere Spiele')){
	  		$description='Die Weitere kostenlose Spiele kostenlos spielen, Alle Spiele: 34. Ohne Anmeldung zu kostenlos spielen. Kurze Ladezeiten und einfach genießen';	
	  	}elseif(is_category('brettspiele')){
	  		$description='Die Brettspiele kostenlos spielen, Alle Spiele: 187, z.B Blackjack Spiele, Solitär Spiele, Memory Spiele, Casino Spiele, Poker Spiele, Kartenspiele, Tic Tac Toe';	
	  	}
	  	
	  	//für sub Action category
	  	elseif(is_category('Ballerspiele')){
	  		$description='Die Ballerspiele kostenlos spielen, Alle Spiele: 72, z.B Red Plane,Battle Royale,Hasenrakete,Robin Hood, Raze,Gangster Streets,Bowman,Eichhörnchen Spiele';	
	  	}elseif(is_category('Kampfspiele')){
	  		$description='Die Kampfspiele kostenlos spielen, Alle Spiele: 41, z.B Fighting Jam,Monster Fighter,King of Death,Fury Officer,Halloween Beatdown,Perfect Fighter Spiele';	
	  	}elseif(is_category('Bomberman Spiele')){
	  		$description='Die Bomberman Spiele kostenlos spielen, Alle Spiele: 11, z.B Bomber Knight, Brückentaktik 2, Demolition City, Diamon Detonation, Bomb Jack Spiele';	
	  	}elseif(is_category('Kriegsspiele')){
	  		$description='Die Kriegsspiele kostenlos spielen, Alle Spiele: 26, z.B Dogfight The Great War,Battle Royale,Schiffe versenken, Stick War Spiele';	
	  	}elseif(is_category('Flugzeug Spiele')){
	  		$description='Die Flugzeug Spiele kostenlos spielen, Alle Spiele: 28, z.B Stunt Pilot,Hostile Skies,Get that Jet,Paper Pilots,Alpha Force Spiele';	
	  	}elseif(is_category('Turmverteidigung Spiele')){
	  		$description='Die Turmverteidigung Spiele kostenlos spielen, Alle Spiele: 31, z.B Duels Defense, Pyramiden, Autobahn Verteidigung,Ballon Tower Defense 2 Spiele';	
	  	}elseif(is_category('verschiedene-actionspiele')){
	  		$description='Die Weitere Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 50, z.B Marktlaster,Riggs Digger,Papa Louie,Escape Spiele';	
	  	}elseif(is_category('Mafia Spiele')){
	  		$description='Die Mafia Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 14, z.B Black Fist, Mafia Jungle, Mafia Taxi Puzzle, The Death of a Mafia Boss..';	
	  	}elseif(is_category('Zombie Spiele')){
	  		$description='Die Zombie Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 14, z.B Zombie anziehen, GeZombiet, Zombie Smasher, Zombies müssen sterben..';	
	  	}elseif(is_category('Strategie Spiele')){
	  		$description='Die Strategie Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 14, z.B Himmel und Hölle, Strategy Defence 2, School Wars..';	
	  	}elseif(is_category('Ninja Spiele')){
	  		$description='Die Ninja Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 11, z.B Flying Ninja, Little Fat Ninja, Ninja Jack, Ninja Ball..';	
	  	}elseif(is_category('Piraten Spiele')){
	  		$description='Die Piraten Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 9, z.B Pirates Second Blood, Pirate Blast, Columbus Pirate..';	
	  	}elseif(is_category('Tanks')){
	  		$description='Die Tanks Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 11, z.B Hover Tanks, Fuel Tank, Tank Defense, Tank Mania..';	
	  	}elseif(is_category('space-invaders-spiele')){
	  		$description='Die Space Invaders Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 14, z.B Colonel Kernel, Chainthesia, Space Invaders..';	
	  	}elseif(is_category('Asteroids')){
	  		$description='Die Asteroids Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 14, z.B Asteroid Rampage 2, Luminara, Asteroid Dodge..';	
	  	}elseif(is_category('Roboter-Spiele')){
	  		$description='Die Roboter-Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 9, z.B Roboxer, Transformers Quest, Transformers Escape 3..';	
	  	}elseif(is_category('counter-strike')){
	  		$description='Die Counter Strike Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 14, z.B Stick Strike, Smart Sniper, Santastrike...';	
	  	}elseif(is_category('batman-spiele')){
	  		$description='Die Batman Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 9, z.B Run Batman Run, Batman Vs. Mr. Freeze, Batman - Ice Cold Getaway..';	
	  	}elseif(is_category('sniper-spiele')){
	  		$description='Die Sniper Spiele aus der Kategorie Actionspiele kostenlos spielen, Alle Spiele: 60, z.B Heavenly Sniper, Storm Ops 2, Harbor Sniper, Pro Sniper..';	
	  	}
	  	//für sub Denken category
	  	elseif(is_category('3-Gewinnt Spiele')){
	  		$description='Die 3-Gewinnt Spiele kostenlos spielen, Alle Spiele: 39, z.B Candy Elf, Diamond Valley, Schneekönigin, 1001 Arabian Nights, Flucht ins Paradies';	
	  	}elseif(is_category('4-Gewinnt Spiele')){
	  		$description='Die 4-Gewinnt Spiele kostenlos spielen, Alle Spiele: 9, z.B Luminati, 4 Balls, 4 verbinden, Dessert Mania..';	
	  	}elseif(is_category('Wimmelbilder')){
	  		$description='Die Wimmelbilder kostenlos spielen, Alle Spiele: 21, z.B Patty: Ostern steht vor der Tür, My Medicine, Stackopolis, Such den Zwilling';	
	  	}elseif(is_category('Mahjong Spiele')){
	  		$description='Die besten Mahjong Spiele kostenlos spielen, Alle Spiele: 99, z.B Mahjong Turm,Mahjong Imperium,Mahjong Königreich,Garten Mahjong,Goldfisch Mahjong Spiele';	
	  	}elseif(is_category('Rätsel Spiele')){
	  		$description='Die Online Rätsel Spiele kostenlos spielen, Alle Spiele: 21, z.B Pyramid Escape, Wordz Manie, Odd Ducks, Komische Insel und viele mehr';	
	  	}elseif(is_category('Schach Spiele')){
	  		$description='Die Schach Spiele kostenlos spielen, Alle Spiele: 7, z.B Fighting Jam,Monster Fighter,King of Death,Fury Officer,Halloween Beatdown,Perfect Fighter Spiele';	
	  	}elseif(is_category('Sudoku Spiele')){
	  		$description='Die Sudoku Spiele kostenlos spielen, Alle Spiele: 10, z.B Auway Sudoku, Monster Sudoku, Sushi Sudoku, Traditional Sudoku, Royal Sudoku, Sudoku Spiele';	
	  	}elseif(is_category('point-and-click')){
	  		$description='Die Point and Click Spiele kostenlos spielen, Alle Spiele: 26, z.B Hugo der Obdachlose, Piraten der untoten See, Donald der Dino, Georg der Geist und viele mehr';	
	  	}elseif(is_category('Unblock me Spiele')){
	  		$description='Die Unblock-me Spiele kostenlos spielen, Alle Spiele: 44, z.B Edelstein,Katrinas Küche,Schweinestapel,Spaß auf dem Bauernhof,Goldrausch Spiele';	
	  	}elseif(is_category('zuma')){
	  		$description='Die Zuma Spiele kostenlos spielen, Alle Spiele: 20, z.B Mystisches Indien, Perlenschießer der Oktopus, Screwball, Bongo Balls, Bioblast';	
	  	}elseif(is_category('verschiedene-denkspiele')){
	  		$description='Die Weitere Spiele aus der Denkspiele Kategorie kostenlos spielen, Alle Spiele: 101, z.B Bob die Schnecke,Heiße Hose,Persönliches Geheimnis,Monyos Abenteuer Spiele';	
	  	}elseif(is_category('strasse-bauen')){
	  		$description='Die Straße-bauen Spiele aus der Denkspiele Kategorie kostenlos spielen, Alle Spiele: 11, z.B Tiere schieben, Puzzlenauts, Puppet Five, Blockslide..';	
	  	}elseif(is_category('strasse-bauen')){
	  		$description='Die Straße-bauen Spiele aus der Denkspiele Kategorie kostenlos spielen, Alle Spiele: 11, z.B Tiere schieben, Puzzlenauts, Puppet Five, Blockslide..';	
	  	}elseif(is_category('wortspiele')){
	  		$description='Die Wortspiele aus der Denkspiele Kategorie kostenlos spielen, Alle Spiele: 11, z.B KrissX, Wordx, Save the Girl, Wortsalat..';	
	  	}elseif(is_category('blocks-spiele')){
	  		$description='Die Blocks-Spiele kostenlos spielen, Alle Spiele: 11, z.B Flood Fill, Monster Match, Bug Killer, Animal Keeper..';	
	  	}elseif(is_category('minesweeper')){
	  		$description='Die Minesweeper kostenlos spielen, Alle Spiele: 11, z.B Flash Min, Minesucher, Minelink, Giftige Apfeln..';	
	  	}
		//für sub Geschicklichkeitspiele  	
	  	elseif(is_category('Tetris Spiele')){
	  		$description='Die Tetris Spiele kostenlos spielen, Alle Spiele: 31, z.B Tetris Cuboid 3D,Bombaz Tetris,Deutschland Tetris,Mario Tetris,Tetris WS,Kokoris Tetris Spiele';	
	  	}elseif(is_category('Bubbles Spiele')){
	  		$description='Die Bubbles Spiele kostenlos spielen, Alle Spiele: 33, z.B Bubble Bobble, Big Bang Bubbles, Bubble Hunter, Bubble Hit, Bubble Machine, Magic Marbles Spiele';	
	  	}elseif(is_category('Pacman Spiele')){
	  		$description='Die Pacman Spiele kostenlos spielen, Alle Spiele: 10, z.B PacBubbleMan, Slack Man, Splatman, Pacman Platform, Flash Pacman, Pacs Jungle Trip, MadPac Rabios Spiele';	
	  	}elseif(is_category('Puzzle Spiele')){
	  		$description='Die Puzzle Spiele kostenlos spielen, Alle Spiele: 12, z.B Tarzan Puzzle,Digitz,Frog Puzzle,Snake Puzzel,Bloworx,The Simpsons Puzzle Spiele';	
	  	}elseif(is_category('Parkspiele')){
	  		$description='Die Parkspiele kostenlos spielen, Alle Spiele: 6, z.B Park mein Auto,Parking Space,Car Park Challenge, School Bus License,Park Profil 2, Park My Ride 2 Shanghai Spiele';	
	  	}elseif(is_category('Pinball Spiele')){
	  		$description='Die Pinball Spiele kostenlos spielen, Alle Spiele: 8, z.B Tim Ball Pinball, Power Pinball, Pepsi Pinball, Themenpark Pinball, Mr Bump Pinball, Spinball Whizzer Spiele';	
	  	}elseif(is_category('Breakout Spiele')){
	  		$description='Die Breakout Spiele kostenlos spielen, Alle Spiele: 16, z.B Track the Ball,Double Blaster,Break It,Full Board,Crapanoid,Arkanoid,Escaping Paris,Dein Freund Pancho Spiele';	
	  	}elseif(is_category('Reaktion Spiele')){
	  		$description='Die Reaktion Spiele kostenlos spielen, Alle Spiele: 76, z.B Pingfisch,Sheep Reaction,Fish Money,Pferde Springen,Gold Miner,Makos,Panicroom 3,Rollercoaster Rush Spiele';	
	  	}elseif(is_category('Snake Spiele')){
	  		$description='Die Snake Spiele kostenlos spielen, Alle Spiele: 5, z.B Snake Spiele, Snake - Das Original, Bomb Bandits Spiele';	
	  	}elseif(is_category('verschiedene-geschicklichkeitsspiele')){
	  		$description='Die Weitere Spiele aus Kategorie Geschicklichkeitsspiele kostenlos spielen, Alle Spiele: 157, z.B Kebab Van,Jumping Bananas,Fortune Fishing,Käfigzerstörer,Münzspiel,Avatar Zahlensuche Spiele';	
	  	}elseif(is_category('Konzentrationsspiele')){
	  		$description='Die Konzentrationsspiele kostenlos spielen, Alle Spiele: 31, z.B Liquid Measure, Climb It Right, Stivs Aufgaben, Movie Maker, Bein Operation.. ';	
	  	}elseif(is_category('gold-miner')){
	  		$description='Die Gold Miner Spiele kostenlos spielen, Alle Spiele: 15, z.B Gold Miner, Mario Miner Fun, Gold Miner Vegas, Gnome Miner..';	
	  	}elseif(is_category('distanz-rekord')){
	  		$description='Die Distanz-Rekord Spiele kostenlos spielen, Alle Spiele: 13, z.B The Flying Platypus, Hazard Lane, Afrikafliege, Compact Catch..';	
	  	}elseif(is_category('ausweichspiele')){
	  		$description='Die Ausweichspiele kostenlos spielen, Alle Spiele: 11, z.B Run Joey Run, Hamsterball, I Love Traffic, Cheyenne Rodeo..';	
	  	}elseif(is_category('zielen-schiessen')){
	  		$description='Die Zielen & Schießen Spiele kostenlos spielen, Alle Spiele: 7, z.B Krieg gegen U-Boote, Sniper Osbournes, Penguin Arcade..';	
	  	}elseif(is_category('fangspiele')){
	  		$description='Die Fangspiele kostenlos spielen, Alle Spiele: 12, z.B Trick for Treats, Trapr, Shipping Blox, Spectrum Bubbles..';	
	  	}elseif(is_category('physikspiele')){
	  		$description='Die Physikspiele kostenlos spielen, Alle Spiele: 11, z.B Glückliche Tropfen, Robolander, Mumie und Monster, Magische Spielzeugrettung..';	
	  	}elseif(is_category('Sammeln Spiele')){
	  		$description='Die Sammeln Spiele kostenlos spielen, Alle Spiele: 11, z.B Ball in Troubles, Treasureseas, Climbing for Love, Hirtenhündchen..';	
	  	}
	
		//für sub Brettspiele
		elseif(is_category('Blackjack Spiele')){
	  		$description='Die Blackjack Spiele kostenlos spielen, Alle Spiele: 6, z.B Blackjack Gold, Stack Cards, Back Alley Blackjack, Ace Black Jack und weiter Blackjack Spiele';	
	  	}elseif(is_category('Memory Spiele')){
	  		$description='Die Memory Spiele kostenlos spielen, Alle Spiele: 7, z.B Pokemon Pursuit of Pairs,Memory Match Spiderman,Memory Match Spiderman,Horses Memory,Dibblez Memory,Memory 2 Online Spiele';	
	  	}elseif(is_category('Solitär Spiele')){
	  		$description='Die Solitär Spiele kostenlos spielen, Alle Spiele: 12, z.B Crecent Solitaire,Golf Solitaire,Duchess Tripeaks,Solitaire Tower,Spider Solitaire,Gaps Solitaire,Pirate Solitaire Spiele';	
	  	}elseif(is_category('verschiedene-kartenspiele')){
	  		$description='Die weitere Spiele aus Kategorie Kartenspiele kostenlos spielen, Alle Spiele: 3, z.B Parthians Spiele,Lightning Spiele und Speed Spiele';	
	  	}elseif(is_category('poker-spiele')){
	  		$description='Die Poker Spiele kostenlos spielen, Alle Spiele: 12, z.B Texas Hold em Poker, Good Ol Poker, 3 Card Poker, The Dukes of Hazzard Hold em..';	
	  	}elseif(is_category('Kartenspiele')){
	  		$description='Die Kartenspiele kostenlos spielen, Alle Spiele: 56, z.B Poker kostenlos, Blackjack Spiele, Solitär Online, Memory Spiele und weitere Spiele';	
	  	}elseif(is_category('Casino Spiele')){
	  		$description='Die Casino Spiele kostenlos spielen, Alle Spiele: 14, z.B Casino Dress Up, Casino Chip Challenge, Lucky Coins, Vegas Night Lite, Lucky Cowboy City..';	
	  	}elseif(is_category('Roulette Spiele')){
	  		$description='Die Casino Spiele kostenlos spielen, Alle Spiele: 8, z.B Russian Roulette, Top View Roulette, Mobster Roulette 2, Grand Roulette..';	
	  	}elseif(is_category('Tic Tac Toe')){
	  		$description='Die Tic Tac Toe Spiele kostenlos spielen, Alle Spiele: 8, z.B Numeric Tic Tac Toe, Smurfs Tic-Tac-Toe, Tic Tac Toe, Checkers Board..';	
	  	}elseif(is_category('verschiedene-brettspiele')){
	  		$description='Die weitere Brettspiele kostenlos spielen, Alle Spiele: 18, z.B Checkers Fun, Keno, Uno, Parthians, Lightning, Speed..';	
	  	}
		
		//für sub Mädchenspiele
		elseif(is_category('Barbie Spiele')){
	  		$description='Die Barbie Spiele kostenlos spielen, Alle Spiele: 21, z.B Barbie Ballkleid,Barbie Dressup,Sommermädchen Stylen,Barbie Puzzle,Barbie Hollywood,Barbie Hochzeit Spiele';	
	  	}elseif(is_category('Dekoration Spiele')){
	  		$description='Die Dekoration Spiele kostenlos spielen, Alle Spiele: 30, z.B Tessa Hochzeit,Mein Schlafzimmer,Tessas neue Wohnung,Zwergendorf,Schönes Zimmer,Shakira Makeover,Friseur Spass Spiele';	
	  	}elseif(is_category('Anziehspiele')){
	  		$description='Die Anziehspiele kostenlos spielen, Alle Spiele: 18, z.B Young Witch,Justin Bieber Dressup,Dressup Rockstar,Latin Dance Dresses,Barbie Prinzessin Kleid,Barbie Ken Anziehen Spiele';	
	  	}elseif(is_category('Liebe Spiele')){
	  		$description='Die Liebe Spiele kostenlos spielen, Alle Spiele: 9, z.B Barbie Flirten,Flirting Princess,Baby Kiss,Barbie und der Prinz,Love Tester Deluxe,Classrom Flirting Spiele';	
	  	}elseif(is_category('Malen Spiele')){
	  		$description='Die Malen Spiele kostenlos spielen, Alle Spiele: 12, z.B Pinocchio,Butterfly Painting,Tierpark ausmalen,Hello Kitty,Jungle Coloring Book,Mickey Family,Princess Belle Spiele';	
	  	}elseif(is_category('Lernspiele')){
	  		$description='Die Lernspiele kostenlos spielen, Alle Spiele: 20, z.B Flaggen lernen, The Shape Train, Geographie, Finde das ABC und mehr';	
	  	}elseif(is_category('Tier Spiele')){
	  		$description='Die Tier Spiele kostenlos spielen, Alle Spiele: 24, z.B Fliegender Truthahn,die Haustierstadt,Tierrettungszoo,Penguin Diner,Hungry Bears,Hamster Restaurant Spiele';	
	  	}elseif(is_category('Pferde Spiele')){
	  		$description='Die Pferde Spiele kostenlos spielen, Alle Spiele: 18, z.B Pferderennen, Jumporama, Horse Jumping, Golden Trails und viele mehr';	
	  	}elseif(is_category('Kochspiele')){
	  		$description='Die Kochspiele kostenlos spielen, Alle Spiele: 15, z.B Barkeeper, Pizza Pronto, Ice Cream Creation, Bratz Cookie Cake und viele mehr';	
	  	}elseif(is_category('verschiedene-maedchen-spiele')){
	  		$description='Die Weitere Spiele aus Kategorie Mädchen kostenlos spielen, Alle Spiele: 38, z.B Knusperrestaurant,Kinder Mahjong,Saras Kochunterricht,Meine Delfinshow,Märchenkuss Spiele';	
	  	}elseif(is_category('betreuungs-spiele')){
	  		$description='Die Betreuungs-Spiele kostenlos spielen, Alle Spiele: 15, z.B Baby Bathing, Dino Babies, Pet Daycare, TealyGochi, Blobuloids, Terrible Triplets..';
	  	}elseif(is_category('friseurspiele')){
	  		$description='Die Friseur Spiele kostenlos spielen, Alle Spiele: 11, z.B Pajama Hairstyles; Evas Hair Studio, Süßer Haarschnitt, Tokio Hairstyles..';
	  	}elseif(is_category('hochzeitsspiele')){
	  		$description='Die Hochzeitsspiele kostenlos spielen, Alle Spiele: 21, z.B Tessa Hochzeit, Barbie Hochzeit, Sommerbraut anziehen, die perfekte Hochzeit..';
	  	}elseif(is_category('inneneinrichtung')){
	  		$description='Die Inneneinrichtung kostenlos spielen, Alle Spiele: 21, z.B Meine neue Stadt, Modern Room Makeover, Lunapark dekorieren, Kitchen Make Over 2..';
	  	}elseif(is_category('make-up-spiele')){
	  		$description='Die Make-up-spiele kostenlos spielen, Alle Spiele: 21, z.B Beauty Makeover, Hochzeits-Make-Up, Brünnettes Mädchen umstylen,Regenbogenprinzessin schminken..';
	  	}elseif(is_category('nagelstudio')){
	  		$description='Die Nagelstudio Spiele kostenlos spielen, Alle Spiele: 23, z.B Nail Studio, Nail Simulation, Beauty Nail Design, Dream Toe 2, Miranda Manicure..';
	  	}elseif(is_category('quiz-tests')){
	  		$description='Die Quiz & Tests Spiele kostenlos spielen, Alle Spiele: 23, z.B Sushi-Quiz, The Girlfriend Quiz, Madame Mystic, Horoskopstil Löwe, das Tattoo Quiz..';
	  	}elseif(is_category('star-spiele')){
	  		$description='Die Star Spiele kostenlos spielen, Alle Spiele: 23, z.B Adele schminken, Emma Watson MakeUp, Shakira MakeOver, Katy Perry anziehen..';
	  	}
		
		//für sub Abenteuer
		elseif(is_category('Mario Spiele')){
	  		$description='Größte Anzahl der Mario Spiele im Internet &amp;#10004 absolut kostenlos &amp;#10004; ohne Anmeldung &amp;#10004; interessant &amp;#10004; geeignet für jedes Alter';	
	  	}elseif(is_category('fluchtspiele')){
	  		$description='Die Fluchtspiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 63, z.B Leos Day, Escape Chestnut Room, Icescape, Sphere Core, Swan Room..';	
	  	}elseif(is_category('puzzlen-laufen')){
	  		$description='Die Puzzlen & Laufen Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 43, z.B Use Boxmen, Chronotron, Adventure Mitch, Deep Creatures..';
	  	}elseif(is_category('rollenspiele')){
	  		$description='Die Rollenspiele - RPGs aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 38, z.B Civilization Machine, Phantom Mansion 3, Fetter Krieger, Fafu the Ostrich RPG..';
	  	}elseif(is_category('sonic')){
	  		$description='Die Sonic Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 57, z.B Super Sonic Ski, Sonic Ride 2, Sonic Quatro, Sonic Runner, Sonic Speed Race..';
	  	}elseif(is_category('sammeln-laufen')){
			$description='Die Sammeln & Laufen Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 51, z.B Under The Sea, Castle Run, Stahlkopf, Panik Poopascoopa, Magic Heaven 2..';	  	
		}elseif(is_category('verschiedene-abenteuer-spiele')){
			$description='Die weitere Abenteuer Spiele kostenlos spielen. Alle Spiele: 51, z.B Prince Of Thomond, Tazs Tropical Havoc, Heart of the Planet, Indiana Jones..';	  	
		}elseif(is_category('sammeln-fliegen')){
			$description='Die Sammeln & Fliegen Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 31, z.B Flying Monkey, Blob Lander, Mk5 WorkBot, Umbrella Man..';
		}elseif(is_category('ausweichen-laufen')){
			$description='Die Ausweichen & Laufen Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 51, z.B Magic Heaven, Draw Play, Maus Trap, Jump Jim..';
		}elseif(is_category('springen-schiessen')){
			$description='Die Springen & Schießen Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 32, z.B Mille Dangers, Alien Attack, Mister Fox, Heavymetal Girl..';
		}elseif(is_category('fliegen-schiessen')){
			$description='Die Fliegen & Schießen Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 32, z.B Zunderfury, Cyberfish, Paper Warfare, Poofighter..';
		}elseif(is_category('spiderman-spiele')){
			$description='Die Spiderman-Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 32, z.B Spiderman Motobike, Spiderman Rush, Spiderman Memory..';
		}elseif(is_category('geister-spiele')){
			$description='Die Geister Spiele aus Kategorie Abenteuer Spiele kostenlos spielen. Alle Spiele: 32, z.B Ghost, Cyberfish, The Haunted House, Rescue Bear 2, Spirit Guide..';
		}
		//für sub Rennspiele
		elseif(is_category('Autorennen Spiele')){
	  		$description='Die Autorennen Spiele kostenlos spielen, Alle Spiele: 47, z.B Atomic Racer,Skid MK,Puppy Racing,Dragonball Kart,Raccoon Crash,4 Wheel Madness Spiele';	
	  	}elseif(is_category('Boot Rennen Spiele')){
	  		$description='Die Boot Rennen Spiele kostenlos spielen, Alle Spiele: 4, z.B Jet Boat Racing, Jetski Mario, Mini Wave, King of Power Spiele';	
	  	}elseif(is_category('Motocross Spiele')){
	  		$description='Die Motocross Spiele kostenlos spielen, Alle Spiele: 10, z.B Motocross FMX,Dare Devil,Obama Rider,Uphill Rush 3,Winter Rider Spiele';	
	  	}elseif(is_category('Motorrad Spiele')){
	  		$description='Die Motorrad Spiele kostenlos spielen, Alle Spiele: 11, z.B Neon Rennfahrer,Motorradrennen,Speed Motor,Manic Rider,Motorcycle Racer Spiele';	
	  	}elseif(is_category('verschiedene-rennspiele')){
	  		$description='Die Weitere Spiele aus Kategorie Autorennen kostenlos spielen, Alle Spiele: 12, z.B Crazy Ride Spiele, Crazy Mustang Spiele und weitere Autorennen Spiele';	
	  	}elseif(is_category('rallye')){
	  		$description='Die Rallye Spiele kostenlos spielen, Alle Spiele: 12, z.B 3D Rally Fever, Desert Race, Italy Rally, Rally Experts..';	
	  	}elseif(is_category('formel-1')){
	  		$description='Die Formel-1 Spiele kostenlos spielen, Alle Spiele: 12, z.B F1 Jigsaw, Formula Legend, Grand Prix Racer, Formula Off-Road..';	
	  	}elseif(is_category('zug-spiele')){
	  		$description='Die Zug Spiele kostenlos spielen, Alle Spiele: 21, z.B Railway Valley Missions, West Train, Railroad Collapse, Joe Minor Adventure..';	
	  	}elseif(is_category('quad-spiele')){
	  		$description='Die Quad Spiele kostenlos spielen, Alle Spiele: 21, z.B Moto Rush 2, Squad Car Racer, Ride For Ryder, Desert Buggy..';	
	  	}elseif(is_category('karting')){
	  		$description='Die Karting Spiele kostenlos spielen, Alle Spiele: 6, z.B Kart Racing, Never Kart, Raccoon Racing, Kore Karts..';	
	  	}elseif(is_category('pimp-my-ride')){
	  		$description='Die Pimp-My-Ride Spiele kostenlos spielen, Alle Spiele: 20, z.B Pimp my Sleigh, Costomize your Ride, Create a Ride 2..';	
	  	}
	  	//für sub Sportspiele
		elseif(is_category('Fußball Spiele')){
	  		$description='Die Fußball Spiele kostenlos spielen, Alle Spiele: 20, z.B Elfmeter Duell,Free Kick Fußball,Weltmeister,Bundesliga Elfmeter Spiele';	
	  	}elseif(is_category('Basketball Spiele')){
	  		$description='Die Basketball Spiele kostenlos spielen, Alle Spiele: 10, z.B Tierisches Basketball,Basketball-Freunde,Perfekte Würfe,1 gegen 1 Basketball Spiele';	
	  	}elseif(is_category('Billard Spiele')){
	  		$description='Die Billard Spiele kostenlos spielen, Alle Spiele: 11, z.B Super Billard,3D Billard,Billiard Blitz,Master Snooker Spiele';	
	  	}elseif(is_category('Bowling Spiele')){
	  		$description='Die Bowling Spiele kostenlos spielen, Alle Spiele: 5, z.B League Bowling, Bowling Master und weitere Bowling Spiele';	
	  	}elseif(is_category('Boxen Spiele')){
	  		$description='Die Boxen Spiele kostenlos spielen, Alle Spiele: 4, z.B Kämpfende Kühe, Boxturnier, Side Ring Knockout, Rocky Box Spiele';	
	  	}elseif(is_category('Ski Spiele')){
	  		$description='Die Ski Spiele kostenlos spielen, Alle Spiele: 16, z.B Wasser Ski,Rooftop Skater,Skateboy,3D Snowboarden, Downhill Joe Spiele';	
	  	}elseif(is_category('Golf Spiele')){
	  		$description='Die Golf Spiele kostenlos spielen, Alle Spiele: 8, z.B Tiny Golf,Mini Putt 2,Golf Ace,Golf Jam,Chester Golf Spiele';	
	  	}elseif(is_category('Tennis Spiele')){
	  		$description='Die Tennis Spiele kostenlos spielen, Alle Spiele: 12, z.B DaBomb Pong,Grandslam Tennis,Table Tennis Championship,Twisted Tennis,Beach Tennis Spiele';	
	  	}elseif(is_category('skate-spiele')){
	  		$description='Die Skate Spiele kostenlos spielen, Alle Spiele: 12, z.B Hungry Mice Skateboarding, Rockete Skateboard, Skate Mania, Skate Duck..';	
	  	}elseif(is_category('verschiedene-sport-spiele')){
	  		$description='Die weitere Spiele aus Kategorie Sportspiele kostenlos spielen, Alle Spiele: 21, z.B BMX Master,Pinch Hitter,Freeshot Master,Madpet Volleybomb Spiele';
	  	}
		//für weitere Spiele category
	  	elseif(is_category('2 Spieler')){
	  		$description='Die 2 Spieler Spiele kostenlos spielen, Alle Spiele: 110, z.B Warriors and Archers, Penguin Wars, Sexy Billiards 8 Ball, Street Fighter II Flash..';	
	  	}elseif(is_category('Farm-Spiele')){
	  		$description='Die Farm-Spiele kostenlos spielen, Alle Spiele: 174, z.B Hidden Stars Farm, Farm Connect 4, Strawberry Farm, Farmhouse Decor..';	
	  	}elseif(is_category('Ritter')){
	  		$description='Die Ritter Spiele kostenlos spielen, Alle Spiele: 132, z.B Dark Knight Rider, The Black Knight, Knight Elite, Bomber Knight..';	
	  	}elseif(is_category('weitere')){
	  		$description='Die Weitere Spiele kostenlos spielen, Alle Spiele: 132, z.B Shopping Street, Kindergarten, Box Office, Tapaszeit, Spielhaus..';	
	  	}elseif(is_category('kinderspiele')){
	  		$description='Die Kinderspiele kostenlos spielen, Alle Spiele: 13, z.B Indische Musikbox, Cooler Junge, Neujahrs-Deko, Weihnachts- Grüße..';	
	  	}elseif(is_category('zeitmanagement-spiele')){
	  		$description='Die Zeitmanagement Spiele kostenlos spielen, Alle Spiele: 13, z.B Doll House Builder, Flower Shop Fortune, Total Noobie Training, Schokoladenfabrik..';	
	  	}
		//für Tiere & Cartoon category
	  	elseif(is_category('tiere-cartoon')){
	  		$description='Die Tiere & Cartoon Spiele kostenlos spielen, Alle Spiele: 110, z.B Kätze, Hunde, Penguin, Ratte, Naruto, Drache, Mickey, Tom & Jerry und viele mehr';	
	  	}elseif(is_category('hunde-spiele')){
	  		$description='Die Hunde-Spiele kostenlos spielen, Alle Spiele: 13, z.B Destructo Dog, Dog Championship, Hunderennen, Pet Animals Spot The Difference Game ..';	
	  	}elseif(is_category('penguin-spiele')){
	  		$description='Die Penguin Spiele kostenlos spielen, Alle Spiele: 16, z.B Penguin Jump, Penguin Slice, Penguin Destroyer, Ice Breakers Game..';	
	  	}elseif(is_category('delfin-spiele')){
	  		$description='Die Delfin Spiele kostenlos spielen, Alle Spiele: 18, z.B Dolphin Ball 2, Dolphin Match, Hidden Numbers-Dolphin Tale, My Dolphin Show 2..';	
	  	}elseif(is_category('drache-spiele')){
	  		$description='Die Drache Spiele kostenlos spielen, Alle Spiele: 15, z.B Dragon Pants 2, Dragon Hunt, Heroes vs Dragons, Dragon Journey..';	
	  	}elseif(is_category('haehnchen-spiele')){
	  		$description='Die Hähnchen Spiele kostenlos spielen, Alle Spiele: 13, z.B Cycling Challenges, Hencock, Hühner vs Hunde, Hen Coops ..';	
	  	}elseif(is_category('fischspiele')){
	  		$description='Die Fischspiele kostenlos spielen, Alle Spiele: 14, z.B Fish Tales, Franky der Fisch 2, Fortune Fishing 2, Fisher Boy..';	
	  	}elseif(is_category('mickey-spiele')){
	  		$description='Die Mickey Spiele kostenlos spielen, Alle Spiele: 13, z.B Mickey in Vacation Dress up, Set the Blocks Road Rally, Mickey and Santa Christmas ..';	
	  	}elseif(is_category('katze-spiele')){
	  		$description='Die Katze Spiele kostenlos spielen, Alle Spiele: 13, z.B Lady Kitty Escape, Pet Pals, Fantastische Katze, Nurse Kitten Chan Dress Up ..';	
	  	}elseif(is_category('ratte-spiele')){
	  		$description='Die Ratte Spiele kostenlos spielen, Alle Spiele: 13, z.B Rats, Funny Ratsm Vermiator, Cheese Hunt, Coahuila Libre y Seguro..';	
	  	}elseif(is_category('elefanten-spiele')){
	  		$description='Die Elefanten Spiele kostenlos spielen, Alle Spiele: 13, z.B Jungle Hidden Object, War Elephant, Dumbolf, Draw my Elephant..';	
	  	}elseif(is_category('haehnchen-spiele')){
	  		$description='Die Hähnchen Spiele kostenlos spielen, Alle Spiele: 15, z.B Cycling Challenges, Hen Coops Game, Hühnerkorb, Hühner vs Hunde..';	
	  	}elseif(is_category('biene-spiele')){
	  		$description='Die Biene Spiele kostenlos spielen, Alle Spiele: 15, z.B Copy N Paste, Chips Balloon Ride, Bear vs Bee, Honey Bees..';	
	  	}elseif(is_category('donald-duck')){
	  		$description='Die Donald Duck Spiele kostenlos spielen, Alle Spiele: 15, z.B Donald Duck, Disney Memory Game, Mickey Mouse Jigsaw..';	
	  	}elseif(is_category('baeren-spiele')){
	  		$description='Die Bären Spiele kostenlos spielen, Alle Spiele: 17, z.B Teddy Run, Honey Bear, Feed the Bear, Hungry Bears..';	
	  	}elseif(is_category('fischspiele')){
	  		$description='Die Fischspiele kostenlos spielen, Alle Spiele: 15, z.B Fish Tales, Franky der Fisch 2, Fisher Boy, Fortune Fishing 2..';	
	  	}elseif(is_category('hamster-spiele')){
	  		$description='Die Hamster Spiele kostenlos spielen, Alle Spiele: 15, z.B Hamster Love, Hamster Adoption, Hamsterz Superstarz..';	
	  	}elseif(is_category('loewen-spiele')){
	  		$description='Die Löwen Spiele kostenlos spielen, Alle Spiele: 15, z.B Forest Decor, Seasons, The Lion King Jigsaw, The Champion Of Briscola..';	
	  	}elseif(is_category('insekten-spiele')){
	  		$description='Die Insekten Spiele kostenlos spielen, Alle Spiele: 15, z.B Pest Beat, Chili em All, Insectonator, Insects TD, Leaf Rider..';	
	  	}elseif(is_category('naruto-spiele')){
	  		$description='Die Naruto Spiele kostenlos spielen, Alle Spiele: 15, z.B Naruto MotoCross Race, Naruto Monster Car 2, Naruto Kage Bunshinno Jutsu..';	
	  	}elseif(is_category('tom-jerry')){
	  		$description='Die Tom & Jerry Spiele kostenlos spielen, Alle Spiele: 15, z.B Tom N Jerry Frenzy, Toms Trapo Matic, Tom N Jerry Iceballs..';	
	  	}elseif(is_category('mickey-spiele')){
	  		$description='Die Mickey Spiele kostenlos spielen, Alle Spiele: 15, z.B Mickey Family, Mickey in Vacation, Mickey and Santa Christmas..';	
	  	}

  	}elseif(is_date()){
			if ( is_day() ) {
				$description ='Die Kostenlose Spiele am '. get_the_time('F jS, Y').' auf http://www.kostenlosspielen.biz | ';
				$canonical=get_the_time('Y').'/'.get_the_time('m').'/'.get_the_time('d');  
			}elseif ( is_month() ) {
				$description ='Die Kostenlose Spiele am '. get_the_time('F, Y').' auf http://www.kostenlosspielen.biz | ';
				$canonical=get_the_time('Y').'/'.get_the_time('m');				
			}elseif ( is_year() ) {
				$description ='Kostenlose Spiele am '. get_the_time('Y').' auf http://www.kostenlosspielen.biz | ';
				$canonical=get_the_time('Y');					
			}
        	echo '<link rel="canonical" href="'.get_bloginfo('home').'/'.$canonical.'" />' . "\n";
	 }
  }elseif(is_search()){
  	  $search_var = get_query_var( 's' );
  	  echo '<meta name="keywords" content="'.$search_var.', kostenlos spielen, kostenlose spiele" />'. "\n";
  	  $description='Suchergebnisse nach '.ucfirst($search_var).' kostenlose Spiele auf www.kostenlosspielen.biz';
  }
  echo '<meta name="description" content="'.$description.'" />' . "\n";
  
}

//add_filter('sanitize_title', 'remove_false_words');
/*function remove_false_words($slug) {
    if (!is_admin()) return $slug;
    $slug = explode('-', $slug);
    foreach ($slug as $k => $word) {
        //false words list separated for commas
        $keys_false = 'aber,als,am,an,auch,auf,aus,bei,bin,bis,ist,da,dadurch, daher,darum,das,daß,dass,dein,deine,dem,den,der,des, dessen,deshalb,die,dies,dieser,dieses,doch,dort,du,durch, ein,eine, einem,einen,einer,eines,er,es,euer,eure,für,hatte, hatten,hattest,hattet,hier, hinter,ich,ihr,ihre,im,in,ist, ja,jede,jedem,jeden,jeder ,jedes,jener,jenes,jetzt ,kann,kannst, können,könnt,machen,mein,meine,mit,muß,mußt,musst,müssen, müßt,nach,nachdem,nein,ncht,nun,oder,seid,sein,seine,sich,sie, sind,soll,sollen,sollst,sollt,sonst,soweit,sowie,und,unser unsere,unter,vom,von,vor,wann,warum,was, weiter,weitere,wenn,wer,werde,werden,werdet,weshalb,wie, wieder,wieso,wir,wird,wirst,wo,woher,wohin,zu,zum,zur,über,a, able, about, above, abroad, according, accordingly, across, actually, adj, after, afterwards, again, against, ago, ahead, all, allow, allows, almost, alone, along, alongside, already, also, although, always, am, amid, amidst, among, amongst, an, and, another, any, anybody, anyhow, anyone, anything, anyway, anyways, anywhere, apart, appear, appreciate, appropriate, are, around, as,  aside, ask, asking, associated, at, available, away, awfully, b, back, backward, backwards, be, became, because, become, becomes, becoming, been, before, beforehand, begin, behind, being, believe, below, beside, besides, best, better, between, beyond, both, brief, but, by, c, came, can, cannot, cant, caption, cause, causes, certain, certainly, changes, clearly, co, com, come, comes, concerning, consequently, consider, considering, contain, containing, contains, corresponding, could, course, currently, d, dare, definitely, described, despite, did, different, directly, do, does, doing, done, down, downwards, during, e, each, edu, eg, eight, eighty, either, else, elsewhere, end, ending, enough, entirely, especially, et, etc, even, ever, evermore, every, everybody, everyone, everything, everywhere, ex, exactly, example, except, f, fairly, far, farther, few, fewer, fifth, first, five, followed, following, follows, for, forever, former, formerly, forth, forward, found, four, from, further, furthermore, g, get, gets, getting, given, gives, go, goes, going, gone, got, gotten, greetings, h, had, half, happens, hardly, has, have, having, he, hello, help, hence, her, here, hereafter, hereby, herein, hereupon, hers, herself, hi, him, himself, his, hither, hopefully, how, howbeit, however, hundred, i, ie, if, ignored, immediate, in, inasmuch, inc, inc., indeed, indicate, indicated, indicates, inner, inside, insofar, instead, into, inward, is, it, its, itself, j, just, k, keep, keeps, kept, know, known, knows, l, last, lately, later, latter, latterly, least, less, lest, let, like, liked, likely, likewise, little, look, looking, looks, low, lower, ltd, m, made, mainly, make, makes, many, may, maybe, me, mean, meantime, meanwhile, merely, might, mine, minus, miss, more, moreover, most, mostly, mr, mrs, much, must, my, myself, n, name, namely, nd, near, nearly, necessary, need, needs, neither, never, neverf, neverless, nevertheless, new, next, nine, ninety, no, nobody, non, none, nonetheless, noone, no-one, nor, normally, not, nothing, notwithstanding, novel, now, nowhere, o, obviously, of, off, often, oh, ok, okay, old, on, once, one, ones, only, onto, opposite, or, other, others, otherwise, ought, our, ours, ourselves, out, outside, over, overall, own, p, particular, particularly, past, per, perhaps, placed, please, plus, possible, presumably, probably, provided, provides, q, que, quite, qv, r, rather, rd, re, really, reasonably, recent, recently, regarding, regardless, regards, relatively, respectively, right, round, s, said, same, saw, say, saying, says, second, secondly, see, seeing, seem, seemed, seeming, seems, seen, self, selves, sensible, sent, serious, seriously, seven, several, shall, she, should, since, six, so, some, somebody, someday, somehow, someone, something, sometime, sometimes, somewhat, somewhere, soon, sorry, specified, specify, specifying, still, sub, such, sup, sure, t, take, taken, taking, tell, tends, th, than, thank, thanks, thanx, that, thats, the, their, theirs, them, themselves, then, thence, there, thereafter, thereby, therefore, therein, theres, thereupon, these, they, thing, things, think, third, thirty, this, thorough, thoroughly, those, though, three, through, throughout, thru, thus, till, to, together, too, took, toward, towards, tried, tries, truly, try, trying, twice, two, u, un, under, underneath, undoing, unfortunately, unless, unlike, unlikely, until, unto, up, upon, upwards, us, used, useful, uses, using, usually, v, value, various, versus, very, via, viz, vs, w, want, wants, was, way, we, welcome, well, went, were, what, whatever, when, whence, whenever, where, whereafter, whereas, whereby, wherein, whereupon, wherever, whether, which, whichever, whilst, whither, who, whoever, whole, whom, whomever, whose, why, will, willing, wish, with, within, without, wonder, y, yes, yet, you, your, yours, yourself, yourselves, z, try, zero,the,a,able,about,across,after,all,almost,also,am,among,an,and,any,are,as,at,be,because,been,but,by,can,cannot,could,dear,did,do,does,either,else,ever,every,for,from,get,got,had,has,have,he,her,hers,him,his,how,however,i,if,in,into,is,it,its,just,least,let,like,likely,may,me,might,most,must,my,neither,no,nor,not,of,off,often,on,only,or,other,our,own,rather,said,say,says,she,should,since,so,some,than,that,the,their,them,then,there,these,they,this,tis,to,too,twas,us,wants,was,we,were,what,when,where,which,while,who,whom,why,will,with,would,yet,you,your';
        $keys = explode(',', $keys_false);
        foreach ($keys as $l => $wordfalse) {
            if ($word==$wordfalse) {
            unset($slug[$k]);
            }
        }
    }
    return implode('-', $slug);
} */ 
### Function: Calculate Post Views
add_action('wp_head', 'caculate_postviews');
function caculate_postviews() {
		global $post, $wpdb;
		$postID=(int)$post->ID;
        if(!$postID) {
            return;
        }
    //$custom = get_post_custom($postID);
			// find the view count field
			//if(!is_admin()) {		print_r($custom);	}
			//$views = intval($custom['pvc_views'][0]);
			$views = $wpdb->get_var( "SELECT game_views FROM kostenlosspielen_posts WHERE ID=$postID" );
			//if(!is_admin()) {		echo($views);	}
			// increment the count
			if($views > 0) {
				//update_post_meta($postID, 'pvc_views', ($views + 1));	
				$wpdb->update( 'kostenlosspielen_posts', array('game_views' => ($views + 1)),array( 'ID' => $postID ));					
			} else {
				//add_post_meta($postID, 'pvc_views', 1, true);
				$wpdb->update( 'kostenlosspielen_posts', array('game_views' => 1),array( 'ID' => $postID ));									
			}
}
add_action('save_post', 'generateImages');
function generateImages(){
	global $current_user;
	global $post, $wpdb;
	$postid=(int)$post->ID;
	$current_user = wp_get_current_user();
	//echo 'test generate:'.$postid;
	if($current_user->ID==53){
	//$image_url=get_post_meta($postid,'image', true);
	$image_url = $wpdb->get_var( "SELECT game_image FROM kostenlosspielen_posts WHERE ID=$postid" );
	$image_absolute=SITE_ROOT_DIR.wp_make_link_relative($image_url);
	//echo $image_absolute;
	$image_absolute_path=dirname($image_absolute);
	$image=getNameOfImage($image_url);
	createthumb($image_absolute,$image_absolute_path.'/'.$image['name'].'-100.'.$image['type'], 100, 75);
	createthumb($image_absolute,$image_absolute_path.'/'.$image['name'].'-75.'.$image['type'], 75, 57);		
	//update category
	$post_categories = wp_get_post_categories( $post->ID );
		foreach($post_categories as $c){
				$cat = get_category( $c );
				if($cat->parent >0){
					$category1=$cat->parent;
					$category2=$cat->cat_ID;
					$wpdb->update( 'kostenlosspielen_posts', array( 'category1' => $category1,'category2' => $category2	),array( 'ID' => $post->ID ));					
				}
		}						
	}
}
function replaceImages($image_url, $last){
	$pos=strrpos($image_url,'/');
	$path=substr($image_url,0, $pos);
	$image=substr($image_url,$pos+1);
	$image=getNameOfImage($image_url);
	return $path.'/'.$image['name'].'-'.$last.'.'.$image['type'];
}
//Create thumbnail image by php
function createthumb($source_image,$destination_image_url, $get_width, $get_height){
	ini_set('memory_limit','512M');
	set_time_limit(0);

    //Trim image
    $index = strpos($source_image, '?');
    if($index && $index > 0) {
        $source_image = substr($source_image, 0, $index);
    }

	$image_array = explode('/',$source_image);
	$image_name = $image_array[count($image_array)-1];
	$max_width     = $get_width;
	$max_height =$get_height;
	if($max_width==100){
		$quality = 85;
	}else{
		$quality = 80;
	}

	//Set image ratio
	list($width, $height) = getimagesize($source_image);
    if($width <= 0 && $height <= 0) {
        echo 'unable to load image source';
        return;
    }
	$ratio = ($width > $height) ? $max_width/$width : $max_height/$height;
	$ratiow = $width/$max_width ;
	$ratioh = $height/$max_height;
	$ratio = ($ratiow > $ratioh) ? $max_width/$width : $max_height/$height;

	if($width > $max_width || $height > $max_height) {
		$new_width = $width * $ratio;
		$new_height = $height * $ratio;
	} else {
		$new_width = $width;
		$new_height = $height;
	}

	if (preg_match("/.jpg/i","$source_image") or preg_match("/.jpeg/i","$source_image")) {
		//JPEG type thumbnail
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($source_image);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagejpeg($image_p, $destination_image_url, $quality);
		imagedestroy($image_p);

	} elseif (preg_match("/.png/i", "$source_image")){
		//PNG type thumbnail
		$im = imagecreatefrompng($source_image);
		$image_p = imagecreatetruecolor ($new_width, $new_height);
		imagealphablending($image_p, false);
		imagecopyresampled($image_p, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagesavealpha($image_p, true);
		imagepng($image_p, $destination_image_url);

	} elseif (preg_match("/.gif/i", "$source_image")){
		//GIF type thumbnail
		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromgif($source_image);
		$bgc = imagecolorallocate ($image_p, 255, 255, 255);
		imagefilledrectangle ($image_p, 0, 0, $new_width, $new_height, $bgc);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagegif($image_p, $destination_image_url, $quality);
		imagedestroy($image_p);

	} else {
		echo 'unable to load image source';
		exit;
	}
}
function getNameOfImage($url){
	//$url='http://www.kostenlosspielen.biz/wp-content/uploads/2012/09/cinema-decoration.gif';
	$pos= strrpos($url,'/');
	$image=substr($url,$pos+1);
	list($images['name'], $images['type']) = split('[.]',$image);
	return $images;
}
global $post, $wpdb;
remove_action('wp_head', 'rel_canonical');
// Register the column
function price_column_register( $columns ) {
	$columns['views'] = __( 'Views', 'my-plugin' );
	return $columns;
}
add_filter( 'manage_edit-post_columns', 'price_column_register' );

// Display the column content
function price_column_display( $column_name, $post_id ) {
	if ( 'views' != $column_name )	return;
	global $wpdb;
	$sql="SELECT game_views FROM kostenlosspielen_posts WHERE ID = ".$post_id;
	echo number_format($wpdb->get_var($sql),0,',','.');
	//echo $wpdb->get_var($sql);
}
// Register the column as sortable
function price_column_register_sortable( $columns ) {
    $columns['views'] = 'views';

    return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'price_column_register_sortable' );
add_action( 'manage_posts_custom_column', 'price_column_display', 10, 2 );

function mam_posts_fields ($fields) {
   global $mam_global_fields;
   // Make sure there is a leading comma
   if ($mam_global_fields) $fields .= (preg_match('/^(\s+)?,/',$mam_global_fields)) ? $mam_global_fields : ", $mam_global_fields";
   return $fields;
}
function mam_posts_join ($join) {
   global $mam_global_join;
   if ($mam_global_join) $join .= ' ' . $mam_global_join;
   return $join;
}
function mam_posts_where ($where) {
   global $mam_global_where;
   if ($mam_global_where) $where .= ' ' . $mam_global_where;
   return $where;
}
function mam_posts_orderby ($orderby) {
   $orderby=$_GET['orderby'];
   $order=$_GET['order'];
	if($_GET['orderby']==NULL){
		$orderby = 'post_date DESC';
	}
   if ( $orderby=='views') {
		$orderby = 'game_views '.$order;
   }  
   return $orderby;
}
add_filter('posts_orderby','mam_posts_orderby');


//if (!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
//}
/*function social_connect_login_header($return = false) {
    $isUserLoggedIn = is_user_logged_in();

    $html = array();

    if($isUserLoggedIn) {

    } else {
        //IF user is not login

        $images_url = SOCIAL_CONNECT_PLUGIN_URL . '/media/img/';

        $html[] = '<li class="current-user">';
        $html[] = ' <img src="'.SOCIAL_CONNECT_PLUGIN_URL.'/media/img/default_avatar.gif" />';
        $html[] = ' <a href="javascript:void(0);">';
        $html[] = '     <span>Gast</span>';
        $html[] = ' </a>';
        $html[] = '</li>';

        $html[] = '<li class="signin">';
        $html[] = ' <a id="social_connect_register_link" class="register social-connect-register-link" href="javascript:void(0)">';
        $html[] = '     Kostenlos registrieren';
        $html[] = ' </a>';
        $html[] = ' <span>';
        $html[] = '     orer';
        $html[] = ' </span>';
        $html[] = ' <a id="social_connect_login_link" class="login social-connect-login-link" href="javascript:void(0)">';
        $html[] = '     Anmelden';
        $html[] = ' </a>';
        $html[] = '</li>';

        //Login and register form
        $html[] = '<li>';
        //Login form
        $html[] = ' <form id="social_connect_login_form_modal" action="'.wp_login_url().'" method="POST" class="social-connect-login" style="display: none">';
        //$html[] = '     <h3>Login</h3>';
        $html[] = '     <p>';
        $html[] = '         <label>Username:</label>';
        $html[] = '         <br/>';
        $html[] = '         <input type="text" name="log" id="user_login" class="input" placeholder="Username" />';
        $html[] = '     </p>';
        $html[] = '     <p>';
        $html[] = '         <label>Password:</label>';
        $html[] = '         <br/>';
        $html[] = '         <input type="password" name="pwd" id="user_pass" class="input" placeholder="Password" />';
        $html[] = '     </p>';
        $html[] = '     <p class="submit">';
        $html[] = '         <input type="submit" class="button button-primary button-large" value="Login" placeholder="Password" />';
        $html[] = '         <input type="hidden" name="redirect_to" value="'.get_permalink().'"/>';
        $html[] = '     </p>';
        $html[] = '     <p class="nav-link">';
        $html[] = '         <a href="javascript:void(0)">';
        $html[] = '             Lost your password';
        $html[] = '         </a>';
        $html[] = '     </p>';
        $html[] = ' </form>';
        $html[] = '</li>';

        $html[] = '<li class="social-connect-login">';
        $html[] = ' <a href="javascript:void(0);" title="Facebook" class="social_connect_login_facebook">';
        $html[] = '     <img width="20px" alt="Facebook" src="'.$images_url.'facebook_32.png" />';
        $html[] = ' </a>';
        $html[] = ' <a href="javascript:void(0);" title="Twitter" class="social_connect_login_twitter">';
        $html[] = '     <img width="20px" alt="Twitter" src="'.$images_url.'twitter_32.png" />';
        $html[] = ' </a>';
        $html[] = ' <a href="javascript:void(0);" title="Google" class="social_connect_login_google">';
        $html[] = '     <img width="20px" alt="Google" src="'.$images_url.'google_32.png" />';
        $html[] = ' </a>';
        $html[] = '</li>';

        $html[] = '<li style="display: none">';
        $html[] = ' <div id="social_connect_facebook_auth">';
        $html[] = '	    <input type="hidden" name="client_id" value="'.get_option( 'social_connect_facebook_api_key' ).'" />';
        $html[] = '	    <input type="hidden" name="redirect_uri" value="'. urlencode( SOCIAL_CONNECT_PLUGIN_URL . '/facebook/callback.php' ).'" />';
        $html[] = ' </div>';
        $html[] = ' <div id="social_connect_twitter_auth">';
        $html[] = '     <input type="hidden" name="redirect_uri" value="'.SOCIAL_CONNECT_PLUGIN_URL . '/twitter/connect.php" />';
        $html[] = ' </div>';
        $html[] = ' <div id="social_connect_google_auth">';
        $html[] = '     <input type="hidden" name="redirect_uri" value="'.SOCIAL_CONNECT_PLUGIN_URL . '/google/connect.php" />';
        $html[] = ' </div>';
        $html[] = '</li>';

        $html[] = '<li style="">';
        $html[] = ' <form action="'.wp_login_url(get_permalink()).'" method="POST" id="social_connect_modal" class="social-connect-login" style="display: none">';
//        $html[] = '     <h3>';
//        $html[] = '         Continue register with social account';
//        $html[] = '     </h3>';
        $html[] = '     <div class="error hidden" style="display: none">';
        $html[] = '         <ul class="error-list">';
        $html[] = '         </ul>';
        $html[] = '     </div>';
        $html[] = '     <p>';
        $html[] = '         <label>';
        $html[] = '             Username:';
        $html[] = '         </label>';
        $html[] = '         <span class="form-error-label" id="username-error"></span>';
        $html[] = '         <input type="text" class="input-error" id="username" name="username" placeholder="Choose your username"/>';
        $html[] = '     </p>';
        $html[] = '     <p class="pemail">';
        $html[] = '         <label>';
        $html[] = '             Email:';
        $html[] = '         </label>';
        $html[] = '         <span class="form-error-label" id="email-error"></span>';
        $html[] = '         <input type="text" name="social_email" placeholder="Your email"/>';
        $html[] = '     </p>';
        $html[] = '     <p>';
        $html[] = '         <label>';
        $html[] = '             Password:';
        $html[] = '         </label>';
        $html[] = '         <span class="form-error-label" id="password-error"></span>';
        $html[] = '         <input type="password" id="password" name="password" placeholder="Enter your password"/>';
        $html[] = '     </p>';
        $html[] = '     <p>';
        $html[] = '         <label>';
        $html[] = '             Enter password again:';
        $html[] = '         </label>';
        $html[] = '         <span class="form-error-label" id="password2-error"></span>';
        $html[] = '         <input type="password" id="password2" name="password2" placeholder="Re-enter your password"/>';
        $html[] = '     </p>';
        $html[] = '     <p>';
        $html[] = '         <input type="hidden" name="social_provider" value="" />';
        $html[] = '         <input type="hidden" name="social_provider_key" value="" />';
        $html[] = '         <input type="hidden" name="social_id" value="" />';
        $html[] = '         <input type="hidden" name="social_username" value="" />';
        //$html[] = '         <input type="hidden" name="social_email" value="" />';
        $html[] = '         <input type="hidden" name="social_link" value="" />';
        $html[] = '         <input type="hidden" name="social_name" value="" />';
        $html[] = '     </p>';
        $html[] = '     <p class="submit">';
        $html[] = '         <input type="submit" value="Register" />';
        $html[] = '     </p>';
        $html[] = ' </form>';
        $html[] = '</li>';
    }

    if($return) {
        return implode("\n", $html);
    } else {
        echo implode("\n", $html);
    }
}*/

function kos_comments($text) {
    ?>
    <div id="comments" class="box-with-border kos-comments">
        <h2 class="title"><?php echo $text; ?>: Kommantare</h2>
        <div class="body">
            <?php if(comments_open() && class_exists('KosComments')): ?>
            <?php
            $kosComments = KosComments::getInstance();
            $kosComments->init();
            if($kosComments->hasComments()):
            ?>
            <h5 class="list-comments-title">Beste Kommentare</h5>
            <ul class="standard-margin list-comments top-coments">
                <?php echo $kosComments->htmlListComments('li', true, 0, 2) ?>
            </ul>
            <?php endif; ?>
            <?php comment_form(array(
                'title_reply' => '',
                'must_log_in' => '<div class="commentsBox standard-margin container gamepage">
                                    <div class="wall_user_notlogged">
                                        <div class="text">Du musst angemeldet sein, um einen Kommentar zu posten!</div>
                                        <div class="buttons">
                                            <a href="#authentication_modal_form_register" rel="modal:open" class="common-bigger-button social-connect-register-link">
                                                <span class="left">KOSTENLOS ANMELDEN</span>
                                            </a>
                                            <span class="orlink"> oder
                                                <a href="#authentication_modal_form_login" rel="modal:open" class="plain social-connect-login-link">
                                                    Anmelden
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>',
                'logged_in_as' => '',
                'comment_notes_before' => '',
                'comment_notes_after' => '',
                //'comment_field'        => '<p class="comment-form-comment"><!--<label for="comment">' . _x( 'Your kommentare', 'noun' ) . '</label>--><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
                'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
            ));
            ?>
            <?php if(count($kosComments->getComments()) > 2): ?>
            <h5 class="list-comments-title">Alle Kommentare <span>(<?php echo $kosComments->getTotal() ?>)</span></h5>
            <?php endif; ?>
            <ul id="list-comments" class="standard-margin list-comments">
            <?php echo $kosComments->htmlListComments('li', true, 2, 0);?>
            </ul>
            <?php else : ?>
                <ul class="list-comments standard-margin">
                    <li class="no-comments">
                        There is no-comment yet, and comment for this game is close!
                    </li>
                </ul>
            <?php endif ?>
        </div>
        <div class="footer kos-comment-footer">
            <div class="kos-comment-paging">
                <div class="page-nav">
                    <?php if($kosComments) echo $kosComments->htmlPaging() ?>
                </div>
                <div class="page-info">
                    <p><?php if($kosComments) echo $kosComments->pagingDescription() ?></p>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var COMMENT_AJAX_URL = '<?php echo KOS_COMMENT_AJAX_URL ?>';
        var COMMENT_VOTE_URL = '<?php echo KOS_COMMENT_VOTE_URL?>';
        var POST_ID = <?php echo get_the_ID(); ?>;
        jQuery(document).ready(function($) {
            $('#comments').on('click', 'a.page',function(e) {
                var $target = $(e.target);
                var page = $target.attr('page');
                var data = {
                    postid: POST_ID,
                    page: page
                };
                $.ajax({
                    type: 'GET',
                    url: COMMENT_AJAX_URL,
                    data: data,
                    dataType: 'json',
                    error: function() {
                        alert("ajax error, please try again");
                    },
                    success: function(data) {
                        if(data.code == 200) {
                            var $comment = $('#comments');
                            $comment.find('ul#list-comments').html(data.htmlLists);
                            $comment.find('div.page-nav').html(data.htmlPaging);
                            $comment.find('div.page-info > p').html(data.htmlPagingInfo);
                        } else {
                            alert('data wrong');
                        }
                    }
                });
            });
            $('#comments').on('click', 'a.vote-action',function(e) {
                var $target = $(e.target);
                var $comment = $target.closest('li.li-kos-comment');

                var comment_id = $comment.attr('comment');
                var action = $target.attr('action');
                var data = {
                    id: comment_id,
                    action: action
                };

                //Set value
                var $voteValue = $comment.find('div.vote-value');
                var currentVote = parseInt($voteValue.attr('value'));
                if(action == 'dislike') {
                    currentVote--;
                } else {
                    currentVote++;
                }
                if(currentVote == 0) {
                    $voteValue.html('');
                } else {
                    $voteValue.html(currentVote < 0 ? '' + currentVote : '+' + currentVote);
                }

                //Process DOM
                $comment.find('a.vote-action').removeClass('vote-action');
                $comment.find('a.like').removeClass('like').addClass('like-disabled');
                $comment.find('a.dislike').removeClass('dislike').addClass('dislike-disabled');

                $.ajax({
                    type: 'GET',
                    url: COMMENT_VOTE_URL,
                    data: data,
                    dataType: 'json',
                    error: function() {
                        alert("vote error, please try again");
                    },
                    success: function(data) {
                        if(data.code == 200) {
                            var vote = data.vote;

                            $voteValue.attr('value', vote);
                            if(vote == 0) {
                                $voteValue.html('');
                            } else {
                                $voteValue.html(vote < 0 ? '' + vote : '+' + vote);
                            }
                        }
                    }
                });
            });
        });
    </script>
    <?php
}

add_action('wp', 'update_online_users_status');
function update_online_users_status() {
    if(is_user_logged_in()) {
        if(($loggedInUsers = get_transient('users_online')) === false) {
            $loggedInUsers = array();
        }
        $currentUser = wp_get_current_user();
        $currentUserId = $currentUser->ID;
        $currentTime = current_time('timestamp');

        if(!isset($loggedInUsers[$currentUserId]) || $loggedInUsers[$currentUserId] < ($currentTime - (15*60))) {
            $loggedInUsers[$currentUserId] = $currentTime;
            set_transient('users_online', $loggedInUsers, 30*60);
        }
    }
}

function is_user_online($userId) {
    $loggedInUsers = get_transient('users_online');
    return isset($loggedInUsers[$userId]) && $loggedInUsers[$userId] > (current_time('timestamp') - (15*60));
}

add_filter('single_template', 'custom_single_page_template');
function custom_single_page_template($single) {
    //global $post;
    //$CURRENT_DIR = dirname(__FILE__);

    //TODO: #nttuyen remove this function
    //return $template = $CURRENT_DIR.DIRECTORY_SEPARATOR.'single-1314.php';

    //$template = $CURRENT_DIR.DIRECTORY_SEPARATOR.'single-'.$post->ID.'.php';
    //if(file_exists($template)) {
    //    return $template;
    //}

    return $single;
}
function getTop10PopularGames($categoryid){
		global $post, $wpdb;

	$query = "SELECT * FROM kostenlosspielen_posts
			WHERE post_status = 'publish' AND post_type='post'
			AND category1=".$categoryid." ORDER BY game_views DESC LIMIT 10";
			//printf($query);
			$pageposts = $wpdb->get_results($query, ARRAY_A);
			$counter=0;
			$returnText= '';
  		    foreach ($pageposts as $post){
			$phpdate = strtotime( $post['post_date'] );
			$post_image=$post['game_image'];
			$returnText= $returnText.
							'<div class="category1_game_item">
								<a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="bookmark"><img src="'.$post_image.'" width="160" height="120" alt="'.$post['post_title'].'" title="'.$post['game_intro'].'" /></a>
								<div class="category1_game_item_text">
									<center><a title="'.$post['post_title'].'" href="'.SITE_ROOT_URL.'/'.$post['post_name'].'.html" rel="bookmark">'.$post['post_title'].'</a></center>
								</div>
							</div>';
			}
			$returnText =$returnText.'<div style="clear:both;height:10px;"></div>';
			
			return $returnText;
}

function getDateString($time) {
    $time = strtotime($time);
    $timeNow = strtotime('now');
    $dateNow = date('Y-m-d', $timeNow);
    $dateTime = date('Y-m-d', $time);

    $dayNow = intval(date('d'), $timeNow);
    $dayTime = intval(date('d', $time));
    $monthNow = intval(date('m'), $timeNow);
    $monthTime = intval(date('m', $time));
    $yearNow = intval(date('Y'), $timeNow);
    $yearTime = intval(date('Y', $time));

    if($dateNow == $dateTime) {
        return "Heute";
    } else if($dayNow - $dayTime <= 1 && $monthNow == $monthTime && $yearNow == $yearTime) {
        return "Gestern";
    }

    return date("d.m.Y", $time);
}


