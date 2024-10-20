<?php

add_action( 'wp_ajax_user_reg', 'user_reg' );
add_action( 'wp_ajax_nopriv_user_reg', 'user_reg' ); 

function user_reg() {

    // Ensure session is started
    if (!session_id()) {
        session_start();
    }

    // Check nonce for security
    if ( ! isset($_POST['security_nonce']) || ! wp_verify_nonce( $_POST['security_nonce'], 'user_reg' ) ) {
        wp_send_json_error( 'N1 verification failed.' );
    }

    $firstname = sanitize_text_field($_POST['firstname']);
    $lastname = sanitize_text_field($_POST['lastname']);
    $telephone = sanitize_text_field($_POST['telephone']);
    $email = sanitize_email($_POST['email']);
    $username = sanitize_text_field($_POST['username']);
    $password = $_POST['password']; // Password should be sanitized carefully

    // Check for required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        wp_send_json_error('Please make sure you have entered both a first and last name, email address and a secure password');
    }
    // Check if email is valid
    if (!is_email($email)) {
        wp_send_json_error('Invalid email address.');
    }

    // Check if email already exists
    if (email_exists($email)) {
        wp_send_json_error('This email address is already in use.');
    }

    // Check if username already exists
    if (username_exists($username)) {
        wp_send_json_error('This username is already in use.');
    }

    // Register the user
    $user_id = wp_create_user($username, $password, $email);

    // Check for errors during user creation
    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id->get_error_message());
    } else {
        //Create session 
        $_SESSION['new_user_id'] = $user_id;
    }

    // Update user meta data
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $firstname,
        'last_name' => $lastname,
    ));

    $user = new WP_User($user_id);
    $user->set_role('unapproved');

    update_field('user_telephone', $telephone, 'user_' . $user_id);

    //Send ADMIN email
    if ( get_field('email_address','option') ) : 
        $email_to = get_field('email_address','option'); 
    else :
        $email_to = 'lewis@redwebcambridge.com';
    endif;

    $admin_url = get_admin_user_edit_link($user_id);

    set_query_var( 'to_email', $email_to );
    set_query_var( 'email', $email );
    set_query_var( 'username', $username );
    set_query_var( 'admin_url',  $admin_url );

    get_template_part('inc/emails/admin_newuser');

    //Send email verification
    if (!send_email_verification($user_id)) {
        error_log('Failed to send verification email for user ID: ' . $user_id);
    }

    //CREATE DRAFT PROFILE 
    //Must get and post as admin
    $admin_user_id = 1;
    $admin_user = get_user_by('id', $admin_user_id);

    if ($admin_user) {
        // Switch to admin user
        wp_set_current_user($admin_user_id);
    
        //Create draft profile
        $post_data = array(
            'post_title'    => $firstname . ' ' . $lastname,
            'post_status'   => 'draft',
            'post_type'     => 'profiles',
        );
    
        // Insert the post
        $post_id = wp_insert_post($post_data);
        if (is_wp_error($post_id)) {
            error_log('Failed to create post: ' . $post_id->get_error_message());
            wp_send_json_error('Unable create your profile');
            wp_die();
        } else {

            //Set user of the profile
            update_field('profile_related_user', $user_id, $post_id);

            //profile types
            $profile_types = json_decode(stripslashes($_POST['profile_types']), true);
            $repeater_value = array();
            foreach ($profile_types as $type) {
                $repeater_value[] = array(
                    'profile_type' => $type['key'],
                    'profile_type_role' => $type['value']['role'], 
                    'profile_type_org' => $type['value']['org'],   
                );
            }
            // Update the ACF repeater field
            update_field('profile_types_repeater', $repeater_value, $post_id);

        }

        // Switch back to no user
        wp_set_current_user(0);
        wp_send_json_success('Account and Profile (draft) created!');
    } else {
        wp_send_json_error('Admin user not found');
        wp_die();
    }

    wp_die();
}
//ROLES
function add_rdrn_user_roles() {
    $subscriber = get_role('subscriber');
    $subscriber_capabilities = $subscriber->capabilities;

    add_role('rdrn_user', 'RDRN User', $subscriber_capabilities);
    $rdrn_user = get_role('rdrn_user');

    $rdrn_user->add_cap('read');
    $rdrn_user->add_cap('upload_files');

    $rdrn_user->remove_cap('edit_posts');
    $rdrn_user->remove_cap('edit_published_posts');
    $rdrn_user->remove_cap('edit_others_posts');
    $rdrn_user->remove_cap('publish_posts');
    $rdrn_user->remove_cap('delete_posts');

    $rdrn_user->add_cap('edit_profiles');
    $rdrn_user->add_cap('edit_published_profiles');
    $rdrn_user->add_cap('edit_own_profiles');
    $rdrn_user->add_cap('edit_own_published_profiles');
    $rdrn_user->add_cap('edit_private_profiles');
    $rdrn_user->add_cap('edit_own_private_profiles');
    $rdrn_user->add_cap('edit_draft_profiles');
    $rdrn_user->add_cap('edit_own_draft_profiles');
    $rdrn_user->add_cap('edit_pending_profiles');
    $rdrn_user->add_cap('edit_own_pending_profiles');
    $rdrn_user->add_cap('preview_own_profiles');
    $rdrn_user->add_cap('preview_profiles');
    $rdrn_user->add_cap('read_private_profiles');

    add_role('unapproved', 'Unapproved', array());
}
add_action('init', 'add_rdrn_user_roles');

