<?php
/**
 * kos functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kos
 */

if ( ! function_exists( 'kos_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kos_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on kos, use a find and replace
	 * to change 'kos' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'kos', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'kos' ),
		'full' => esc_html__( 'Full Menu', 'kos' ),
		'footer-primary' => esc_html__( 'Footer Primary', 'kos' ),
		'footer-seconds' => esc_html__( 'Footer Seconds', 'kos' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'kos_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'kos_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kos_content_width', 640 );
}
add_action( 'after_setup_theme', 'kos_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kos_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kos' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'kos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tab Content', 'kos' ),
		'id'            => 'footer-tab-content',
		'description'   => esc_html__( 'Include Widget here', 'kos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Favorite Category Menu', 'kos' ),
		'id'            => 'fav-cat-menu',
		'description'   => esc_html__( 'Include Widget here', 'kos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s panel panel-default panel-bordered">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<div class="widget-title panel-heading board-header board-lg"><h4 class="panel-title"><i class="icon-cm icon-cm-medal"></i> ',
		'after_title'   => '</h4></div><div class="panel-body no-padding">',
	) );
}
add_action( 'widgets_init', 'kos_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kos_scripts() {
	//wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/bootstrap.min.css' );
	wp_enqueue_style( 'kos-style', get_stylesheet_uri() );

    //wp_enqueue_script( 'slickjs', get_template_directory_uri() . '/js/slick.min.js', array(), '1.6.0', true );
	wp_enqueue_script( 'swiper.min.js', get_template_directory_uri() . '/js/swiper.min.js', array(), '3.3.1', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.6', true );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array(), '1.0', true );
    wp_enqueue_script('kos-common', get_template_directory_uri() . '/js/kos-common.js', array(), '1.0', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kos_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
// require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
// require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/inc/jetpack.php';

/**
 * Hiden Admin Bar
 */
show_admin_bar( false );


function getAllSubCategoriesOf($categoryId, $number = 0) {
    if(empty($categoryId) || $categoryId <= 0) {
        return array();
    }
    $categories = get_categories(array(
        'parent' => $categoryId
    ));

    foreach($categories as &$category) {
        // Load custom field
        //$ordering = (int)get_field('category_order', $category);
        $ordering = 1;
        $category->order = $ordering;

        // Load newest game of each category
        $latestGames = wp_get_recent_posts(array(
            'numberposts' => 1,
            'category' => $category->cat_ID,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish'
        ), OBJECT);
        $category->latest_game = $latestGames[0];

        //. Count number game
        global $table_prefix, $wpdb;
        $sql = 'SELECT count(*) as count FROM '.$table_prefix.'term_relationships WHERE term_taxonomy_id = '.(int)$category->term_id;
        $category->nunber_games = $wpdb->get_var($sql);

    }

    // sort category then get limit:
    usort($categories, function($cat1, $cat2){
        if($cat1->order == $cat2->order) {
            return 0;
        }
        return $cat1->order > $cat2->order ? 1 : -1;
    });

    if($number && count($categories) > $number) {
        $categories = array_slice($categories, 0, $number);
    }

    return $categories;
}

function render_home_category($slug, $icon) {
    $category = get_category_by_slug($slug);
    $subCategories = getAllSubCategoriesOf($category->cat_ID, 10);
    ?>
    <div class="panel panel-default panel-bordered category-box-item">
        <div class="panel-heading board-header">
            <h4 class="panel-title" title="<?php echo $category->name ?>"><i class="icon-cat-sm icon-cat-sm-<?php echo strtolower($icon) ?>"></i> <span><?php echo $category->name ?></span></h4>
        </div>
        <div class="panel-body">
            <a class="image img-4x3" href="#">
                <img class="img-responsive" alt="<?php echo $subCategories[0]->name?>" src="<?php echo $subCategories[0]->latest_game->game_image ?>" />
            </a>
            <ul class="list-cat-ver clearfix">
                <?php foreach($subCategories as $subCategory):?>
                    <li>
                        <a title="<?php echo $subCategory->name ?>" href="<?php echo get_category_link($subCategory) ?>"
                           game-image="<?php echo $subCategory->latest_game->game_image ?>"
                           cat-name="<?php echo $subCategory->name?>"
                        >
                            <span class="name"><?php echo $subCategory->name ?></span> <span class="number"><?php echo $subCategory->nunber_games ?></span>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
            <div class="more-btn std-margin std-padding text-right">
                <a href="<?php echo get_category_link($category)?>" class="button btn-orange btn-large">Mehr Online Spiele <i class="fa fa-caret-right"></i></a>
            </div>
        </div>
    </div>
    <?php
}

function mytheme_comment($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body ">
    <?php endif; ?>
    <div class="comment-author vcard clearfix">
    	<div class="avatar-column">
	        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        	<?php printf( __( '<cite class="fn">%s</cite><div class="level">Level 78</div>' ), get_comment_author_link() ); ?>
    	</div>
    	<div class="comment-column">
		    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"></a>
		    </div>
		    <?php comment_text(); ?>
		    <div class="reply">
		        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		    </div>
		    <?php edit_comment_link( __( '(Edit)' ), '  ', '' );?>
    	</div>
    </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
          <br />
    <?php endif; ?>

    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
    <?php
    }

function debug($var) {
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

add_filter('category_template', 'kos_custom_category_template');
function kos_custom_category_template($template) {
    $category = get_queried_object();
    $categories = get_categories(array(
        'parent' => $category->cat_ID
    ));
    if (empty($categories)) {
        return locate_template('category.php');
    } else {
        return locate_template('category-has-sub.php');
    }
}

function numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation text-center"><ul class="pagination">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li><span>…</span></li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></div>' . "\n";

}
