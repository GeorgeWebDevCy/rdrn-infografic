<?php
// Check if function exists and hook into setup.
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'user_custom_fields',
	'title' => 'User Custom Fields',
	'location' => array(
		array(
			array(
				'param' => 'user_form',
				'operator' => '==',
				'value' => 'all',
			),
		),
	),
	'fields' => array(
		array(
			'key' => 'email_verified',
			'label' => 'Email Verified',
			'name' => 'email_verified',
			'type' => 'true_false',
			'default_value' => 0,
            'ui' => true,
		),
		array(
			'key' => 'user_telephone',
			'label' => 'Telephone',
			'name' => 'user_telephone',
			'type' => 'text',
		),
		array(
			'key' => 'user_last_login',
			'label' => 'Last Login',
			'name' => 'user_last_login',
			'type' => 'date_time_picker',
		),
		// Add more fields as needed
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;