function allow_read_own_pending_profiles($query) {
    if (!is_admin() && $query->is_main_query() && is_singular('profiles')) {
        if (is_user_logged_in() && current_user_can('rdrn_user')) {
            global $post;
            if ($post->post_status == 'pending' && $post->post_author == get_current_user_id()) {
                $query->set('post_status', array('publish', 'pending', 'draft', 'private'));
            }
        }
    }
}
add_action('pre_get_posts', 'allow_read_own_pending_profiles');

function allow_read_own_pending_profiles_meta_cap($caps, $cap, $user_id, $args) {
    if ($cap === 'read_post') {
        $post = get_post($args[0]);
        if ($post->post_type === 'profiles' && $post->post_status === 'pending') {
            if ($post->post_author == $user_id) {
                $caps = array('read');
            } else {
                $caps = array('do_not_allow');
            }
        }
    }
    return $caps;
}
add_filter('map_meta_cap', 'allow_read_own_pending_profiles_meta_cap', 10, 4);

add_action('init', function() {
    flush_rewrite_rules();
});

// Restrict rdrn_user to only edit their own profiles posts
function restrict_rdrn_user_editing($query) {
    if (is_admin()) {
        return;
    }

    $user = wp_get_current_user();
    if (in_array('rdrn_user', (array)$user->roles)) {
        global $pagenow;
        if ('edit.php' === $pagenow && isset($_GET['post_type']) && $_GET['post_type'] === 'profiles') {
            $query->set('author', $user->ID);
        } elseif ('edit.php' === $pagenow) {
            $query->set('post_type', 'profiles');
            $query->set('author', $user->ID);
        }
    }
}
add_action('pre_get_posts', 'restrict_rdrn_user_editing');

// Restrict the user from editing other posts directly
function allow_edit_own_profiles($caps, $cap, $user_id, $args) {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        return $caps;
    }

    $user = get_userdata($user_id);

    // Only apply this restriction to users with the 'rdrn_user' role
    if (in_array('rdrn_user', (array)$user->roles)) {
        if (in_array($cap, array('edit_post', 'delete_post', 'read_post'))) {
            $post = get_post($args[0]);
            if ('profiles' === $post->post_type) {
                if ($user_id === $post->post_author) {
                    $caps = array('edit_profiles');
                } else {
                    $caps = array('do_not_allow');
                }
            } else {
                $caps = array('do_not_allow');
            }
        }
    }

    return $caps;
}
add_filter('map_meta_cap', 'allow_edit_own_profiles', 10, 4);

//redirect users away from wp-admin
function redirect_non_admin_users() {
    // Check if the user is logged in
    if (is_user_logged_in()) {
        $user = wp_get_current_user();

        // Check if the user has the role 'rdrn_user' or 'unapproved'
        if (in_array('rdrn_user', (array)$user->roles) || in_array('unapproved', (array)$user->roles)) {
            // Check if the user is trying to access wp-admin
            if (is_admin() && !defined('DOING_AJAX')) {
                wp_redirect(home_url());
                exit;
            }
        }
    }
}
add_action('admin_init', 'redirect_non_admin_users');

