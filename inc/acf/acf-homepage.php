<?php 
acf_add_local_field_group(array(
    'key' => 'homepage',
    'title' => 'Homepage',
    'hide_on_screen' => array('the_content','slug','page_attributes','format','featured_image'),
    'location' => array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page',
            ),
        ),
    ),
    'fields' => array(
        array(
            'key' => 'header_slides_tab',
            'label' => 'Header Slides',
            'name' => 'header_slides_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'header_slides',
            'label' => 'Slides',
            'name' => 'header_slides',
            'type' => 'repeater',
            'layout' => 'block',
            'instructions' => "For icons use the class from https://icons.getbootstrap.com/icons/",
            'sub_fields' => array(
                array(
                    'key' => 'background',
                    'label' => 'Background Image',
                    'name' => 'background',
                    'type' => 'image',
                ),
                array(
                    'key' => 'content',
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'wysiwyg',
                ),
                array(
                    'key' => 'button1',
                    'label' => 'Button 1',
                    'name' => 'button1',
                    'type' => 'link',
                ),
                array(
                    'key' => 'button1_icon',
                    'label' => 'Button 1 Icon',
                    'name' => 'button1_icon',
                    'type' => 'text',
                ),
                array(
                    'key' => 'button2',
                    'label' => 'Button 2',
                    'name' => 'button2',
                    'type' => 'link',
                ),
                array(
                    'key' => 'button2_icon',
                    'label' => 'Button 2 Icon',
                    'name' => 'button2_icon',
                    'type' => 'text',
                ),
            ),
        ),
        array(
            'key' => 'cards_tab',
            'label' => 'Cards',
            'name' => 'cards_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'cards',
            'label' => 'Cards',
            'name' => 'cards',
            'type' => 'repeater',
            'layout' => 'row',
            'button_label' => 'Add Card',
            'collapsed' => 'title',
            'sub_fields' => array(
                array(
                    'key' => 'card_icon',
                    'label' => 'Icon',
                    'name' => 'card_icon',
                    'type' => 'text',
                ),
                array(
                    'key' => 'card_title',
                    'label' => 'Title',
                    'name' => 'card_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'card_content',
                    'label' => 'Content',
                    'name' => 'card_content',
                    'type' => 'wysiwyg',
                ),
            ),
        ),
        array(
            'key' => 'testimonial_tab',
            'label' => 'Testimonial',
            'name' => 'testimonial_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'testimonial_image',
            'label' => 'Image',
            'name' => 'testimonial_image',
            'type' => 'image',
            'wrapper' => array('width' => '20'),
        ),
        array(
            'key' => 'testimonial_content',
            'label' => 'Content',
            'name' => 'testimonial_content',
            'type' => 'wysiwyg',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'testimonial_author',
            'label' => 'Author',
            'name' => 'testimonial_author',
            'type' => 'text',
            'wrapper' => array('width' => '30'),
        ),
        array(
            'key' => 'infographic_tab',
            'label' => 'Infographic',
            'name' => 'infographic_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'info_patients_title',
            'label' => 'Patient Group Title',
            'name' => 'info_patients_title',
            'type' => 'text',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'info_patients_text',
            'label' => 'Patient Group Content',
            'name' => 'info_patients_text',
            'type' => 'text',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'info_community_title',
            'label' => 'Community Title',
            'name' => 'info_community_title',
            'type' => 'text',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'info_community_text',
            'label' => 'Community Text',
            'name' => 'info_community_text',
            'type' => 'text',
            'wrapper' => array('width' => '50'),
        ),
        array(
            'key' => 'patient_groups',
            'label' => 'Patient Groups',
            'name' => 'patient_groups',
            'type' => 'repeater',
            //'layout' => 'row',
            'button_label' => 'Add Group',
            'collapsed' => 'name',
            'sub_fields' => array(
                array(
                    'key' => 'name',
                    'label' => 'Group Name',
                    'name' => 'name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'text',
                ),
                array(
                    'key' => 'icon',
                    'label' => 'Icon',
                    'name' => 'icon',
                    'type' => 'image',
                ),
            ),
        ),
        array(
            'key' => 'stakeholder_tab',
            'label' => 'Stakeholder tabs',
            'name' => 'stakeholder_tab',
            'type' => 'tab',
        ),
        array(
            'key' => 'get_involved_tabs',
            'label' => 'Stakeholder Tabs',
            'name' => 'get_involved_tabs',
            'type' => 'repeater',
            'button_label' => 'Add Tab',
            'collapsed' => 'title',
            'layout' => 'block',
            'sub_fields' => array(
                array(
                    'key' => 'title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'content',
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'wysiwyg',
                ),
                array(
                    'key' => 'page_link',
                    'label' => 'Link',
                    'name' => 'page_link',
                    'type' => 'link',
                ),
                
            ),
        ),
        array(
            'key' => 'get_involved_button',
            'label' => 'Button',
            'name' => 'get_involved_button',
            'type' => 'link',
            'wrapper' => array('width' => '80'),
        ),
        array(
            'key' => 'get_involved_icon',
            'label' => 'Icon',
            'name' => 'get_involved_icon',
            'type' => 'text',
            'wrapper' => array('width' => '20'),
        ),
        array(
            'key' => 'counters_tab',
            'label' => 'Counters',
            'name' => 'counters_tab',
            'type' => 'tab',
        ),
        
        array(
            'key' => 'counters_1_number',
            'label' => 'Counters 1 Number',
            'name' => 'counters_1_number',
            'type' => 'number',
            'wrapper' => array('width' => '40'),
        ),
        array(
            'key' => 'counters_1_title',
            'label' => 'Counters 1 Title',
            'name' => 'counters_1_title',
            'type' => 'text',
            'wrapper' => array('width' => '60'),
        ),
        
        array(
            'key' => 'counters_2_number',
            'label' => 'Counters 2 Number',
            'name' => 'counters_2_number',
            'type' => 'number',
            'wrapper' => array('width' => '40'),
        ),
        array(
            'key' => 'counters_2_title',
            'label' => 'Counters 2 Title',
            'name' => 'counters_2_title',
            'type' => 'text',
            'wrapper' => array('width' => '60'),
        ),
       
        array(
            'key' => 'counters_3_number',
            'label' => 'Counters 3 Number',
            'name' => 'counters_3_number',
            'type' => 'number',
            'wrapper' => array('width' => '40'),
        ),
        array(
            'key' => 'counters_3_title',
            'label' => 'Counters 3 Title',
            'name' => 'counters_3_title',
            'type' => 'text',
            'wrapper' => array('width' => '60'),
        ),
       
       

     
        
    ),
    
));
    