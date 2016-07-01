<?php
/**
 * Template Name: User's Feeds
 *
 * Template for user newfeeds
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
$userId = get_current_user_id();
$commentFeed = CommentFeedModel::getInstance($userId);
get_header();
?>
    <div class="col1">
        <div id="content" role="main">
            <div id="user-feeds" class="simple-page">
                <h2 class="page-title">Benachrichtigungen</h2>
                <div class="page-text standard-margin">
                    <div class="notification-list">
                        <?php
                        $currentDay = '';

                        ?>
                        <?php foreach($commentFeed->getItems() as $feed):
                            $day = getDateString($feed->time);
                            if($currentDay != $day):
                                if($currentDay == '') $currentDay = $day;
                            ?>
                            <h3><?php echo $day ?></h3>
                            <ul class="notifications">
                            <?php endif; ?>
                                <li class="notification">
                                    <div class="">
                                        <div class="left float-left">
                                            <?php echo get_avatar($feed->user_id,28);?>
                                        </div>
                                        <div class="right float-left">
                                            <div class="standard-margin-left">
                                                <?php echo $feed->message?>
                                                <span class="time standard-margin"><?php echo date('H:i', strtotime($feed->time)) ?></span>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </li>
                            <?php if($currentDay != $day):
                            $currentDay = $day;
                            ?>
                            </ul>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col2">
        <div id="content" role="main">
            <div id="user-menus" class="simple-page">
                <h2 class="page-title">Deine Information</h2>
                <div class="page-text">
                    <ul class="user-menu">
                        <li class="blue">
                            <?php
                            $noUnread = $commentFeed->getNoUnreadFeed();
                            if($noUnread == 0) {
                                $noUnread = false;
                            } else if($noUnread > 99) {
                                $noUnread = '99+';
                            }
                            ?>
                            <a href="<?php echo SITE_ROOT_URL ?>/benachrichtigungen">Benachrichtigungen <?php echo $noUnread ? '('.$noUnread.')' : '' ?></a>
                        </li>
                        <li class="blue"><a href="javascript:void(0);">Einstellung</a></li>
                        <li class="blue">
                            <a href="<?php echo SITE_ROOT_URL ?>/hilfe">Hilfe/FAQs</a>
                        </li>
                        <li class="blue">
                            <a href="<?php echo wp_logout_url(get_permalink()) ?>">Abmelden</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>