//Get link to user on wp-admin
function get_admin_user_edit_link($user_id) {
    return admin_url('user-edit.php?user_id=' . $user_id);
}

//User approval button
function add_approve_button($user) {
    if (in_array('unapproved', $user->roles)) {
        ?>
        <table class="form-table">
            <tr>
                <th><label for="approve_user">Approve User</label></th>
                <td>
                    <button id="approve_user_button" class="button button-primary">Approve User</button>
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                var approveButton = document.getElementById('approve_user_button');
                approveButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to approve this user?')) {
                        var data = new FormData();
                        data.append('action', 'approve_user');
                        data.append('user_id', '<?php echo $user->ID; ?>');
                        data.append('security', '<?php echo wp_create_nonce('approve_user_nonce'); ?>');

                        fetch(ajaxurl, {
                            method: 'POST',
                            body: data
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                alert('User approved successfully.');
                                location.reload();
                            } else {
                                alert('Error: ' + response.data);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred.');
                        });
                    }
                });
            });
        </script>
        <?php
    }
}
add_action('show_user_profile', 'add_approve_button');
add_action('edit_user_profile', 'add_approve_button');

//Handle approve user
function handle_approve_user() {
    // Check the nonce for security
    check_ajax_referer('approve_user_nonce', 'security');

    // Check if the current user can edit users
    if (!current_user_can('edit_users')) {
        wp_send_json_error('You do not have permission to approve users.');
    }

    // Get the user ID from the AJAX request
    $user_id = intval($_POST['user_id']);
    if (!$user_id) {
        wp_send_json_error('Invalid user ID.');
    }

    // Get the user data
    $user = get_userdata($user_id);
    if (!$user) {
        wp_send_json_error('User not found.');
    }

    // Change the user role from 'unapproved' to 'rdrn_user'
    if (in_array('unapproved', $user->roles)) {
        $user->set_role('rdrn_user');
        set_query_var( 'email', $user->user_email );
        set_query_var( 'link', home_url()  );
        get_template_part('inc/emails/user_account_approved');
        wp_send_json_success('User approved successfully.');
    } else {
        wp_send_json_error('User is not unapproved.');
    }
}
add_action('wp_ajax_approve_user', 'handle_approve_user');

//Email verification
function send_email_verification($user_id) {
    $user = get_userdata($user_id);
    $email = $user->user_email;
    $verification_key = wp_generate_password(20, false);
    update_user_meta($user_id, 'email_verification_key', $verification_key);

    $verification_link = add_query_arg(array(
        'user_id' => $user_id,
        'verification_key' => $verification_key
    ), home_url('/verify-email'));

    //Send email
    set_query_var( 'verification_link', $verification_link );
    set_query_var( 'email', $email );
    get_template_part('inc/emails/user_email_verification');
    return true;
}

// Handle email verification
function email_verification_handler() {
    if (isset($_GET['user_id']) && isset($_GET['verification_key'])) {
        $user_id = intval($_GET['user_id']);
        $verification_key = sanitize_text_field($_GET['verification_key']);

        $saved_key = get_user_meta($user_id, 'email_verification_key', true);
        if ($verification_key === $saved_key) {
            // Mark email as verified
            update_field('email_verified', true, 'user_' . $user_id);
            delete_user_meta($user_id, 'email_verification_key');
            return true;
        } else {
            return false;
        }
    }
    return null; // Return null if parameters are not set
}

//show a link on profiles admin to user
function render_related_user_link( $field ) {
    // Ensure this is the correct field
    if ( 'acf[profile_related_user]' !== $field['name'] ) {
        return;
    }

    // Get the user ID from the field value
    $user_id = $field['value'];

    // Ensure the user ID is valid and only render the link once
    if ( $user_id && ! did_action( 'rendered_related_user_link' ) ) {
        $edit_user_link = get_edit_user_link( $user_id );
        echo '<p><a href="' . esc_url( $edit_user_link ) . '" target="_blank">Edit User</a></p>';
        do_action( 'rendered_related_user_link' );
    }
}
add_action('acf/render_field', 'render_related_user_link', 10, 1);

