<?php
//exit if accessed direct
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {
  // Enqueue common styles and scripts
  wp_enqueue_style('styles', get_stylesheet_directory_uri() . '/inc/styles.css');
  wp_enqueue_style('bootstrap-icons', get_template_directory_uri() . '/node_modules/bootstrap-icons/font/bootstrap-icons.css');
  wp_enqueue_style('swiper-style', get_template_directory_uri() . '/node_modules/swiper/swiper-bundle.min.css', array(), '1.0');
  wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);

  wp_enqueue_script('swiper-script', get_template_directory_uri() . '/node_modules/swiper/swiper-bundle.min.js', array(), '1.0', true);
  wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);
  wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/inc/js/scripts.js', array('swiper-script'), '1.0', true);
  wp_enqueue_script('registration', get_stylesheet_directory_uri() . '/inc/js/registration.js', array(), '1.0', true);

  // Localize script for registration
  wp_localize_script('registration', 'localData', array(
      'members_URL' => get_permalink(244),
  ));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function enqueue_search_script() {
  if (is_page('search')) {
      wp_enqueue_script('select2-js', get_stylesheet_directory_uri() . '/inc/js/select2.min.js', array('jquery'), null, true);
      wp_enqueue_script('search-js', get_template_directory_uri() . '/inc/js/search.js', array('jquery'), null, true);
      wp_localize_script('search-js', 'localData', array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'ajax_nonce' => wp_create_nonce('ajax_search_nonce')
      ));
  }
}
add_action('wp_enqueue_scripts', 'enqueue_search_script');


// ACF Fields
if( function_exists('acf_add_local_field_group') ):
	get_template_part('inc/acf/acf');
endif;

//Title tag
add_theme_support( 'title-tag' );

//Meta Description
function add_custom_meta_description() {
  $description = get_bloginfo('description', 'display');
  if ($description) {
      echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
  }
}
add_action('wp_head', 'add_custom_meta_description');


//Settings Page in wp-admin
add_action('acf/init', 'site_settings');
function site_settings() {
    if( function_exists('acf_add_options_page') ) {
      $option_page = acf_add_options_page(
      array(
        'page_title'    => __('Website Settings'),
        'menu_title'    => __('Site Settings'),
        'menu_slug'     => 'site-settings',
        'capability'    => 'activate_plugins',
        'redirect'      => false,
        'position' => '1'
          )
    );
  }
};

//Menu
function rw_register_nav_menus() {
  register_nav_menus(
      array(
          'main-menu' => 'Main Menu'
      )
  );
}
add_action('init', 'rw_register_nav_menus');

add_filter('use_block_editor_for_post', '__return_false', 10);

function register_theme_menus() {
    register_nav_menus(array(
        'main-menu' => 'Main Menu',
        'footer-menu' => 'Footer Menu'
    ));
}
add_action('init', 'register_theme_menus');

//Allow SVG
function custom_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

//Admin styles
function custom_admin_styles() {
  // Enqueue the custom admin stylesheet
  wp_enqueue_style('custom-admin-styles', get_template_directory_uri() . '/inc/admin-styles.css');
}
add_action('admin_enqueue_scripts', 'custom_admin_styles');

//featured images
function theme_setup() {
  add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'theme_setup' );



//user functions
require_once( get_template_directory() .'/inc/functions/user-functions.php' );

//search functions
require_once( get_template_directory() .'/inc/functions/search-functions.php' );

