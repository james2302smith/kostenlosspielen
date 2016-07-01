<?php

if ( !defined('ABSPATH') )
    exit; // Shhh

$settings = array(
    'sections' => array(
	'general' => array(
	    'label' => __('General settings', 'custom-domain-name'),
	    'fields' => array(
		'perRow' => array(
		    'type' => 'text',
		    'label' => __('Boxes per row', 'custom-domain-name'),
		    'default' => '3',
		),
		'questionColor' => array(
		    'type' => 'color',
		    'label' => __('Question color', 'custom-domain-name'),
		    'default' => '#333333',
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
	'choices' => array(
	    'label' => __('Choice boxes', 'custom-domain-name'),
	    'fields' => array(
		'background' => array(
		    'type' => 'color',
		    'label' => __('Background', 'custom-domain-name'),
		    'default' => '#EEEEEE',
		    'states' => array( 'input' => array( 'label' => 'Checkbox/radio container background', 'default' => '#FAFAFA' ) ),
		),
		'borderColor' => array(
		    'type' => 'color',
		    'label' => __('Border color', 'custom-domain-name'),
		    'default' => '#CCCCCC',
		    'states' => array( 'image' => array( 'label' => 'Image border color', 'default' => '#FFFFFF' ) ),
		),
		'imageBorderWidth' => array(
		    'type' => 'text',
		    'label' => __('Image border width (px)', 'custom-domain-name'),
		    'default' => '2',
		),
		'color' => array(
		    'type' => 'color',
		    'label' => __('Text color', 'custom-domain-name'),
		    'default' => '#333333',
		),
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
	'votesbar' => array(
	    'label' => __('Votes bar', 'custom-domain-name'),
	    'fields' => array(
		'background' => array(
		    'type' => 'color',
		    'label' => __('Background', 'custom-domain-name'),
		    'default' => '#FFFFFF',
		),
		'color' => array(
		    'type' => 'color',
		    'label' => __('Bar color', 'custom-domain-name'),
		    'default' => '#EEEEEE',
		    'states' => array( 'text' => array( 'label' => 'Text color', 'default' => '#333333' ) ),
		),
	    )
	),
    )
);
