<?php 
acf_add_local_field_group(array(
    'key' => 'why-join-main',
    'title' => 'Why Join (Main Page)',
    'hide_on_screen' => array('the_content','slug','page_attributes','format','featured_image'),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-templates/why-join-main.php',
            ),
        ),
    ),
    'fields' => array(
        array(
            'key' => 'why_join_main_intro_tab',
            'label' => 'Intro',
            'name' => 'why_join_main_intro_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'why_join_main_intro',
            'label' => 'Intro Content',
            'name' => 'why_join_main_intro',
            'type' => 'wysiwyg',
        ),
        array(
            'key' => 'why_join_order_tab',
            'label' => 'Order',
            'name' => 'why_join_order_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'why_join_order',
            'label' => 'Set Order of Account Types',
            'name' => 'why_join_order',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'account_type_page',
                    'name' => 'Account Type',
                    'type' => 'post_object',
                    'post_type' => array('page'),
                    'allow_null' => 0,
                    'return_format' => 'object',
                ),
            ),
        ),
        
     
        
       
        
        
       

     
        
    ),
    
));
    