//Profiles custom post type
function create_profiles_post_type() {
  $labels = array(
      'name'                  => _x('Profiles', 'Post type general name', 'textdomain'),
      'singular_name'         => _x('Profile', 'Post type singular name', 'textdomain'),
      'menu_name'             => _x('Profiles', 'Admin Menu text', 'textdomain'),
      'name_admin_bar'        => _x('Profile', 'Add New on Toolbar', 'textdomain'),
      'add_new'               => __('Add New', 'textdomain'),
      'add_new_item'          => __('Add New Profile', 'textdomain'),
      'new_item'              => __('New Profile', 'textdomain'),
      'edit_item'             => __('Edit Profile', 'textdomain'),
      'view_item'             => __('View Profile', 'textdomain'),
      'all_items'             => __('All Profiles', 'textdomain'),
      'search_items'          => __('Search Profiles', 'textdomain'),
      'not_found'             => __('No profiles found.', 'textdomain'),
      'not_found_in_trash'    => __('No profiles found in Trash.', 'textdomain'),
  );

  $args = array(
      'labels'             => $labels,
      'public'             => true,
      'has_archive'        => true,
      'rewrite'            => array('slug' => 'profile', 'with_front' => false),
      'supports'           => array('title'),
      'menu_icon'          => 'dashicons-businessman', 

  );

  register_post_type('profiles', $args);
}
add_action('init', 'create_profiles_post_type');

//collaboration topics
// Collaboration Topics Custom Post Type
function create_collaboration_topics_cpt() {

  $labels = array(
      'name' => 'Collaboration Topics',
      'singular_name' => 'Collaboration Topic',
      'add_new' => 'Add New',
      'add_new_item' => 'Add New Collaboration Topic',
      'edit_item' => 'Edit Collaboration Topic',
      'new_item' => 'New Collaboration Topic',
      'view_item' => 'View Collaboration Topic',
      'all_items' => 'All Collaboration Topics',
      'search_items' => 'Search Collaboration Topics',
      'not_found' => 'No Collaboration Topics found',
  );

  $args = array(
    'label' => 'Collaboration Topics',
    'labels' => $labels,
    'supports' => array('title'),
    'public' => true,
    'show_ui' => true,
    'menu_icon' => 'dashicons-lightbulb',
    'exclude_from_search' => true, // Exclude from search results
    'publicly_queryable' => false, // Disable single post view
  );

  register_post_type('collaboration_topics', $args);
}

// Register Custom Post Type
add_action('init', 'create_collaboration_topics_cpt', 0);

//Research interests
// Register Custom Post Type Research Interests
function create_research_interests_cpt() {

  $labels = array(
      'name' => _x( 'Research Interests', 'Post Type General Name', 'textdomain' ),
      'singular_name' => _x( 'Research Interest', 'Post Type Singular Name', 'textdomain' ),
      'menu_name' => _x( 'Research Interests', 'Admin Menu text', 'textdomain' ),
      'name_admin_bar' => _x( 'Research Interest', 'Add New on Toolbar', 'textdomain' ),
  );
  
  $args = array(
      'label' => __( 'Research Interest', 'textdomain' ),
      'labels' => $labels,
      'supports' => array( 'title', 'editor', 'thumbnail' ),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'menu_icon' => 'dashicons-lightbulb',
      'show_in_admin_bar' => true,
      'show_in_nav_menus' => true,
      'can_export' => true,
      'has_archive' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'capability_type' => 'post',
  );
  
  register_post_type( 'research_interests', $args );

}
add_action( 'init', 'create_research_interests_cpt', 0 );

// Register Custom Taxonomy Source
function create_source_taxonomy() {

  $labels = array(
      'name' => _x( 'Sources', 'Taxonomy General Name', 'textdomain' ),
      'singular_name' => _x( 'Source', 'Taxonomy Singular Name', 'textdomain' ),
      'menu_name' => __( 'Source', 'textdomain' ),
  );
  
  $args = array(
      'labels' => $labels,
      'hierarchical' => true,
      'public' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => true,
      'show_tagcloud' => true,
  );
  
  register_taxonomy( 'source', array( 'research_interests' ), $args );

}
add_action( 'init', 'create_source_taxonomy', 0 );

//disable all comments functions
function remove_comments_menu() {
  remove_menu_page('edit-comments.php'); // Removes the Comments menu item
}
add_action('admin_menu', 'remove_comments_menu');