//display profile image preview
function render_user_profile_image_admin( $field ) {
    // Ensure this is the correct field
    if ( 'acf[profile_image]' !== $field['name'] ) {
        return;
    }

    // Get the user ID from the field value
    $profile_image_url = $field['value'];
    // Ensure the user ID is valid and only render the link once
    if ( ! did_action( 'render_user_profile_image_admin' ) ) {
        $profile_image_url = $field['value'];
        echo '<a href="'.$profile_image_url.'" target="_blank"><img src="'.$profile_image_url.'" style="width:50%; margin-top:19px" /></a>';
    }
}
add_action('acf/render_field', 'render_user_profile_image_admin', 10, 1);


add_action( 'wp_ajax_signup_profile', 'signup_profile' );
add_action( 'wp_ajax_nopriv_signup_profile', 'signup_profile' ); 

//Main profile sign up
function signup_profile() {
    if (!session_id()) {
        session_start();
    }

    // Check nonce for security
    if ( ! isset($_POST['security_nonce']) || ! wp_verify_nonce( $_POST['security_nonce'], 'user_reg' ) ) {
        wp_send_json_error( 'N1 verification failed.' );
    }

    if (isset($_SESSION['new_user_id'])) {
        $user_id = $_SESSION['new_user_id'];
        $user = get_user_by('id', $user_id);

        if ($user) {
            // Get the email passed via AJAX
            $email = sanitize_email($_POST['email']);

            // Check if the email matches
            if ($user->user_email === $email) {

                //Find profile
                $args = array(
                    'post_type' => 'profiles',
                    'meta_query' => array(
                        array(
                            'key' => 'profile_related_user',
                            'value' => $user_id,
                            'compare' => '='
                        )
                    ),
                    'posts_per_page' => 1,
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    $query->the_post();
                    $profile_post_id = get_the_ID();

                    $admin_user_id = 1;
                    $admin_user = get_user_by('id', $admin_user_id);
                
                    if ($admin_user) {
                        // Switch to admin user
                        wp_set_current_user($admin_user_id);

                        // Website links
                        if (isset($_POST['profile_links'])) {
                            $profile_links = json_decode(stripslashes($_POST['profile_links']), true);
                            $repeater_value = array();
                            foreach ($profile_links as $type) {
                                $link_name = sanitize_text_field($type['key']);
                                $link_url = esc_url_raw($type['value']);
                                $repeater_value[] = array(
                                    'profile_link_title' => $link_name,
                                    'profile_link_url' => $link_url,
                                );
                            }
                            update_field('profile_website_links', $repeater_value, $profile_post_id);
                        }

                        //Collaborate on
                        if (isset($_POST['collab_on'])) {
                            $collab_on = json_decode(stripslashes($_POST['collab_on']), true);
                            $repeater_value = array();
                            foreach ($collab_on as $post_id) {
                                $repeater_value[] = array(
                                    'collab_on_post_id' => intval($post_id)
                                );
                            }
                            update_field('profile_collab_on', $repeater_value, $profile_post_id);
                        }

                        //Research interests
                        if (isset($_POST['research_interests'])) {
                            $research_interests = json_decode(stripslashes($_POST['research_interests']), true);
                            $repeater_value = array();
                            foreach ($research_interests as $post_id) {
                                $repeater_value[] = array(
                                    'profile_research_id' => intval($post_id)
                                );
                            }
                            update_field('profile_research', $repeater_value, $profile_post_id);
                        }
                        

                        //country and language
                        if (isset($_POST['country'])) {
                            update_field('profile_country', sanitize_text_field($_POST['country']), $profile_post_id);
                        }
                        if (isset($_POST['language'])) {
                            update_field('profile_language', sanitize_text_field($_POST['language']), $profile_post_id);
                        }

                        //newsletter
                        // Newsletter
                        if (isset($_POST['newsletter'])) {
                            $newsletter_value = filter_var($_POST['newsletter'], FILTER_VALIDATE_BOOLEAN);
                            update_field('profile_newsletter', $newsletter_value, $profile_post_id);
                        }

                        //mentoring
                        if (isset($_POST['mentoring'])) {
                            $mentoring_value = filter_var($_POST['mentoring'], FILTER_VALIDATE_BOOLEAN);
                            update_field('profile_mentoring', $mentoring_value, $profile_post_id);
                        }

                        // Summary
                        if (isset($_POST['summary'])) {
                            update_field('profile_summary', sanitize_textarea_field($_POST['summary']), $profile_post_id);
                        }

                        // About
                        if (isset($_POST['about'])) {
                            update_field('profile_about', sanitize_textarea_field($_POST['about']), $profile_post_id);
                        }

                        //profile picture
                        if (isset($_FILES['profile_picture']) && !empty($_FILES['profile_picture']['name'])) {
                            $thumbnail_url = cloudflare_upload($_FILES['profile_picture']);
                            if ($thumbnail_url) {
                                update_field('profile_image', $thumbnail_url, $profile_post_id);
                            } else {
                                wp_send_json_error('Failed to upload profile picture.');
                            }

                        }

                        //save to pending review
                        $post_data = array(
                            'ID'           => $profile_post_id,
                            'post_status'  => 'pending',
                            'post_author'  => $user_id
                        );
                        
                        // Update the post into the database
                        wp_update_post($post_data);

                        // Switch back to no user
                        wp_set_current_user(0);
                        
                        //Email admin that a profile needs to be approved
                        //NEEDS TO BE DONE

                        wp_send_json_success('Profile updated successfully.');


                    } else {
                        wp_send_json_error('Admin user not found');
                        wp_die();
                    }

                } else {
                    wp_send_json_error('No profile post found for this user.');
                }
                

                //get post with post type profile where 

            } else {
                wp_send_json_error('Email does not match the user the session belongs to.');
            }
        } else {
            wp_send_json_error('User does not exist.');
        }


        


    } else {
        wp_send_json_error('Session value for new_user_id not set.');
    }

}

