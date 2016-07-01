<?php 
/**
 * Template to show the messages
 * 
 * @uses 	array		$msg_error
 * @uses 	array		$msg_error_item
 * 
 * @uses 	array		$msg_notify
 * @uses 	array		$msg_notify_item
 * 
 * @package admin-panel
 * @version v5.0
 */
?>
<?php if (isset($msg_error)) {?>
	<?php foreach ($msg_error as $msg_error_item) { ?>
		<div class="error" style="padding: 0 0.7em;"> 
			<p>
				<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>
				<?php echo $msg_error_item; ?>
			</p>
		</div>
	 <?php } ?>
<?php }?>
<?php if (isset($msg_notify)) {?>
	<?php foreach ($msg_notify as $msg_notify_item) { ?>
		<div class="updated" style="margin-top: 20px; padding: 0 0.7em;"> 
			<p>
				<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
				<?php echo $msg_notify_item; ?>
			</p>
		</div>
	<?php } ?>
<?php } ?>
<?php if (isset($msg_warning)) {?>
	<?php foreach ($msg_warning as $msg_warning_item) { ?>
		<div class="updated" style="margin-top: 20px; padding: 0 0.7em; background-color: rgb(206, 223, 245); border-color: rgb(132, 156, 229);"> 
			<p>
				<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
				<?php echo $msg_warning_item; ?>
			</p>
		</div>
	<?php } ?>
<?php } ?>
