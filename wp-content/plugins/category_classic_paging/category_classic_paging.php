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
    'meist-bewertete-spiele'  => 'vote'
);
$CATEGORY_ORDER_PARAMS_INVERSE = array(
    //'mostview' => 'view',
    'new' => 'am-neuesten-spiele',
    'best' => 'best-bewertete-spiele',
    'vote'  => 'meist-bewertete-spiele'
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
            if ($type == 'new') {
                $q .= '&orderby=date&order=DESC';
            } else {
                $q .= '&kos_order_by='.$type;
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

add_action('parse_query', 'category_classic_parse_query');
function category_classic_parse_query($wp_query) {
    if ($wp_query->is_category) {
        $q = &$wp_query->query_vars;
        if (!empty($q['kos_order_by'])) {
            $order = $q['kos_order_by'];
            $q['meta_query'] = array(
                'relation' => 'AND',
                'ratings_average' => array('key' => 'ratings_average', 'type' => 'DECIMAL(10,2)', 'compare' => 'EXISTS'),
                'ratings_users' => array('key' => 'ratings_users', 'type' => 'DECIMAL(10,2)', 'compare' => 'EXISTS'),
            );
            if ($order == 'vote') {
                $q['orderby'] = array(
                    'ratings_users' => 'DESC',
                    'ratings_average' => 'DESC'
                );

            } if ($order == 'best') {
                $q['orderby'] = array(
                    'ratings_average' => 'DESC',
                    'ratings_users' => 'DESC',
                );
            }
            add_missing_meta_field();
        }
    }
}

function get_current_orderby() {
    global $wp_query;
    $q = $wp_query->query_vars;
    if (!empty($q['kos_order_by'])) {
        return $q['kos_order_by'];
    } else {
        return 'new';
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

    if (!empty($order) && !empty($CATEGORY_ORDER_PARAMS_INVERSE[$order])) {
        $link .= $CATEGORY_ORDER_PARAMS_INVERSE[$order];
    }

    if ($currentPage && $currentPage > 1) {
        $link .= '/'.PAGE.'/'.$currentPage;
    }

    return $link;
}

/*function get_category_link($category, $orderBy = 'new') {
    get_term_link()
}*/

/**
 * TODO: remove this action
 * TODO: I want to remove this hook, it's too strick and not good
 * This method overiter method: WP::parse_request($extra_query_vars)
 */
//add_action('do_parse_request', 'category_classic_paging_parse_request', 10, 3);
function category_classic_paging_parse_request($do, $wp, $extra_query_vars) {
    if(!$do) return true;

    global $CATEGORY_ORDER_PARAMS;
    global $wp_rewrite;

    $req_uri = $_SERVER['REQUEST_URI'];
    $req_uri_array = explode('?', $req_uri);
    $req_uri = $req_uri_array[0];
    $req_uri = rtrim($req_uri, '/');

    $orderType = '';
    $do = false;
    if(strpos($req_uri, '/'.PAGE.'/')) {
        $wp_rewrite->pagination_base = PAGE;
        $do = true;

        //Backup page value
        $req_uris = explode('/', $req_uri);
        do {
            $e = array_shift($req_uris);
        } while($e != PAGE);
        $currentPage = array_shift($req_uris);
        $_GET['current_page'] = (int)$currentPage;
        $_GET['kos_current_page'] = (int)$currentPage;
    }
    foreach($CATEGORY_ORDER_PARAMS as $key => $value) {
        if(strpos($req_uri, '/'.$key)) {
            $_GET[$value] = 'val';
            $_GET['orderType'] = $value;
            $_GET['kos_order_by'] = $value;
            $_GET['kos_order_by_key'] = $key;
            $orderType = $key;
            $do = true;
            break;
        }
    }
    unset($req_uri);

    //Return to default if it not our url
    if(!$do) return true;

    $wp->query_vars = array();
    $post_type_query_vars = array();

    if ( is_array($extra_query_vars) )
        $wp->extra_query_vars = & $extra_query_vars;
    else if (! empty($extra_query_vars))
        parse_str($extra_query_vars, $wp->extra_query_vars);

    // Process PATH_INFO, REQUEST_URI, and 404 for permalinks.
    // Fetch the rewrite rules.
    $rewrite = $wp_rewrite->wp_rewrite_rules();

    if ( ! empty($rewrite) ) {
        // If we match a rewrite rule, this will be cleared.
        $error = '404';
        $wp->did_permalink = true;

        if ( isset($_SERVER['PATH_INFO']) )
            $pathinfo = $_SERVER['PATH_INFO'];
        else
            $pathinfo = '';
        $pathinfo_array = explode('?', $pathinfo);
        $pathinfo = str_replace("%", "%25", $pathinfo_array[0]);
        $req_uri = $_SERVER['REQUEST_URI'];
        $req_uri_array = explode('?', $req_uri);
        $req_uri = $req_uri_array[0];
        $self = $_SERVER['PHP_SELF'];
        $home_path = parse_url(home_url());
        if ( isset($home_path['path']) )
            $home_path = $home_path['path'];
        else
            $home_path = '';
        $home_path = trim($home_path, '/');

        // Trim path info from the end and the leading home path from the
        // front. For path info requests, this leaves us with the requesting
        // filename, if any. For 404 requests, this leaves us with the
        // requested permalink.
        $req_uri = str_replace($pathinfo, '', $req_uri);
        $req_uri = trim($req_uri, '/');
        $req_uri = preg_replace("|^$home_path|i", '', $req_uri);
        $req_uri = trim($req_uri, '/');
        $pathinfo = trim($pathinfo, '/');
        $pathinfo = preg_replace("|^$home_path|i", '', $pathinfo);
        $pathinfo = trim($pathinfo, '/');
        $self = trim($self, '/');
        $self = preg_replace("|^$home_path|i", '', $self);
        $self = trim($self, '/');

        // The requested permalink is in $pathinfo for path info requests and
        //  $req_uri for other requests.
        if ( ! empty($pathinfo) && !preg_match('|^.*' . $wp_rewrite->index . '$|', $pathinfo) ) {
            $request = $pathinfo;
        } else {
            // If the request uri is the index, blank it out so that we don't try to match it against a rule.
            if ( $req_uri == $wp_rewrite->index )
                $req_uri = '';
            $request = $req_uri;
        }

        $wp->request = $request;

        // Look for matches.
        $request_match = $request;
        //TODO: #nttuyen
        $request_match = str_replace($orderType, '', $request_match);;
        $request_match = str_replace('//', '/', $request_match);
        $request_match = str_replace(PAGE, 'page', $request_match);
        //#nttuyen: end hack
        if ( empty( $request_match ) ) {
            return true;
        } else {
            foreach ( (array) $rewrite as $match => $query ) {
                // If the requesting file is the anchor of the match, prepend it to the path info.
                if ( ! empty($req_uri) && strpos($match, $req_uri) === 0 && $req_uri != $request )
                    $request_match = $req_uri . '/' . $request;

                if ( preg_match("#^$match#", $request_match, $matches) ||
                    preg_match("#^$match#", urldecode($request_match), $matches) ) {

                    if ( $wp_rewrite->use_verbose_page_rules && preg_match( '/pagename=\$matches\[([0-9]+)\]/', $query, $varmatch ) ) {
                        // this is a verbose page match, lets check to be sure about it
                        if ( ! get_page_by_path( $matches[ $varmatch[1] ] ) )
                            continue;
                    }

                    // Got a match.
                    $wp->matched_rule = $match;
                    break;
                }
            }
        }
        //#nttuyen: if not match any thing, return true to next filter
        if(empty($wp->matched_rule)) {
            return true;
        }
        //#nttuyen: end hack

        if ( isset( $wp->matched_rule ) ) {
            // Trim the query of everything up to the '?'.
            $query = preg_replace("!^.+\?!", '', $query);

            // Substitute the substring matches into the query.
            $query = addslashes(WP_MatchesMapRegex::apply($query, $matches));

            $wp->matched_query = $query;

            // Parse the query.
            parse_str($query, $perma_query_vars);

            // If we're processing a 404 request, clear the error var since we found something.
            if ( '404' == $error )
                unset( $error, $_GET['error'] );
        }

        // If req_uri is empty or if it is a request for ourself, unset error.
        if ( empty($request) || $req_uri == $self || strpos($_SERVER['PHP_SELF'], 'wp-admin/') !== false ) {
            unset( $error, $_GET['error'] );

            if ( isset($perma_query_vars) && strpos($_SERVER['PHP_SELF'], 'wp-admin/') !== false )
                unset( $perma_query_vars );

            $wp->did_permalink = false;
        }
    }

    $wp->public_query_vars = apply_filters('query_vars', $wp->public_query_vars);

    foreach ( $GLOBALS['wp_post_types'] as $post_type => $t )
        if ( $t->query_var )
            $post_type_query_vars[$t->query_var] = $post_type;

    foreach ( $wp->public_query_vars as $wpvar ) {
        if ( isset( $wp->extra_query_vars[$wpvar] ) )
            $wp->query_vars[$wpvar] = $wp->extra_query_vars[$wpvar];
        elseif ( isset( $_POST[$wpvar] ) )
            $wp->query_vars[$wpvar] = $_POST[$wpvar];
        elseif ( isset( $_GET[$wpvar] ) )
            $wp->query_vars[$wpvar] = $_GET[$wpvar];
        elseif ( isset( $perma_query_vars[$wpvar] ) )
            $wp->query_vars[$wpvar] = $perma_query_vars[$wpvar];

        if ( !empty( $wp->query_vars[$wpvar] ) ) {
            if ( ! is_array( $wp->query_vars[$wpvar] ) ) {
                $wp->query_vars[$wpvar] = (string) $wp->query_vars[$wpvar];
            } else {
                foreach ( $wp->query_vars[$wpvar] as $vkey => $v ) {
                    if ( !is_object( $v ) ) {
                        $wp->query_vars[$wpvar][$vkey] = (string) $v;
                    }
                }
            }

            if ( isset($post_type_query_vars[$wpvar] ) ) {
                $wp->query_vars['post_type'] = $post_type_query_vars[$wpvar];
                $wp->query_vars['name'] = $wp->query_vars[$wpvar];
            }
        }
    }

    // Convert urldecoded spaces back into +
    foreach ( $GLOBALS['wp_taxonomies'] as $taxonomy => $t )
        if ( $t->query_var && isset( $wp->query_vars[$t->query_var] ) )
            $wp->query_vars[$t->query_var] = str_replace( ' ', '+', $wp->query_vars[$t->query_var] );

    // Limit publicly queried post_types to those that are publicly_queryable
    if ( isset( $wp->query_vars['post_type']) ) {
        $queryable_post_types = get_post_types( array('publicly_queryable' => true) );
        if ( ! is_array( $wp->query_vars['post_type'] ) ) {
            if ( ! in_array( $wp->query_vars['post_type'], $queryable_post_types ) )
                unset( $wp->query_vars['post_type'] );
        } else {
            $wp->query_vars['post_type'] = array_intersect( $wp->query_vars['post_type'], $queryable_post_types );
        }
    }

    foreach ( (array) $wp->private_query_vars as $var) {
        if ( isset($wp->extra_query_vars[$var]) )
            $wp->query_vars[$var] = $wp->extra_query_vars[$var];
    }

    if ( isset($error) )
        $wp->query_vars['error'] = $error;

    $wp->query_vars = apply_filters('request', $wp->query_vars);

    do_action_ref_array('parse_request', array(&$wp));

    return false;
}

//TODO: remove these filter/action
//Init category
//add_action('pre_get_posts', 'category_classic_paging_pre_get_posts');
function category_classic_paging_pre_get_posts($query) {
    $category_name = get_query_var('category_name');
    $paged = get_query_var('paged');
    if(empty($paged) || $paged < 1) {
        $paged = 1;
    }
    $the_cat = get_term_by( 'slug', $category_name, 'category' );
    if(!$the_cat || !$the_cat->parent) return;

    $categoryId = $the_cat->term_id;
    $category = Category::getInstance($categoryId);
    $category->setCurrentPage($paged);
    $orderType = 'view';
    if(!empty($_GET['orderType'])) {
        $orderType = $_GET['orderType'];
    }
    $category->setOrderType($orderType);

    //Init data now
    $category->getTotal();
}

//add_action('wp_head', 'category_classic_paging_wp_head');
function category_classic_paging_wp_head() {
    $head = "\n";
    $category = Category::getInstance();
    if(!$category) return;
    $prevLink = $category->getPrevLink();
    if($prevLink) {
        $head .= '<link rel="prev" href="'.$prevLink.'"/>'."\n";
    }
    $nextLink = $category->getNextLink();
    if($nextLink) {
        $head .= '<link rel="next" href="'.$nextLink.'"/>'."\n";
    }

    echo $head;
}