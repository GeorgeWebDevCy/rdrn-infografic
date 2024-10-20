<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'collab_on',
	'title' => ' ',
	'location' => array(
		array(
			array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'collaboration_topics',
            ),
		),
	),
	'fields' => array(
		array(
			'key' => 'collab_tooltip_content',
			'label' => 'Tooltip',
			'name' => 'collab_tooltip_content',
			'type' => 'textarea',
            'ui' => true,
		),
		
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