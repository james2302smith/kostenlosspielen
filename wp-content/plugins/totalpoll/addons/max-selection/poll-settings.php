<hr>

<p>
    <label>
        <input type="checkbox" data-toggler="maximum-selection" name="tp_options[limitations][limit_maximum_answers]" value="1" <?php checked(true, isset($options->limitations->limit_maximum_answers)); ?>> <?php _e('Limit multiple anwsers', 'tp-ms-addon') ?>
    </label>
</p>

<p data-toggle="maximum-selection" class="<?php echo isset($options->limitations->limit_maximum_answers) ? '' : 'hide'; ?>">
    <label>
	<span><?php _e('Maximum answers', 'tp-ms-addon'); ?></span>
        <input type="text" name="tp_options[limitations][maximum_answers]" value="<?php echo isset($options->limitations->maximum_answers) ? $options->limitations->maximum_answers : '0'; ?>">
    </label>
</p>