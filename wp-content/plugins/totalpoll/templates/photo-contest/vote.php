<form method="post">
    <ul class="choices">
	<?php foreach ( get_poll_choices() as $index => $choice ): ?>
    	<li style="width: <?php echo (100 / tp_preset_options('general', 'perRow')); ?>%">
    	    <label>
    		<div class="choice-content">
			<?php if ( $choice->type == 'image' ): ?>
			    <?php if ( !empty($choice->full) ): ?>
	    		    <a href="<?php echo esc_url($choice->full); ?>" class="zoom-image" title="<?php echo esc_attr($choice->label); ?>">
	    			<img src="<?php echo esc_url($choice->image); ?>" alt="<?php echo esc_attr($choice->label); ?>" />
	    		    </a>
			    <?php else: ?>
	    		    <img src="<?php echo esc_url($choice->image); ?>" alt="<?php echo esc_attr($choice->label); ?>" />
			    <?php endif; ?>

			    <span class="input-container"><input type="<?php echo is_poll_multianswer() ? 'checkbox' : 'radio'; ?>" name="tp_choices<?php echo is_poll_multianswer() ? '[]' : ''; ?>" value="<?php echo $choice->id ?>" <?php disabled(false, display_poll_buttons()); ?> /><?php echo $choice->label; ?></span>
			<?php endif; ?>
    		</div>
		    <?php poll_choice_vote_rendered($choice); ?>
    	    </label>
    	</li>
	    <?php if ( ($index + 1) % tp_preset_options('general', 'perRow') == 0 ): ?>
	    </ul><ul class="choices">
	    <?php endif; ?>
	<?php endforeach; ?>
    </ul>
    <div class="buttons">
        <input type="hidden" name="tp_poll_id" value="<?php echo get_poll_id(); ?>">
	<?php if ( display_poll_buttons() ): ?>
	    <?php other_poll_buttons(); ?>
	    <?php if ( is_poll_results_locked() ): ?>
		<button name="tp_action" value="vote" class="tp-btn tp-btn-disabled" disabled=""><?php _e('Vote to see results', TP_TD); ?></button>
	    <?php else: ?>
		<button name="tp_action" value="results" class="tp-btn tp-results-btn"><?php _e('Results', TP_TD); ?></button>
	    <?php endif; ?>
    	<button name="tp_action" value="vote" class="tp-btn tp-vote-btn tp-primary-btn"><?php _e('Vote', TP_TD); ?></button>
	<?php endif; ?>
    </div>
</form>