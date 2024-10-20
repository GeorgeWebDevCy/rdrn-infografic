<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'research_interest',
	'title' => ' ',
	'hide_on_screen' => array('the_content','slug','page_attributes','format','featured_image'),
	'location' => array(
		array(
			array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'research_interests',
            ),
		),
	),
	'fields' => array(
		array(
			'key' => 'research_tooltip',
			'label' => 'Tooltip',
			'name' => 'research_tooltip',
			'type' => 'textarea',
		),
		array(
			'key' => 'research_orphanet_code',
			'label' => 'Orphnet Code (optional)',
			'name' => 'research_orphanet_code',
			'type' => 'number',
		),
		
	),

));

endif;