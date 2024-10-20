<?php
//Site Settings
acf_add_local_field_group(array(
	'key' => 'site_settings',
	'title' => 'Site Settings',
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'site-settings',
			),
		),
	),
    'fields' => array(
        array(
            'key' => 'company_tab',
            'label' => 'Company Information',
            'name' => 'header_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'address',
            'label' => 'Address',
            'name' => 'address',
            'type' => 'wysiwyg',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'email_address',
            'label' => 'Email Address (Contact forms will go to this)',
            'name' => 'email_address',
            'type' => 'text',
            'wrapper' => array('width' => '25'),
        ),
       
        array(
            'key' => 'telephone',
            'label' => 'Telephone',
            'name' => 'telephone',
            'type' => 'text',
            'wrapper' => array('width' => '25'),
        ),
        array(
            'key' => 'header_logo',
            'label' => 'Header Logo',
            'name' => 'header_logo',
            'type' => 'image',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'social_tab',
            'label' => 'Socials',
            'name' => 'social_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'linkedin',
            'label' => 'LinkedIn URL',
            'name' => 'linkedin',
            'type' => 'url',
        ),
        array(
            'key' => 'facebook',
            'label' => 'Facebook URL',
            'name' => 'facebook',
            'type' => 'url',
        ),
        array(
            'key' => 'twitter',
            'label' => 'Twitter URL',
            'name' => 'twitter',
            'type' => 'url',
        ),
        array(
            'key' => 'instagram',
            'label' => 'Instagram URL',
            'name' => 'instagram',
            'type' => 'text',
        ),
        array(
            'key' => 'youtube',
            'label' => 'YouTube URL',
            'name' => 'youtube',
            'type' => 'url',
        ),
        array(
            'key' => 'threads',
            'label' => 'Threads URL',
            'name' => 'threads',
            'type' => 'url',
        ),
        
        array(
            'key' => 'site_settings_tab',
            'label' => 'Site Settings',
            'name' => 'site_settings_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'default_header_image',
            'label' => 'Default Header Image',
            'name' => 'default_header_image',
            'type' => 'image',
        ),
        array(
            'key' => 'footer_tab',
            'label' => 'Footer',
            'name' => 'footer_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'footer_logo',
            'label' => 'Footer Logo',
            'name' => 'footer_logo',
            'type' => 'image',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'footer_logos',
            'label' => 'Footer Logos',
            'name' => 'footer_logos',
            'type' => 'repeater',
            'button_label' => 'Add Logo',
            'sub_fields' => array(
                array(
                    'key' => 'logo',
                    'label' => 'Logo',
                    'name' => 'logo',
                    'type' => 'image',
                    'wrapper' => array('width' => '40'),
                ),
                array(
                    'key' => 'link',
                    'label' => 'Link',
                    'name' => 'link',
                    'type' => 'url',
                    'wrapper' => array('width' => '60'),
                ),
                
            ),
        ),
        array(
            'key' => 'sign_up',
            'label' => 'Sign Up',
            'name' => 'sign_up',
            'type' => 'tab',
        ),
        array(
            'key' => 'default_profile',
            'label' => 'Default Profile Image',
            'name' => 'default_profile',
            'type' => 'image',
            'wrapper' => array('width' => '10'),
        ),
    )
));