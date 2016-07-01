<?php
if ( !defined('ABSPATH') ) exit; // Shhh
$tp_ch_canvas = uniqid('results-');
?>

<div class="results">
    <div class="canvas-holder">
        <div style="height: <?php echo tp_preset_options('charts', 'size', false, false, 300); ?>px;">
        <canvas id="<?php echo $tp_ch_canvas; ?>" class="tp-chart"></canvas>
        </div>
    </div>
    <div class="map-holder"></div>
</div>

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

<script type="text/javascript">
    setTimeout(function(){  
        
        chartify.init(<?php printf("'%s', '%s', %s, %s, '%s', %s", 
            $tp_ch_canvas, 
            tp_preset_options('charts', 'type', false, false, 'pie'), 
            json_encode(tp_ch_get_data()), 
            json_encode(tp_ch_get_options_array()), 
            $poll->misc->show_results,
            json_encode( array(
                'votes' => sprintf( _n('%s Vote', '%s Votes', $choice->votes, TP_TD), $choice->votes )
            ))
        ); ?>);
                
    }, 800);
</script>
