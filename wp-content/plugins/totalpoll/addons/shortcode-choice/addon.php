<?php
if ( !defined('ABSPATH') )
    exit; // Shhh

    /*
      Addon Name: Shortcode choice
      Description: More power with shortcodes in choices.
      Addon URI: http://wpsto.re/addons/downloads/shortcode-choice/
      Author: WPStore
      Author URI: http://wpsto.re/
      Version: 1.0
      Required: 2.0
     */

/**
 * Shortcode choice addon.
 * 
 * @version 1.0.0
 * @package TotalPoll\Addons\ShortcodeChoice
 */
Class TP_Shortcode_Choice_Addon {

    /**
     * Register some hooks.
     * 
     * @since 1.0.0
     * @return void
     */
    public function __construct()
    {
	// Text domain
	load_plugin_textdomain('tp-shortcode-addon', false, TP_ADDONS_PATH . DS . dirname(__FILE__) . '/languages/');
	// Button
	add_action('tp_admin_editor_choice_types_buttons', array( $this, 'button' ));
	// Fields
	add_action('tp_admin_editor_shortcode_choice_fields', array( $this, 'fields' ), 10, 2);
	// Template
	add_action('tp_admin_editor_choice_types_templates', array( $this, 'template' ));
	// Render vote
	add_action('tp_render_shortcode_choice_vote', array( $this, 'render' ));
	// Render result
	add_action('tp_render_shortcode_choice_result', array( $this, 'render' ));
    }

    /**
     * Choice button.
     * 
     * @since 1.0.0
     * @return void
     */
    public function button()
    {
	?>
	<li>
	    <button type="button" class="button" data-template="choice-shortcode"><?php _e('Shortcode', 'tp-shortcode-addon'); ?></button>
	</li>
	<?php
    }

    /**
     * Choice fields.
     * 
     * @since 1.0.0
     * @param object $choice
     * @param int $index
     * 
     */
    public function fields($choice, $index)
    {
	?>
	<label class="horizontal-label"><?php _e('Shortcode', 'tp-shortcode-addon'); ?>:</label>
	<input type="text" placeholder="<?php _e('Shortcode', 'tp-shortcode-addon'); ?>" name="tp_options[choices][<?php echo $index; ?>][shortcode]" value="<?php echo esc_attr($choice->shortcode) ?>" class="widefat">
	<?php
    }

    /**
     * Choice template.
     * 
     * @since 1.0.0
     * @return void
     */
    public function template()
    {
	?>
	<script type="text/template" class="choice-template" id="choice-shortcode">
	    <div class="choice choice-text">
	    <input type="hidden" name="tp_options[choices][{{index}}][type]" value="shortcode">
	    <label class="horizontal-label votes-label"><?php _e('Votes', TP_TD); ?>:</label>
	    <input type="text" placeholder="<?php _e('Votes', TP_TD); ?>" name="tp_options[choices][{{index}}][votes]" class="votes-counter widefat">
	    <label class="horizontal-label"><?php _e('Shortcode', 'tp-shortcode-addon'); ?>:</label>
	    <input type="text" placeholder="<?php _e('Shortcode', 'tp-shortcode-addon'); ?>" name="tp_options[choices][{{index}}][shortcode]" class="widefat">
	    <?php do_tp_action("tp_admin_editor_shortcode_choice_fields_template", $choice, $index); ?>
	    <ul class="choice-controllers">
	    <li><button type="button" class="move">&equiv;</button></li>
	    <li><button type="button" class="delete">&#10006;</button></li>
	    <?php do_tp_action("tp_admin_editor_shortcode_choice_buttons_template"); ?>
	    </ul>
	    </div>
	</script>
	<?php
    }

    /**
     * Render choice.
     * 
     * @since 1.0.0
     * @return void
     */
    public function render($choice)
    {
	echo do_shortcode($choice->shortcode);
    }

}

// Bootstrap
new TP_Shortcode_Choice_Addon();
