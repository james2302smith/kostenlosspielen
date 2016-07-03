<?php
$plugin_dir = WPPostsRateKeys::$plugin_dir;

include($plugin_dir . '/classes/automatic_internal_links.class.php');
include($plugin_dir . '/classes/capabilities.class.php');
include($plugin_dir . '/classes/central.class.php');
include($plugin_dir . '/classes/content_rate.class.php');
include($plugin_dir . '/classes/dbobject.class.php');
include($plugin_dir . '/classes/external_cloacked_links.class.php');
include($plugin_dir . '/classes/filters.class.php');
include($plugin_dir . '/classes/html_styles.class.php');
include($plugin_dir . '/classes/keywords.class.php');
include($plugin_dir . '/classes/logs.class.php');
include($plugin_dir . '/classes/lsi.class.php');
include($plugin_dir . '/classes/miscellaneous.class.php');
include($plugin_dir . '/classes/related_tags.class.php');
include($plugin_dir . '/classes/roles_capabilities.class.php');
include($plugin_dir . '/classes/settings.class.php');
include($plugin_dir . '/classes/upgrade.class.php');
include($plugin_dir . '/classes/users_custom_roles.class.php');
include($plugin_dir . '/classes/users.class.php');
include($plugin_dir . '/classes/validator.class.php');
include($plugin_dir . '/classes/visits.class.php');
include($plugin_dir . '/classes/wp_posts.class.php');

set_include_path(get_include_path() . PATH_SEPARATOR . $plugin_dir . 'classes/YoutubeWordpress/');
include($plugin_dir . '/classes/YoutubeWordpress/YoutubeKeyword.php');
include($plugin_dir . '/classes/YoutubeWordpress/YoutubeVideo.php');