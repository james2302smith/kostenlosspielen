<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nttuyen
 * Date: 3/12/14
 * Time: 10:54 PM
 * To change this template use File | Settings | File Templates.
 */

class KosRecents {
    private $total = 0;
    private $games;

    private $userid;


    private function __construct($userid) {
        $this->userid = $userid;
    }

    private static $instances = array();

    /**
     * @param int $userid
     * @return KosRecents
     */
    public static function getInstance($userid = 0) {
        if(empty($userid)) {
            $userid = get_current_user_id();
        }

        if(empty(self::$instances[$userid])) {
            self::$instances[$userid] = new KosRecents($userid);
        }

        return self::$instances[$userid];
    }

    public function addToRecent($postid = 0) {
        $currentGame = null;
        if(empty($postid)) {
            global $post;
            $currentGame = $post;
        } else {
            $currentGame = get_post($postid);
        }

        $game = new stdClass();
        $game->post_name = $currentGame->post_name;
        $game->game_image = $currentGame->game_image;
        $game->post_title = $currentGame->post_title;
        $game->game_intro_home = $currentGame->game_intro_home;
        $game->ID = $currentGame->ID;

        if(!session_id()) {
            session_start();
        }

        $oldRecent = $_SESSION[KOS_RECENT_GAME_SESSION_KEY];
        if(!isset($oldRecent)) {
            $oldRecent = array();
        }

        $recents = array();
        foreach($oldRecent as $g) {
            if($g->ID != $game->ID) {
                array_push($recents, $g);
            }
        }

        array_unshift($recents, $game);

        while(count($recents) > KOS_RECENT_GAME_MAX + 1) {
            array_pop($recents);
        }
        $_SESSION[KOS_RECENT_GAME_SESSION_KEY] = $recents;

        //TODO: store recent game into DB
    }

    public function getRecentGames() {

        if(!session_id()) {
            session_start();
        }
        $sessionRecents = $_SESSION[KOS_RECENT_GAME_SESSION_KEY];
        if(!isset($sessionRecents)) {
            return array();
        }

        $recents = array();
        global $post;
        if($post) {
            //Remove current game from recent list
            foreach($sessionRecents as $g) {
                if($g->ID != $post->ID) {
                    array_push($recents, $g);
                }
            }
        } else {
            $recents = $sessionRecents;
        }

        while(count($recents) > KOS_RECENT_GAME_MAX) {
            array_pop($recents);
        }

        //TODO: load from DB if user is loggedIn

        return $recents;
    }
}