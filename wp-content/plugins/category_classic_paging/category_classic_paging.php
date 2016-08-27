<?php
/*
Plugin Name: Category classic paging
Plugin URI: http://www.kostenlosspielen.biz/
Description: Display List of Games' category in footer.
Author: Nguyen The Tuyen
*/

$CATEGORY_ORDER_PARAMS = array(
    //'mostview' => 'view',
    'am-neuesten-spiele' => 'new',
    'best-bewertete-spiele' => 'best',
    'meist-bewertete-spiele'  => 'vote',
    'meist-gespielt' => 'most'
);
$CATEGORY_ORDER_PARAMS_INVERSE = array(
    //'mostview' => 'view',
    'new' => 'am-neuesten-spiele',
    'best' => 'best-bewertete-spiele',
    'vote'  => 'meist-bewertete-spiele',
    'most' => 'meist-gespielt'
);
define('PAGE', 'seite');

require_once dirname(__FILE__).'/Category.php';

function add_missing_meta_field() {
    global $table_prefix;
    global $wpdb;

    // Missing ratings_users
    $sql = "SELECT p.ID FROM ".$table_prefix."posts p where not exists (select * from ".$table_prefix."postmeta m where m.post_id = p.ID and m.meta_key = 'ratings_users') and p.post_type = 'post'";
    $items = $wpdb->get_results($sql, ARRAY_A);
    foreach($items as $item) {
        $wpdb->insert( $table_prefix.'postmeta', array('post_id' => $item['ID'], 'meta_key' => 'ratings_users', 'meta_value' => 0), array('%d', '%s', '%d'));
    }

    // Missing ratings_users
    $sql = "SELECT p.ID FROM ".$table_prefix."posts p where not exists (select * from ".$table_prefix."postmeta m where m.post_id = p.ID and m.meta_key = 'ratings_average') and p.post_type = 'post'";
    $items = $wpdb->get_results($sql, ARRAY_A);
    foreach($items as $item) {
        $wpdb->insert( $table_prefix.'postmeta', array('post_id' => $item['ID'], 'meta_key' => 'ratings_average', 'meta_value' => 0), array('%d', '%s', '%f'));
    }
}

function category_classic_paging_pagination_base() {
    global $wp_rewrite;
    $wp_rewrite->pagination_base = PAGE;
    $wp_rewrite->comments_pagination_base = 'comment-'.PAGE;
}
add_action( 'init', 'category_classic_paging_pagination_base' );

add_action('init', 'category_classic_paging_page_permalink', -1);
function category_classic_paging_page_permalink() {
    global $wp_rewrite;
    $pageStructure = $wp_rewrite->get_page_permastruct();
    if (!$pageStructure) {
        return;
    }
    $strlen = strlen('.html');
    if (strlen($pageStructure) < $strlen) {
        $pageStructure .= '.html';
    } else if (substr_compare($pageStructure, '.html', strlen($pageStructure)-strlen($pageStructure), $strlen) !== 0) {
        $pageStructure .= '.html';
    }

    $wp_rewrite->page_structure = $pageStructure;
}

add_filter('category_rewrite_rules', 'category_classic_paging_category_rewrite_rules');
add_filter('post_rewrite_rules', 'category_classic_paging_category_rewrite_rules');
function category_classic_paging_category_rewrite_rules($rules) {
    global $CATEGORY_ORDER_PARAMS;
    $extra = array();
    foreach ($rules as $match => $query) {
        if (strpos($match, 'feed') !== false || strpos($match, 'embed') !== false
            || strpos($match, 'attachment') !== false || strpos($match, 'trackback') !== false) {
            continue;
        }
        if (strpos($query, 'category_name') === false) continue;

        $idx = strpos($match, '(.+?)/');
        $base = $idx > 0 ? substr($match, 0, $idx) : '';
        $sub = substr($match, $idx + strlen('(.+?)/'));
        foreach ($CATEGORY_ORDER_PARAMS as $text => $type) {
            $m = $base.'(.+?)/'.$text.'/'.$sub;
            $q = $query;
            $q .= '&kos_order_by='.$type;

            if ($type == 'new') {
                $q .= '&orderby=date&order=DESC';
            } else if ($type == 'best') {
                $q .= '&r_sortby=highest_rated&r_orderby=desc';
            } else if ($type == 'vote') {
                $q .= '&r_sortby=most_rated&r_orderby=desc';
            }
            $extra[$m] = $q;
        }
    }
    foreach ($rules as $match => $query) {
        if (!isset($extra[$match])) {
            $extra[$match] = $query;
        }
    }
    return $extra;
}

add_filter('query_vars', 'category_classic_paging_query_vars');
function category_classic_paging_query_vars($public_query_vars) {
    array_push($public_query_vars, 'kos_order_by');
    return $public_query_vars;
}

function category_classic_posts_orderby($content) {
    $content = " game_views DESC";
    return $content;
}
add_action('pre_get_posts', 'category_classic_sorting');
function category_classic_sorting($local_wp_query) {
    if($local_wp_query->get('kos_order_by') == 'most') {
        add_filter('posts_orderby', 'category_classic_posts_orderby', 100);
    } else {
        remove_filter('posts_orderby', 'category_classic_posts_orderby');
    }
}

add_action('parse_query', 'category_classic_parse_query');
function category_classic_parse_query($wp_query) {
    if ($wp_query->is_category) {
        $q = &$wp_query->query_vars;

        if (empty($q['kos_order_by'])) {
            // Default order by
            $q['kos_order_by'] = 'most';
        }
    }
}

function get_current_orderby() {
    global $wp_query;
    $q = $wp_query->query_vars;
    if (!empty($q['kos_order_by'])) {
        return $q['kos_order_by'];
    } else {
        return 'most';
    }
}

function get_category_order_link($order, $category = null) {
    global $wp_query, $CATEGORY_ORDER_PARAMS_INVERSE;
    $q = $wp_query->query_vars;
    $currentPage = $q['paged'];

    if (empty($category)) {
        $category = $q['category_name'];
    }
    if (empty($category)) return '';
    $link = get_term_link($category, 'category');

    $link = rtrim($link, '/');
    $link .= '/';

    if (!empty($order) && !empty($CATEGORY_ORDER_PARAMS_INVERSE[$order])) {
        $link .= $CATEGORY_ORDER_PARAMS_INVERSE[$order];
    }

    if ($currentPage && $currentPage > 1) {
        $link .= '/'.PAGE.'/'.$currentPage;
    }

    return $link;
}

function get_current_category() {
    global $wp_query;
    $q = $wp_query->query_vars;
    $category = $q['category_name'];
    return get_category_by_slug($category);
}