//Ajax Login
function ajax_login() {

    // First check the nonce, if it fails the function will break
    if (!isset($_POST['security_nonce']) || !wp_verify_nonce($_POST['security_nonce'], 'ajax_login')) {
        wp_send_json_error('Please check that your account has been approved and that you have verified your email address before logging in.');
        wp_logout();
        wp_die();
    } 

    // Verify reCAPTCHA
    $recaptcha_secret = '6Lc3EvgpAAAAAMrzF-RFulTstF7a_1OVhRHnOnJR';
    $recaptcha_response = sanitize_text_field($_POST['g-recaptcha-response']);
    $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
    $response_body = wp_remote_retrieve_body($response);
    $result = json_decode($response_body);

    if (!$result->success) {
        wp_send_json_error('reCAPTCHA verification failed.');
        wp_die();
    } 
    
    // Check if the user is already logged in
    if (is_user_logged_in()) {
        $logout_url = wp_logout_url();
        $error_message = 'You are already logged in. <a href="' . $logout_url . '">Logout</a>.';
        wp_send_json_error($error_message);
        wp_die();
    } else {
        error_log('user not already logged in');

    }

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = sanitize_text_field($_POST['username']);
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon($info, false);

    // Check email verification status
    if (!is_wp_error($user_signon)) {

        if (!user_can($user_signon, 'administrator')) {
            check_unapproved_role($user_signon);

            $user_id = $user_signon->ID;
            $email_verified = get_field('email_verified', 'user_' . $user_id);
    
            if (!$email_verified) {
                wp_send_json_error('Your email address has not been verified. Please check your inbox for the verification email.<form method="post" id="resendverification_form" enctype="multipart/form-data"><div id="resendverification" class="text-decoration-underline text-primary">Resend Email Verification</div><input type="hidden" name="user_ID" value="'.$user_id.'"></form>');
                wp_die();
            } 
        }

        

        //record time of login
        $current_time = current_time('Y-m-d H:i:s');
        update_field('user_last_login', $current_time, 'user_' . $user_id);

        wp_send_json_success('Login successful');
    } else {
        wp_send_json_error($user_signon->get_error_message());
    }

    wp_die();
}
add_action('wp_ajax_nopriv_ajax_login', 'ajax_login');
add_action('wp_ajax_ajax_login', 'ajax_login');

function resend_verification() {
    $user_id = sanitize_text_field($_POST['user_ID']);
    
    if (send_email_verification($user_id)) {
        wp_send_json_success('Verification email has been resent successfully.');
    } else {
        wp_send_json_error('Failed to resend the verification email.');
    }

    wp_die();

}
add_action('wp_ajax_nopriv_resend_verification', 'resend_verification');
add_action('wp_ajax_resend_verification', 'resend_verification');

