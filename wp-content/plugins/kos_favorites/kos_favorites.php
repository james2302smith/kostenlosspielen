<?php
/*
Plugin Name: Kos Favorites
Plugin URI: http://www.kostenlosspielen.biz/
Description: Manage favorite game
Author: Nguyen The Tuyen
*/

require_once dirname(__FILE__).'/constants.php';
require_once dirname(__FILE__).'/KosFavorites.php';
require_once dirname(__FILE__).'/KosRecents.php';



/**
 * This method overiter method: WP::parse_request($extra_query_vars)
 */
/*
add_action('do_parse_request', 'kos_favorites_parse_request', 10, 3);
function kos_favorites_parse_request($do, $wp, $extra_query_vars) {
    if(!$do) return true;

    $favoritePage = KOS_FAVORITES_PAGE;
    $req_uri = $_SERVER['REQUEST_URI'];

    if(strlen($req_uri) < strlen($favoritePage) + 1 || substr($req_uri, 1, strlen($favoritePage)) != $favoritePage) {
        return true;
    }

    echo "HERE";
    die;

    $req_uri_array = explode('?', $req_uri);
    $req_uri = $req_uri_array[0];
    $req_uri = rtrim($req_uri, '/');

    $do = false;

    global $wp_rewrite;

    //TODO: how to process this?
    if(strpos($req_uri, '/'.PAGE.'/')) {
        $wp_rewrite->pagination_base = PAGE;
        $do = true;
    }

    global $FAVORITES_ORDER_PARAMS;
    $favoriteOrderType = '';
    foreach($FAVORITES_ORDER_PARAMS as $key => $value) {
        if(strpos($req_uri, '/'.$key)) {
            $_GET[$value] = 'val';
            $_GET['favorite_order_type'] = $value;
            $favoriteOrderType = $key;
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
        $request_match = str_replace($favoriteOrderType, '', $request_match);;
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
*/
