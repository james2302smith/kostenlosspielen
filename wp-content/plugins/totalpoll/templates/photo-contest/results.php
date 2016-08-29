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
			<div class="result-container">

			    <span class="score">
				<?php echo $choice->label; ?>

				<?php if ( diplay_poll_results_as('number') ): ?>
	    			&nbsp;&bull;&nbsp;<?php echo $choice->votes; ?> Votes
				<?php elseif ( diplay_poll_results_as('percentage') ): ?>
	    			&nbsp;&bull;&nbsp;<?php echo $choice->votes_percentage; ?>%
				<?php elseif ( diplay_poll_results_as('both') ): ?>
	    			&nbsp;&bull;&nbsp;<?php echo $choice->votes; ?> Votes (<?php echo $choice->votes_percentage; ?>%)
				<?php endif; ?>
			    </span>

			    <div class="current-score" data-animate-width="<?php echo $choice->votes_percentage; ?>%" data-animate-duration="<?php echo tp_preset_options('general', 'animationDuration'); ?>"></div>
			</div>
		    <?php endif; ?>
		    <?php poll_choice_result_rendered($choice); ?>
    	    </div>
    	</label>
        </li>

	<?php if ( ($index + 1) % tp_preset_options('general', 'perRow') == 0 ): ?>
	</ul><ul class="choices">
	<?php endif; ?>

    <?php endforeach; ?>
</ul>
<div class="buttons">
    <?php if ( display_poll_buttons() ): ?>
        <form method="post">
	    <?php other_poll_buttons(); ?>
    	<input type="hidden" name="tp_poll_id" value="<?php echo get_poll_id(); ?>">
	    <?php if ( user_can_vote() ): ?>
		<button name="tp_action" value="back" class="tp-btn tp-back-btn"><?php _e('Back', TP_TD); ?></button>
	    <?php endif; ?>
        </form>
    <?php endif; ?>
</div>