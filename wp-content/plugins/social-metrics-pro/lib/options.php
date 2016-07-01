<?php
function add_socialmetricspro_settings_scripts(){ 
if ( (is_admin() && $_GET['page'] == 'socialmetricspro_settings') || (is_admin() && $_GET['page'] == 'socialmetricspro_dashboard') ) { ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo plugins_url() . '/social-metrics-pro/lib/jquery.qtip.pack.js'; ?>"></script>
<?php 
	}
}
add_action('wp_print_scripts','add_socialmetricspro_settings_scripts');

global $optionstate;
/* $optionstate = 'd718e34ab653337cd3b81138d7d0da8f'; */
$optionstate = 'd9d7f727e56ce05f24f8603bf6ffe417';
?>
<?php
function socialmetricspro_settings_page() {
	socialmetricspro_settings_page_function();
}
?>
<?php
function socialmetricspro_settings_page_function() {
add_socialmetricspro_styles();
$tzone = get_option('timezone_string');
if ( !empty( $tzone ) ) date_default_timezone_set ( $tzone );
else date_default_timezone_set ( "America/New_York" );
?>
<div class="wrap">
<div class="smwrap">
	<h2 class="sm-branding">Social Metrics Pro Settings</h2>
	<?php
	$adm_url = admin_url();

	if( $_GET['settings-updated'] ) { ?>
		<div id="message" class="updated" style="padding:10px;">You are all set! You can make more changes or go to your <a href="<?php echo $adm_url . 'admin.php?page=socialmetricspro_dashboard' ; ?>">Social Metrics Pro Dashboard</a> to see the stats.</div>
	<?php } ?>
	
	<form method="post" action="options.php">
		<?php check_admin_referer(); ?>
		<?php 
			settings_fields( 'socialmetricspro-settings-group' );
		?>
		<div style="min-width:940px;">
			<div style="float:left;min-width:600px;margin:10px 5px 10px 0px; padding:5px;">
			
	<script>
	$(document).ready(function() {
	
		var shared = {
			position: {
				my: 'top left', 
				at: 'bottom right'
			},
			show: {
				event: 'mouseenter',
				solo: true
			},
			hide: 'unfocus',
			style: {
				classes: 'ui-tooltip-smblue ui-tooltip-shadow ui-tooltip-rounded'
			}
		};
		
		$( "#check-services" ).buttonset();
		$( "#radio-logs" ).buttonset();
		$( "#radio-cf" ).buttonset();
		$( "#radio-cfds" ).buttonset();
		$( "#radio-exp" ).buttonset();
		$( "#check-exp" ).buttonset();
		$( "#radio-dsc" ).buttonset();
		$( "#radio-dashboard" ).buttonset();
		$( "#radio-alr" ).buttonset();
		$( "input:submit, a, button", ".sm-button-element" ).button();
		
		$( ".drlft" ).qtip( $.extend({}, shared, {
		content: '<strong>Download/Export as File:</strong><br><br>This feature allows you to download/export the displayed Social Metrics report to your desktop.<br><br><strong>Enabled: </strong>Activates the functionality.<br><br><strong>Disabled: </strong>Deactivates the functionality.<br><br>Further you can choose the file formats you wish to allow exporting to:<br><br><strong>Excel: </strong><img style="float:left;margin:5px 7px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics-pro/images/xls.png';?>">Enables exporting to an Excel spreadsheet in a tab-delimited format.<br><br><strong>CSV: </strong><img style="float:left;margin:5px 5px 0px 0px;" src="<?php echo plugins_url() . '/social-metrics-pro/images/csv.png';?>">Enables exporting to a comma-separated (.csv) file.'
		}));
		
		$( ".dm" ).qtip( $.extend({}, shared, {
		content: '<strong>Debug Mode:</strong><br><br>Enables error logging. Debug mode should be turned off during normal use.'
		}));
		
		$( ".cft" ).qtip( $.extend({}, shared, {
		content: '<strong>Conditional Formatting:</strong><br><br><img style="float:left;margin:5px 5px 0px 0px;" src="<?php echo plugins_url(); ?>/social-metrics-pro/images/color-scale.png">Formats the Social Metrics report with a Red-Yellow-Green Color Scale, thus helping you <em>visually identify the popular posts</em>. The background color shade represents the value in the cell.<br><br><strong>Compare by columns:</strong> The background color shade is arrived at by comparing the values in the particular column.<br><br><strong>Compare entire table</strong>: The background color shade is arrived at by comparing the values in all the columns.<br><br><strong>Disable</strong>: Disables the conditional formatting altogether.<br><br>Note: For conditional formatting to work, you must choose plain counts display.'
		}));
		
		$( ".cfds" ).qtip( $.extend({}, shared, {
		content: '<strong>Conditional Formatting Dataset:</strong><br><br><img style="float:left;margin:5px 5px 0px 0px;" src="<?php echo plugins_url(); ?>/social-metrics-pro/images/color-scale.png">This option allows you to choose which set of data should be compared in order to apply conditional color formatting.<br><br><strong>Compare Sitewide Data:</strong> The background color shade is arrived at by comparing sitewide data.<br><br><strong>Compare Displayed Data Only</strong>: The background color shade is arrived at by comparing only the data currently displayed on the dashboard. <br><br>The option to compare only the displayed data could be useful for example, when you want to compare the performance of a subset of posts or compare only n number of recent posts within themselves.'
		}));
		
		$( ".alr" ).qtip( $.extend({}, shared, {
		content: '<strong>Access Level:</strong><br><br>Here you can choose who can access the Social Metrics Pro Dashboard. Choose the minimum level at and above which the Social Metrics Pro Dashboard should be accessible.<br><br><strong>Notes:</strong><br><br>1. Social Metrics Pro Widget (displayed on WordPress Admin Dashboard), if active, will still be accessible to all users irrespective of access level.<br><br>2. Settings can be changed only by users with administrator capability.<br><br>3. Export tool is only available to users with administrator capability.'
		}));
		
		$( ".nopt" ).qtip( $.extend({}, shared, {
		content: '<strong>Number of Posts to Display at a time:</strong><br><br>The number of posts you wish to see at a time. To see all your posts, set this to a very high value, say 999999.<br><br>Note: When you choose to display share counts as share buttons, maximum of 20 posts can be displayed at a time. This limit does not apply when using plain counts display.'
		}));
		
		$( ".dsc" ).qtip( $.extend({}, shared, {
		content: '<strong>Display of Share Counts:</strong><br><br>Choose how the share counts should be displayed. Using plain counts will allow you to take advantage of our condtional formatting feature.<br><br>If you choose to display share buttons, the maximum number of posts to display at a time will be limited to maximum 20 and conditional formatting will be disabled. This is to ensure better speed and performance.'
		}));

		$( ".doabt" ).qtip( $.extend({}, shared, {
		content: '<strong>Display on Admin Dashboard:</strong><br><br>Displays Social Metrics for your latest 5 posts on the WordPress Admin Dashboard.<br><br><strong>Show: </strong>Displays the Social Metrics on the WordPress Admin Dashboard.<br><br><strong>Hide: </strong>Disables the functionality.'
		}));
		
		$( ".nea" ).qtip( $.extend({}, shared, {
		content: '<strong>Automatic Update Notification:</strong><br><br>If you provide an email address here, your blog can email you when a new version of Social Metrics Pro is available.<br><br>Social Metrics Pro supports 1-click updates via WordPress Dashboard -> Updates.'
		}));
		
		$( ".lea" ).qtip( $.extend({}, shared, {
		content: '<strong>Email Address:</strong><br><br>Enter the email address you used to purchase the software.'
		}));
		
		$( ".lkey" ).qtip( $.extend({}, shared, {
		content: '<strong>License Key:</strong><br><br>Enter the License Key Code or Serial Number for your copy. In most cases, this would be the receipt number issued by ClickBank or PayPal for your purchase.'
		}));
	});
	</script>
				<p class="sm-button-element">
				<button><?php _e('Save Changes') ?></button>
				</p>
				<h3>Choose Services</h3>
					<table class="form-table">
						<tr valign="middle">
							<td colspan="2">
							<div id="check-services">
							<input type="checkbox" name="socialmetricspro_show_twitter" id="socialmetricspro_show_twitter" value="true" <?php if (get_option('socialmetricspro_show_twitter', true) == "true") { _e('checked="checked"', "socialmetricspro_show_twitter"); }?> /><label for="socialmetricspro_show_twitter">Twitter</label>
							<input type="checkbox" name="socialmetricspro_show_facebook" id="socialmetricspro_show_facebook" value="true" <?php if (get_option('socialmetricspro_show_facebook', true) == "true") { _e('checked="checked"', "socialmetricspro_show_facebook"); }?> /><label for="socialmetricspro_show_facebook">Facebook</label>
							<input type="checkbox" name="socialmetricspro_show_plusone" id="socialmetricspro_show_plusone" value="true" <?php if (get_option('socialmetricspro_show_plusone', true) == "true") { _e('checked="checked"', "socialmetricspro_show_plusone"); }?> /><label for="socialmetricspro_show_plusone">Google +1</label>
							<input type="checkbox" name="socialmetricspro_show_pinterest" id="socialmetricspro_show_pinterest" value="true" <?php if (get_option('socialmetricspro_show_pinterest', true) == "true") { _e('checked="checked"', "socialmetricspro_show_pinterest"); }?> /><label for="socialmetricspro_show_pinterest">Pinterest</label>
							<input type="checkbox" name="socialmetricspro_show_su" id="socialmetricspro_show_su" value="true" <?php if (get_option('socialmetricspro_show_su', true) == "true") { _e('checked="checked"', "socialmetricspro_show_su"); }?> /><label for="socialmetricspro_show_su">StumbleUpon</label>
							<input type="checkbox" name="socialmetricspro_show_digg" id="socialmetricspro_show_digg" value="true" <?php if (get_option('socialmetricspro_show_digg', false) == "true") { _e('checked="checked"', "socialmetricspro_show_digg"); }?> /><label for="socialmetricspro_show_digg">Digg</label>
							<input type="checkbox" name="socialmetricspro_show_linkedin" id="socialmetricspro_show_linkedin" value="true" <?php if (get_option('socialmetricspro_show_linkedin', false) == "true") { _e('checked="checked"', "socialmetricspro_show_linkedin"); }?> /><label for="socialmetricspro_show_linkedin">LinkedIn</label>
							</div>
							</td>
						</tr>
						<tr valign="middle">
							<td colspan="3">
							<?php
								$cache_refresh_status = get_option("socialmetricspro_refresh_status");
								if ( $cache_refresh_status == "ON" ) { echo "<code>Data refresh is currently in progress.</code>"; }
								elseif ( $cache_refresh_status == "PAUSED" ) { echo "<code>Data refresh has been paused for 10 minutes. Resuming in a few minutes...</code>"; }
								elseif ( $cache_refresh_status == false ) { echo "<code>Data refresh is not scheduled. Please deactivate and re-activate the plugin.</code>"; }
								else { 
									$date_format = get_option("date_format",'d M Y');
									$time_format = get_option("time_format",'H:i:s');
									echo "<code>Next data refresh is scheduled to begin at " . date($date_format . ' ' . $time_format . ' T' , $cache_refresh_status ) . ".</code>"; 
								}
							?>
							</td>
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Debug Mode<span class="dm sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td>
								<div id="radio-logs" style="float:left;">
									<input type="radio" name="socialmetricspro_enable_logs" id="sm-logs-on" value="enabled" <?php if (get_option('socialmetricspro_enable_logs', 'disabled') == "enabled") { echo 'checked'; }?> /><label for="sm-logs-on">On</label>
									<input type="radio" name="socialmetricspro_enable_logs" id="sm-logs-off" value="disabled" <?php if (get_option('socialmetricspro_enable_logs', 'disabled') == "disabled") { echo 'checked'; update_option("socialmetricspro_logging_error", "NO"); }?> /><label for="sm-logs-off">Off</label>
								</div>
							</td>
						</tr>
					</table>
				<h3>Choose Features</h3>
					<table class="form-table">
						<tr valign="middle">
							<td style="width:230 px;">Download Report to a Local File<span class="drlft sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td>
								<div id="radio-exp" style="float:left;">
									<input type="radio" name="socialmetricspro_export" id="sm-exp-enabled" value="enabled" <?php if (get_option('socialmetricspro_export', 'enabled') == "enabled") { echo 'checked'; }?> /><label for="sm-exp-enabled">Enabled</label>
									<input type="radio" name="socialmetricspro_export" id="sm-exp-disabled" value="disabled" <?php if (get_option('socialmetricspro_export', 'enabled') == "disabled") { echo 'checked'; }?> /><label for="sm-exp-disabled">Disabled</label>
								</div>
								<div id="check-exp" style="float:left;margin-left:10px;">
									<input type="checkbox" name="socialmetricspro_xls" id="socialmetricspro_xls" value="true" <?php if (get_option('socialmetricspro_xls', true) == "true") { _e('checked="checked"', "socialmetricspro_xls"); }?> /><label for="socialmetricspro_xls">Excel</label>
									<input type="checkbox" name="socialmetricspro_csv" id="socialmetricspro_csv" value="true" <?php if (get_option('socialmetricspro_csv', true) == "true") { _e('checked="checked"', "socialmetricspro_csv"); }?> /><label for="socialmetricspro_csv">CSV</label>
								</div>
							</td>
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Conditional Formatting<span class="cft sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td><div id="radio-cf">
								<input type="radio" name="socialmetricspro_conditional_formatting" id="sm-cf-bycolumns" value="bycolumns" <?php if (get_option('socialmetricspro_conditional_formatting', 'bycolumns') == "bycolumns") { echo 'checked'; }?> /><label for="sm-cf-bycolumns">Compare by columns</label>
								<input type="radio" name="socialmetricspro_conditional_formatting" id="sm-cf-bytable" value="bytable" <?php if (get_option('socialmetricspro_conditional_formatting', 'bycolumns') == "bytable") { echo 'checked'; }?> /><label for="sm-cf-bytable">Compare entire table</label>
								<input type="radio" name="socialmetricspro_conditional_formatting" id="sm-cf-disabled" value="disabled" <?php if (get_option('socialmetricspro_conditional_formatting', 'bycolumns') == "disabled") { echo 'checked'; }?> /><label for="sm-cf-disabled">Disable</label>
								</div>
							</td>
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Conditional Formatting Dataset<span class="cfds sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td><div id="radio-cfds">
								<input type="radio" name="socialmetricspro_conditional_formatting_ds" id="sm-cfds-sitewide" value="sitewide" <?php if (get_option('socialmetricspro_conditional_formatting_ds', 'sitewide') == "sitewide") { echo 'checked'; }?> /><label for="sm-cfds-sitewide">Compare Sitewide Data</label>
								<input type="radio" name="socialmetricspro_conditional_formatting_ds" id="sm-cfds-displayed" value="displayed" <?php if (get_option('socialmetricspro_conditional_formatting_ds', 'sitewide') == "displayed") { echo 'checked'; }?> /><label for="sm-cfds-displayed">Compare Displayed Data Only</label>
								</div>
							</td>
						</tr>
					</table>					
				<h3>Choose Display Options</h3>
					<table class="form-table">
						<tr valign="middle">
							<td style="width:230px;">Number of Posts to Display at a time<span class="nopt sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td><input type="text" name="socialmetricspro_per_page" value="<?php echo get_option('socialmetricspro_per_page', 10); ?>" style="width: 50px;" /></td>							
						</tr>
						<tr valign="middle">
							<td style="width:230px;">Display of Share Counts<span class="dsc sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>						
							<td><div id="radio-dsc">
								<input type="radio" id="sm-dsc-plain" name="socialmetricspro_share_counts" value="plain" <?php if (get_option('socialmetricspro_share_counts', 'plain') == "plain") { echo 'checked'; }?> /><label for="sm-dsc-plain">Show Plain Counts</label>
								<input type="radio" id="sm-dsc-sharebuttons" name="socialmetricspro_share_counts" value="sharebuttons" <?php if (get_option('socialmetricspro_share_counts', 'plain') == "sharebuttons") { echo 'checked'; }?> /><label for="sm-dsc-sharebuttons">Show Share Buttons</label>
							</div></td>						
						</tr>

						<tr valign="middle">
							<td style="width:230px;">Display on Admin Dashboard<span class="doabt sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>						
							<td><div id="radio-dashboard">
							<input type="radio" id="sm-dashboard-enabled" name="socialmetricspro_show_on_dashboard" value="enabled" <?php if (get_option('socialmetricspro_show_on_dashboard', 'enabled') == "enabled") { echo 'checked'; }?> /><label for="sm-dashboard-enabled">Show</label>
							<input type="radio" id="sm-dashboard-disabled" name="socialmetricspro_show_on_dashboard" value="disabled" <?php if (get_option('socialmetricspro_show_on_dashboard', 'enabled') == "disabled") { echo 'checked'; }?> /><label for="sm-dashboard-disabled">Hide</label>							</div>							
						</td>
					</tr>
					</table>
				<h3>Access Level</h3>
					<table class="form-table">
						<tr valign="middle">
							<td style="width:230px;">Choose who can access the reports<span class="alr sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td><div id="radio-alr">
								<input type="radio" name="socialmetricspro_access_role" id="sm-alr-administrator" value="manage_options" <?php if (get_option('socialmetricspro_access_role', 'manage_options') == "manage_options") { echo 'checked'; }?> /><label for="sm-alr-administrator">Administrator</label>
								<input type="radio" name="socialmetricspro_access_role" id="sm-alr-editor" value="edit_others_posts" <?php if (get_option('socialmetricspro_access_role', 'manage_options') == "edit_others_posts") { echo 'checked'; }?> /><label for="sm-alr-editor">Editor</label>
								<input type="radio" name="socialmetricspro_access_role" id="sm-alr-author" value="publish_posts" <?php if (get_option('socialmetricspro_access_role', 'manage_options') == "publish_posts") { echo 'checked'; }?> /><label for="sm-alr-author">Author</label>
								<input type="radio" name="socialmetricspro_access_role" id="sm-alr-contributor" value="edit_posts" <?php if (get_option('socialmetricspro_access_role', 'manage_options') == "edit_posts") { echo 'checked'; }?> /><label for="sm-alr-contributor">Contributor</label>
								<input type="radio" name="socialmetricspro_access_role" id="sm-alr-subscriber" value="read" <?php if (get_option('socialmetricspro_access_role', 'manage_options') == "read") { echo 'checked'; }?> /><label for="sm-alr-subscriber">Subscriber</label>
								</div>
							</td>
						</tr>
					</table>	
				<h3>Automatic Update Notification</h3>
					<table class="form-table">
						<tr valign="middle">
							<td style="width:230px;">Notification Email Address<span class="nea sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td><input type="text" name="socialmetricspro_notification_email" value="<?php echo get_option('socialmetricspro_notification_email', ''); ?>" style="width: 310px;" /></td>							
						</tr>
					</table>
				<h3>License Information</h3>
					<table class="form-table">
						<tr valign="middle">
							<td style="width:230px;">Email Address<span class="lea sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>
							<td><input type="text" name="socialmetricspro_license_email" value="<?php echo get_option('socialmetricspro_license_email', ''); ?>" style="width: 310px;" /></td>							
						</tr>
						<tr valign="middle">
							<td style="width:230px;">License Key<span class="lkey sm-help"><img src="<?php echo plugins_url();?>/social-metrics-pro/images/help.png"></span></td>						
							<td><input type="text" name="socialmetricspro_license_key" value="<?php echo get_option('socialmetricspro_license_key', ''); ?>" style="width: 310px;" />
							</td>
						</tr>
					</table>
				<p class="sm-button-element">
					<button><?php _e('Save Changes') ?></button>
				</p>
			</div>

			<div class="smp-info">
			<div style="margin-left:10px;">
				<?php if ( get_option("socialmetricspro_ltype") == "SMS" ) { ?>
				<h3>Upgrading is Easy!</h3>
				<div>You are currently using a Single-Site License. Unlimited License will allow you to use Social Metrics Pro plugin on all the websites you own. <a href="http://socialmetricspro.com/upgrade/" target="_blank" >Click here to Upgrade to Unlimited License</a>.<br></div>
				<?php } ?>
				<h3>Who Created the	Social Metrics Pro?</h3>
					<div>The <a href="http://socialmetricspro.com/" target="_blank" style="text-decoration:none;font-weight:bold;">Social Metrics Pro</a> plugin for WordPress is created by <a href="http://www.riyaz.net/about/" target="_blank" style="text-decoration:none;">Riyaz</a> from <a href="http://seopressor.com" style="text-decoration:none;" target="_blank">Daniel Tan</a>'s SEO Team. Riyaz blogs at <a href="http://www.riyaz.net" target="_blank" style="text-decoration:none;">riyaz.net</a>.<br></div>
				<h3>Stay Connected!</h3>
					<div>
						<a href="https://twitter.com/wpsmpro" class="twitter-follow-button" data-show-count="false">Follow @wpsmpro</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
						<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fsocialmetricspro&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80&amp;appId=123108194373437" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe>
					</div>
				<h3>Need Help?</h3>
					<div>Please visit <a href="http://socialmetricspro.com/support/" style="text-decoration:none;font-weight:bold;" target="_blank">Social Metrics Pro Support</a> or email us at smpro@danieltan.zendesk.com. We are happy to help.</div>
				<h3>Join Our Affiliate Program</h3>
					<div>Promote Social Metrics Pro and earn 60% commissions! <a href="http://socialmetricspro.com/jv-invite/" style="text-decoration:none;" target="_blank">Click here to know more.</a><br></div>	
				<h3>Our Social Media Plugins You May Like</h3>
					<ul><li><a href="http://www.riyaz.net/getsocial/" target="_blank" style="text-decoration:none;font-weight:bold;">GetSocial</a> - Make your blog more social. Add a lightweight and intelligent <em><u>floating social media sharing box</u></em> on your blog posts.</li>
					<li><a href="http://www.riyaz.net/wp-tweetbox/" target="_blank" style="text-decoration:none;font-weight:bold;">WP Tweetbox</a> - Add Twitter Power to your blog. Add a highly customizable Tweetbox to your blog posts and pages. <em><u>Brand your tweets</u></em> with your own website URL.</li>
					</ul>
			</div>	
		</div>
		</div>
	</form>
</div>
</div>
<?php 
}
?>