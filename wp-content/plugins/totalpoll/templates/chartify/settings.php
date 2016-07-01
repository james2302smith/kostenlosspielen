<?php
if ( !defined('ABSPATH') ) exit; // Shhh

$settings = array(
    'sections' => array(
        'general' => array(
            'label' => __('General settings', 'custom-domain-name'),
            'fields' => array(
                'containerBorder' => array(
                    'type' => 'color',
                    'label' => __('Container border', 'custom-domain-name'),
                    'default' => '#DDDDDD',
                ),
                'containerBackground' => array(
                    'type' => 'color',
                    'label' => __('Container background', 'custom-domain-name'),
                    'default' => '#FFFFFF',
                ),
                'warningBackground' => array(
                    'type' => 'color',
                    'label' => __('Warning messages background', 'custom-domain-name'),
                    'default' => '#FFF9E8',
                ),
                'warningBorder' => array(
                    'type' => 'color',
                    'label' => __('Warning messages border', 'custom-domain-name'),
                    'default' => '#E8D599',
                ),
                'warningColor' => array(
                    'type' => 'color',
                    'label' => __('Warning messages text color', 'custom-domain-name'),
                    'default' => '#333333',
                ),
                'questionBackground' => array(
                    'type' => 'color',
                    'label' => __('Question background', 'custom-domain-name'),
                    'default' => '#EEEEEE',
                ),
                'questionColor' => array(
                    'type' => 'color',
                    'label' => __('Question color', 'custom-domain-name'),
                    'default' => '#333333',
                ),
                'choiceColor' => array(
                    'type' => 'color',
                    'label' => __('Choice color', 'custom-domain-name'),
                    'default' => '#333333',
                ),
                'choiceInputBackground' => array(
                    'type' => 'color',
                    'label' => __('Checkbox background', 'custom-domain-name'),
                    'default' => '#EEEEEE',
                ),
                'animationDuration' => array(
                    'type' => 'text',
                    'label' => __('Animation duration (ms)', 'custom-domain-name'),
                    'default' => '1000',
                ),
                'borderRadius' => array(
                    'type' => 'text',
                    'label' => __('Border radius (px)', 'custom-domain-name'),
                    'default' => '2',
                )
            )
        ),
        'buttons' => array(
            'label' => __('Buttons', 'custom-domain-name'),
            'fields' => array(
                'background' => array(
                    'type' => 'color',
                    'label' => __('Background', 'custom-domain-name'),
                    'default' => '#EEEEEE',
                    'states' => array( 'hover' => array( 'label' => 'Hover', 'default' => '#E5E5E5' ) ),
                ),
                'primaryBackground' => array(
                    'type' => 'color',
                    'label' => __('Primary background', 'custom-domain-name'),
                    'default' => '#1E73BE',
                    'states' => array( 'hover' => array( 'label' => 'Hover', 'default' => '#308DDF' ) ),
                ),
                'color' => array(
                    'type' => 'color',
                    'label' => __('Default color', 'custom-domain-name'),
                    'default' => '#333333',
                    'states' => array( 'hover' => array( 'label' => 'Hover', 'default' => '#333333' ) ),
                ),
                'primaryColor' => array(
                    'type' => 'color',
                    'label' => __('Primary color', 'custom-domain-name'),
                    'default' => '#FFFFFF',
                    'states' => array( 'hover' => array( 'label' => 'Hover', 'default' => '#FFFFFF' ) ),
                ),
                'borderColor' => array(
                    'type' => 'color',
                    'label' => __('Border color', 'custom-domain-name'),
                    'default' => '#CCCCCC',
                    'states' => array( 'hover' => array( 'label' => 'Hover', 'default' => '#CCCCCC' ) ),
                ),
                'primaryBorderColor' => array(
                    'type' => 'color',
                    'label' => __('Border color', 'custom-domain-name'),
                    'default' => '#1B66A8',
                    'states' => array( 'hover' => array( 'label' => 'Hover', 'default' => '#1E73BE' ) ),
                ),
            )
        ),
        'charts' => array(
            'label' => __('Charts', 'custom-domain-name'),
            'fields' => array(
                'type' => array(
                    'type' => 'select',
                    'label' => __('Chart Type', 'custom-domain-name'),
                    'default' => 'doughnut',
                    'options' => array(
                        array(
                            'value' => 'Pie',
                            'label' => __('Pie', 'custom-domain-name')
                        ),
                        array(
                            'value' => 'Doughnut',
                            'label' => __('Doughnut', 'custom-domain-name')
                        ),
                        array(
                            'value' => 'PolarArea',
                            'label' => __('Polar Area', 'custom-domain-name')
                        )
                    )
                ),
                'size' => array(
                    'type' => 'text',
                    'label' => __('Canvas Height (px)', 'custom-domain-name'),
                    'default' => '400',
                ),
                'animation' => array(
                    'type' => 'select',
                    'label' => __('Chart Animation', 'custom-domain-name'),
                    'default' => 'true',
                    'options' => array(
                        array(
                            'value' => 'true',
                            'label' => __('Enabled', 'custom-domain-name')
                        ),
                        array(
                            'value' => 'false',
                            'label' => __('Disabled', 'custon-domain-name')
                        )
                    )
                ),
                'animationEasing' => array(
                    'type' => 'select',
                    'label' => __('Animation Easing', 'custom-domain-name'),
                    'default' => 'easeOutQuart',
                    'options' => array(
                        array(
                            'value' => 'linear',
                            'label' => __('linear','custon-domain-name')
                        ),array(
                            'value' => 'swing',
                            'label' => __('swing','custon-domain-name')
                        ),array(
                            'value' => 'easeOutQuad',
                            'label' => __('easeOutQuad','custon-domain-name')
                        ),array(
                            'value' => 'easeOutCubic',
                            'label' => __('easeOutCubic','custon-domain-name')
                        ),array(
                            'value' => 'easeOutQuart',
                            'label' => __('easeOutQuart','custon-domain-name')
                        ),array(
                            'value' => 'easeOutQuint',
                            'label' => __('easeOutQuint','custon-domain-name')
                        ),array(
                            'value' => 'easeOutExpo',
                            'label' => __('easeOutExpo','custon-domain-name')
                        ),array(
                            'value' => 'easeOutSine',
                            'label' => __('easeOutSine','custon-domain-name')
                        ),array(
                            'value' => 'easeOutCirc',
                            'label' => __('easeOutCirc','custon-domain-name')
                        ),array(
                            'value' => 'easeOutElastic',
                            'label' => __('easeOutElastic','custon-domain-name')
                        ),array(
                            'value' => 'easeOutBack',
                            'label' => __('easeOutBack','custon-domain-name')
                        ),array(
                            'value' => 'easeOutBounce',
                            'label' => __('easeOutBounce','custon-domain-name')
                        )
                    )
                ),
                'map' => array(
                    'type' => 'select',
                    'label' => __('Legend Map', 'custom-domain-name'),
                    'default' => 'below',
                    'options' => array(
                        array(
                            'value' => 'none',
                            'label' => __('Labels On Tooltip', 'custom-domain-name')
                        ),
                        array(
                            'value' => 'below',
                            'label' => __('Below', 'custom-domain-name')
                        ),
                        array(
                            'value' => 'float',
                            'label' => __('Float', 'custon-domain-name')
                        )
                    )
                ),
                'mapBackground' => array(
                    'type' => 'color',
                    'label' => __('Map Backround', 'custom-domain-name'),
                    'default' => '#F4F4F4',
                    'states' => array( 'hover' => array( 'label' => __('Hover', 'custom-domain-name'), 'default' => '#FAFAFA' ) ),
                ),
                'hoverBorder' => array(
                    'type' => 'color',
                    'label' => __('Map Hover Border', 'custom-domain-name'),
                    'default' => '#6D6D6D'
                )
            )
        ),
        'colors' => array(
            'label' => __('Chart Colors', 'custom-domain-name'),
            'fields' => array(
                'pieColors' => array(
                    'type' => 'tp_ch_pie_colors',
                    'label' => __('Color for choice #%s', 'custom-domain-name'),
                    'labelHighlight' => __('Highlight color for choice #%s', 'custom-domain-name'),
                    'colors' => array( '#FFCE80', '#CC363A', '#76CCFF' )
                )
            )
        ),
	'typography' => array(
	    'label' => __('Typography', TP_TD),
	    'fields' => array(
		'lineHeight' => array(
		    'type' => 'text',
		    'label' => __('Line height', TP_TD),
		    'default' => 'inherit',
		),
		'fontFamily' => array(
		    'type' => 'text',
		    'label' => __('Font Family', TP_TD),
		    'default' => 'inherit',
		),
		'fontSize' => array(
		    'type' => 'text',
		    'label' => __('Font Size', TP_TD),
		    'default' => '1rem',
		),
	    )
	),
    )
);

