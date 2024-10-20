<?php
include_once get_template_directory() . '/inc/functions/profile-countries.php';
include_once get_template_directory() . '/inc/functions/profile-languages.php';
include_once get_template_directory() . '/inc/functions/account-types.php';

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'rdrn_profiles',
	'title' => ' ',
	'location' => array(
		array(
			array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'profiles',
            ),
		),
	),
	'fields' => array(
		array(
			'key' => 'admin_tab',
			'label' => 'Admin',
			'name' => 'admin_tab',
			'type' => 'tab',
		),
        //REMOVED BECAUSE THESE USE WORDPRESS STATUS 'PENDING REVIEW'
        // array(
		// 	'key' => 'admin_approval',
		// 	'label' => 'Approved',
		// 	'name' => 'admin_approval',
		// 	'type' => 'true_false',
        //     'ui' => 1,
        //     'wrapper' => array('width' => '20'),
		// ),
        array(
            'key' => 'profile_related_user',
            'label' => 'User',
            'name' => 'profile_related_user',
            'type' => 'user',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '60',
            ),
            'allow_null' => 0,
            'multiple' => 0, // Only one value can be selected
            'return_format' => 'array', // 'array', 'object', or 'id'
        ),
        array(
			'key' => 'profile_information_tab',
			'label' => 'Profile Information',
			'name' => 'profile_information_tab',
			'type' => 'tab',
		),
        array(
            'key' => 'profile_types_repeater',
            'label' => 'Profile Types',
            'name' => 'profile_types_repeater',
            'type' => 'repeater',
            'wrapper' => array('width' => '100'),
            'layout' => 'block',
            'sub_fields' => array(
                array(
                    'key' => 'profile_type',
                    'label' => 'Type',
                    'name' => 'profile_type',
                    'type' => 'select',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                    'choices' => array_combine($account_types, $account_types),                    
                ),

                array(
                    'key' => 'profile_type_org',
                    'label' => 'Organisation',
                    'name' => 'profile_type_org',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '25',
                    ),
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'profile_type',  // Field key of 'profile_type'
                                'operator' => '!=',
                                'value' => 'Individual',
                            ),
                        ),
                    ),
                ),
                
                array(
                    'key' => 'profile_type_role',
                    'label' => 'Role',
                    'name' => 'profile_type_role',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '25',
                    ),
                    
                ),
            ),
        ),     
    
        array(
			'key' => 'profile_image',
			'label' => 'Profile Picture',
			'name' => 'profile_image',
			'type' => 'url',
            'wrapper' => array('width' => '30'),
		),
        array(
			'key' => 'profile_summary',
			'label' => 'Summary',
			'name' => 'profile_summary',
			'type' => 'textarea',
            'wrapper' => array('width' => '70'),
		),
        array(
			'key' => 'profile_about',
			'label' => 'About',
			'name' => 'profile_about',
			'type' => 'textarea',
            'wrapper' => array('width' => '100'),
		),
        array(
			'key' => 'profile_country',
			'label' => 'Country',
			'name' => 'profile_country',
			'type' => 'select',
            'wrapper' => array('width' => '35'),
            'choices' => array_combine($countries, $countries),
		),
        array(
			'key' => 'profile_language',
			'label' => 'Language',
			'name' => 'profile_language',
			'type' => 'select',
            'wrapper' => array('width' => '35'),
            'choices' => array_combine($languages, $languages),
		),
        array(
			'key' => 'profile_newsletter',
			'label' => 'Newsletter',
			'name' => 'profile_newsletter',
			'type' => 'true_false',
            'wrapper' => array('width' => '15'),
            'ui' => 1,
            'default_value' => 0,
		),
     
        
      
        array(
			'key' => 'profile_mentoring',
			'label' => 'Mentoring',
			'name' => 'profile_mentoring',
			'type' => 'true_false',
            'wrapper' => array('width' => '15'),
            'ui' => 1,
		),   
        array(
            'key' => 'profile_links',
            'label' => 'Website Links',
            'name' => 'profile_links',
            'type' => 'tab',
        ), 
        array(
            'key' => 'profile_website_links',
            'label' => 'Website Links',
            'name' => 'profile_website_links',
            'type' => 'repeater',
            'max' => 10,
            'sub_fields' => array(
                array(
                    'key' => 'profile_link_title',
                    'label' => 'Title',
                    'name' => 'profile_link_title',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'profile_link_url',
                    'label' => 'URL',
                    'name' => 'profile_link_url',
                    'type' => 'url',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'collaborate_on_tab',
            'label' => 'Collaborating on',
            'name' => 'collaborate_on_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'profile_collab_on',
            'label' => 'Collaborating on...',
            'name' => 'profile_collab_on',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'collab_on_post_id',
                    'name' => 'collab_on_post_id',
                    'type' => 'post_object',
                    'post_type' => array('collaboration_topics'),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'return_format' => 'object',
                    'ui' => 1,
                ),
            ),
        ),
        array(
            'key' => 'profile_research_tab',
            'label' => 'Research Interests',
            'name' => 'profile_research_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'profile_research',
            'label' => 'Research Interests',
            'name' => 'profile_research',
            'type' => 'repeater',
            'max' => 25, 
            'sub_fields' => array(
                array(
                    'key' => 'profile_research_id',
                    'name' => 'profile_research_id',
                    'type' => 'post_object',
                    'post_type' => array('research_interests'),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'return_format' => 'object',
                    'ui' => 1,
                ),
            ),
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