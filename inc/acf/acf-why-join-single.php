<?php 
include_once get_template_directory() . '/inc/functions/account-types.php';

acf_add_local_field_group(array(
    'key' => 'why-join-single',
    'title' => 'Why Join (Single Page)',
    'hide_on_screen' => array('the_content','slug','page_attributes','format'),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-templates/why-join-single.php',
            ),
        ),
    ),
    'fields' => array(
        array(
            'key' => 'why_join_short_desc_tab',
            'label' => 'Description',
            'name' => 'why_join_short_desc_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'why_join_short_desc',
            'label' => 'Short Description',
            'name' => 'why_join_short_desc',
            'instructions' => 'This is used on the main Why Join page',
            'type' => 'wysiwyg',
        ),
        array(
            'key' => 'why_join_full',
            'label' => 'Full Description',
            'name' => 'why_join_full',
            'type' => 'wysiwyg',
        ),
        array(
            'key' => 'why_join_link',
            'label' => 'Link page to account type options',
            'name' => 'why_join_link',
            'type' => 'select',
            'choices' => array_combine($account_types, $account_types),                    
        ),
        array(
            'key' => 'why_join_word_cloud_tab',
            'label' => 'Word Cloud',
            'name' => 'why_join_word_cloud_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'why_join_word_cloud',
            'label' => 'Word Cloud',
            'name' => 'why_join_word_cloud',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'word',
                    'name' => 'Word',
                    'type' => 'text',
                    'allow_null' => 0,
                ),
            ),
        ),
        array(
            'key' => 'statements_tab',
            'label' => 'Statements',
            'name' => 'statements_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'statements',
            'label' => 'Statements',
            'name' => 'statements',
            'type' => 'repeater',
            'max' => '3',
            'sub_fields' => array(
                array(
                    'key' => 'statement_single',
                    'name' => 'Statement',
                    'type' => 'wysiwyg',
                ),
            ),
        ),
        array(
            'key' => 'projects_tab',
            'label' => 'Projects',
            'name' => 'projects_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'projects',
            'label' => 'Projects',
            'name' => 'projects',
            'type' => 'repeater',
            'sub_fields' => array(
                array(
                    'key' => 'project_content',
                    'name' => 'Content',
                    'type' => 'wysiwyg',
                    'wrapper' => array('width' => '80')
                ),
                array(
                    'key' => 'project_image',
                    'name' => 'Image',
                    'type' => 'image',
                    'wrapper' => array('width' => '20')
                ),
            ),
        ),
     
        
       
        
        
       

     
        
    ),
    
));
    