function remove_comments_metabox() {
  remove_meta_box('commentsdiv', 'post', 'normal'); // Removes the comments metabox from posts
  remove_meta_box('commentsdiv', 'page', 'normal'); // Removes the comments metabox from pages
}
add_action('admin_menu', 'remove_comments_metabox');

//Create function to make sure profile is approved and also their user account is approved and also that their email is verified


//Why Join - when setting order show only child pages
function filter_post_object_query($args, $field, $post_id) {
  // Check if the field key matches your specific field
  if ($field['key'] === 'account_type_page') {
      // Modify the query to return only child pages of page with ID 200
      $args['post_parent'] = 110;
  }
  return $args;
}
add_filter('acf/fields/post_object/query', 'filter_post_object_query', 10, 3);


// add_action( 'phpmailer_init', 'phpmailer_smtp' );
// function phpmailer_smtp( $phpmailer ) {
// 	$phpmailer->isSMTP();
// 	$phpmailer->Host = SMTP_server;
// 	$phpmailer->SMTPAuth = SMTP_AUTH;
// 	$phpmailer->Port = SMTP_PORT;
// 	$phpmailer->Username = SMTP_username;
// 	$phpmailer->Password = SMTP_password;
// 	$phpmailer->SMTPSecure = SMTP_SECURE;
// 	$phpmailer->From = SMTP_FROM;
// 	$phpmailer->FromName = SMTP_NAME;
// }

/*************************************************************************************** GeorgeWebDevCY Start***************************************************************** */
// Adding ACF fields programmatically
add_action('acf/init', 'create_acf_fields_for_infographic');
function create_acf_fields_for_infographic() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Infographic Links',
            'menu_title' => 'Infographic Links',
            'menu_slug'  => 'infographic-links',
            'capability' => 'edit_posts',
            'redirect'   => false
        ));
    }

    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_infographic_links',
            'title' => 'Infographic Links',
            'fields' => array(
                array(
                    'key' => 'field_link_individuals',
                    'label' => 'Individuals Link',
                    'name' => 'link_individuals',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_link_organisations',
                    'label' => 'Organisations Link',
                    'name' => 'link_organisations',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_link_researchers',
                    'label' => 'Researchers Link',
                    'name' => 'link_researchers',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_link_healthcare',
                    'label' => 'Healthcare Link',
                    'name' => 'link_healthcare',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_link_industry',
                    'label' => 'Industry Link',
                    'name' => 'link_industry',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_link_founder',
                    'label' => 'Founder Link',
                    'name' => 'link_founder',
                    'type' => 'url',
                    'required' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'infographic-links',
                    ),
                ),
            ),
        ));
    }
}

function interactive_infographic_shortcode() {
  ob_start(); ?>
  <div id="infographic-container" style="position: relative;">
      <img id="image1" class="infographic-image" src="<?php echo get_template_directory_uri(); ?>/images/image1.jpg" alt="Infographic Step 1">
      <img id="image2" class="infographic-image hidden" src="<?php echo get_template_directory_uri(); ?>/images/image2.jpg" alt="Infographic Step 2">
      <img id="image3" class="infographic-image hidden" src="<?php echo get_template_directory_uri(); ?>/images/image3.jpg" alt="Infographic Step 3">
      <img id="image4" class="infographic-image hidden" src="<?php echo get_template_directory_uri(); ?>/images/image4.jpg" alt="Infographic Step 4">
      <img id="image5" class="infographic-image hidden" src="<?php echo get_template_directory_uri(); ?>/images/image5.jpg" alt="Infographic Step 5">

      <button class="arrow-area" onclick="showNextImage()">Next</button>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode('interactive_infographic', 'interactive_infographic_shortcode');

function enqueue_infographic_scripts() {
  // Enqueue CSS
  wp_enqueue_style('infographic-css', get_template_directory_uri() . '/inc//css/infographic.css');

  // Enqueue JavaScript
  wp_enqueue_script('infographic-js', get_template_directory_uri() . '/inc/js/infographic.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_infographic_scripts');


/*************************************************************************************** GeorgeWebDevCY End***************************************************************** */