//Check user account approval
function check_unapproved_role($user) {
    if (in_array('unapproved', $user->roles)) {
        wp_send_json_error('Your account is not approved yet. Please wait for admin approval.');
        wp_logout();
        wp_die();
    }
}

//return to home after log out
function redirect_to_homepage_after_logout() {
    wp_redirect(home_url());
    exit();
}
add_action('wp_logout', 'redirect_to_homepage_after_logout');





//Cloudfalre Upload
function cloudflare_upload($uploaded_file) {

    if (!isset($uploaded_file) || empty($uploaded_file['name'])) {
        return false;
    }

    // Prepare the API request to Cloudflare Images
    $cloudflare_account_id = 'ef3b72afe3378216c04cf177bd7ddbd9';
    $cloudflare_api_token = 'Yuet6WLmVJo2qPuR89cShdK7bh070MnlymDsZdTU';
    $cloudflare_image_url = 'https://api.cloudflare.com/client/v4/accounts/' . $cloudflare_account_id . '/images/v1';

    $headers = array(
        'Authorization: Bearer ' . $cloudflare_api_token,
        'Content-Type: multipart/form-data'
    );

    $file_path = $uploaded_file['tmp_name'];
    $file_name = $uploaded_file['name'];

    $data = array(
        'file' => curl_file_create($file_path, $uploaded_file['type'], $file_name),
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $cloudflare_image_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $response_data = json_decode($response, true);
    curl_close($ch);

    if ($response_data && isset($response_data['success']) && $response_data['success'] == true) {
        // Find the thumbnail variant URL
        foreach ($response_data['result']['variants'] as $variant) {
            if (strpos($variant, 'thumbnail') !== false) {
                return $variant;
            }
        }
        return $response_data['result']['variants'][0]; // Return first variant if thumbnail is not found
    } else {
        return false;
    }
}

add_action('wp_ajax_nopriv_handle_upload', 'handle_upload');
add_action('wp_ajax_handle_upload', 'handle_upload');


//Redirect non admins away from wp-admin
// function restrict_admin_area() {
//     // Allow access to admin for administrators and AJAX requests
//     if (!current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
//         // Check if the current URL contains '/wp-admin'
//         if (strpos($_SERVER['REQUEST_URI'], '/wp-admin') !== false) {
//             wp_redirect(home_url());
//             exit;
//         }
//     }
// }
// add_action('admin_init', 'restrict_admin_area');

// function restrict_wp_login() {
//     // Check if the user is trying to access the login page and is not an administrator
//     if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false && !current_user_can('administrator')) {
//         // Allow logout action to proceed
//         if (!isset($_GET['action']) || $_GET['action'] !== 'logout') {
//             wp_redirect(home_url());
//             exit;
//         }
//     }
// }
// add_action('init', 'restrict_wp_login');


function ajax_search_research() {
    // Verify the nonce for security
    check_ajax_referer('ajax_search_nonce', 'security_nonce_research');

    // Get the search keyword from the AJAX request
    $keyword = sanitize_text_field($_POST['keyword']);
    $exclude_ids = isset($_POST['exclude_ids']) ? json_decode(stripslashes($_POST['exclude_ids'])) : array();
    // Prepare the query arguments
    $args = array(
        'post_type' => 'research_interests', // Adjust to your custom post type
        'posts_per_page' => 10, // Limit the number of results
        's' => $keyword,
        'post_status' => 'publish',
        'post__not_in' => $exclude_ids, // Exclude already selected IDs
    );

    // Execute the query
    $query = new WP_Query($args);

    // Initialize an array to store the results
    $results = array();

    // Check if there are any posts that match the query
    if ($query->have_posts()) {
        $results = array();
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'tooltip' => get_field('research_tooltip'), 
            );
        }
        wp_send_json_success($results);
    } else {
        wp_send_json_error('No results found.');
    }

    wp_die();
}
add_action('wp_ajax_nopriv_ajax_search_research', 'ajax_search_research');
add_action('wp_ajax_ajax_search_research', 'ajax_search_research');