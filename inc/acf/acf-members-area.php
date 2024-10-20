<?php 
acf_add_local_field_group(array(
    'key' => 'members_area',
    'title' => 'Members Area',
    'hide_on_screen' => array('the_content','slug','page_attributes','format','featured_image'),
    'location' => array(
        array(
            array(
                'param' => 'page',
                'operator' => '==',
                'value' => '244',
            ),
        ),
    ),
    'fields' => array(
        array(
            'key' => 'members_notice_tab',
            'label' => 'Members Area Notice',
            'name' => 'members_notice_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'members_notice_show',
            'label' => 'Show/Hide',
            'name' => 'members_notice_show',
            'instructions' => 'Use this to display a notice to members once they log into their members area.',
            'type' => 'true_false',
            'ui' => 1
        ),
        array(
            'key' => 'members_notice_message',
            'label' => 'Message',
            'name' => 'members_notice_message',
            'type' => 'text',
            'ui' => 1,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'members_notice_show',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'members_intro',
            'label' => 'Message',
            'name' => 'members_intro',
            'type' => 'wysiwyg',
            'instructions' => 'This is the text which is displayed within the members area when a user logs in.',
        ),
       
     
        
    ),
    
));
    