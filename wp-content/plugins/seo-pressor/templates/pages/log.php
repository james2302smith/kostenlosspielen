<?php
/**
 * Template to show the plugin Log page.
 *
 */
?>
<head>
	<!-- css styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo WPPostsRateKeys::$plugin_url; ?>templates/js/lib/ui/css/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WPPostsRateKeys::$plugin_url;; ?>templates/js/lib/jqGrid/css/ui.jqgrid.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo WPPostsRateKeys::$plugin_url; ?>templates/css/log.css" />
	<!-- end css styles -->
	<!-- javascript libraries -->
	<script type="text/javascript" src="<?php echo get_bloginfo ('wpurl'); ?>/wp-includes/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo ('wpurl'); ?>/wp-includes/js/jquery/ui/jquery.ui.core.min.js"></script>
	<script type="text/javascript" src="<?php echo get_bloginfo ('wpurl'); ?>/wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js"></script>

	<script type="text/javascript" src="<?php echo WPPostsRateKeys::$plugin_url; ?>templates/js/lib/jqGrid/js/i18n/grid.locale-en.js"></script>
	<script type="text/javascript" src="<?php echo WPPostsRateKeys::$plugin_url; ?>templates/js/lib/jqGrid/js/jquery.jqGrid.min.js"></script>
	<!-- end javascript libraries -->
	<script type="text/javascript" src="<?php echo WPPostsRateKeys::$plugin_url; ?>templates/js/log.js"></script>
</head>
<body class="log-page-body">
	<div class="wrap seopressor-log-page">
	    <h3>
	        <?php echo __('Log Viewer (server date and time: ','seo-pressor') . date('Y-m-d H:i:s') . ')'?>
	    </h3>
	    <input type="hidden" id="plugin_url" name="plugin_url" value="<?php echo WPPostsRateKeys::$plugin_url; ?>" />
	    <div class="seopressor-page-container">
			<div id="seopressor-logs-grid-container" class="seopressor-grid">
		        <table id="seopressor-logs-grid">
		        </table>
		        <div id="seopressor-logs-grid-pager">
		        </div>
		    </div>
	    </div>
	    <form action="">
	    <input type="submit" name="download" value="Download Log File">
	    </form>
	</div>
</body>