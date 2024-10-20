<?php
function ajax_search_profiles() {
    // Verify the nonce for security
    check_ajax_referer('ajax_search_nonce', 'security');

    $keyword = sanitize_text_field($_POST['keyword']);
    $account_type = isset($_POST['account_type']) ? json_decode(stripslashes($_POST['account_type'])) : array();
    $individual_type = isset($_POST['individual_type']) ? json_decode(stripslashes($_POST['individual_type'])) : array();
    $countries = isset($_POST['countries']) ? json_decode(stripslashes($_POST['countries'])) : array();
    $languages = isset($_POST['languages']) ? json_decode(stripslashes($_POST['languages'])) : array();
    $collaborating = isset($_POST['collaborating']) ? json_decode(stripslashes($_POST['collaborating'])) : array();
    $research = isset($_POST['research']) ? json_decode(stripslashes($_POST['research'])) : array();

    
    $args = array(
        'post_type' => 'profiles',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
        ),
    );
    
    if (!empty($keyword)) {
        $meta_query_keyword = array(
            'relation' => 'OR',
        );
    
        // Loop through repeater fields for profile_type_role and profile_type_org
        $max_repeater_fields = 12; // Assuming you have up to 12 repeater rows
        for ($i = 0; $i < $max_repeater_fields; $i++) {
            $meta_query_keyword[] = array(
                'key' => "profile_types_repeater_{$i}_profile_type_role",
                'value' => $keyword,
                'compare' => 'LIKE',
            );
            $meta_query_keyword[] = array(
                'key' => "profile_types_repeater_{$i}_profile_type_org",
                'value' => $keyword,
                'compare' => 'LIKE',
            );
        }

        $related_users = new WP_User_Query(array(
            'search'         => '*' . esc_attr($keyword) . '*',
            'search_columns' => array(
                'first_name',
                'last_name',
            ),
        ));
    
        if (!empty($related_users->get_results())) {
            foreach ($related_users->get_results() as $user) {
                $meta_query_keyword[] = array(
                    'key' => 'profile_related_user',
                    'value' => $user->ID,
                    'compare' => '=',
                );
            }
        }
    
        $args['meta_query'][] = $meta_query_keyword;
    }

  


    // Account type filtering
    if ($account_type) {
        $max_repeater_fields = 12; // Set the maximum number of repeater rows to 6
        $meta_query_account_type = array(
            'relation' => 'OR'
        );
    
        foreach ($account_type as $type) {
            for ($i = 0; $i < $max_repeater_fields; $i++) {
                $meta_query_account_type[] = array(
                    'key' => 'profile_types_repeater_' . $i . '_profile_type',
                    'value' => $type,
                    'compare' => 'LIKE'
                );
            }
        }
    
        $args['meta_query'][] = $meta_query_account_type;
    }


    // Individual type filtering
    if ($individual_type) {
        $max_repeater_fields = 12; // Set the maximum number of repeater rows to 6
        $meta_query_indv_type = array(
            'relation' => 'OR'
        );
    
        foreach ($individual_type as $type) {
            for ($i = 0; $i < $max_repeater_fields; $i++) {
                $meta_query_indv_type[] = array(
                    'key' => 'profile_types_repeater_' . $i . '_profile_type_role',
                    'value' => $type,
                    'compare' => 'LIKE'
                );
            }
        }
    
        $args['meta_query'][] = $meta_query_indv_type;
    }

    // Country filtering
    if (!empty($countries)) {
        $args['meta_query'][] = array(
            'key' => 'profile_country',
            'value' => $countries,
            'compare' => 'IN'
        );
    }

    // Language filtering
    if (!empty($languages)) {
        $args['meta_query'][] = array(
            'key' => 'profile_language',
            'value' => $languages,
            'compare' => 'IN'
        );
    }

    // Research Offering filtering
    if (!empty($collaborating)) {
        $max_repeater_fields = count(get_posts(array(
            'post_type' => 'collaboration_topics',
            'numberposts' => -1,
        )));

        $meta_query_collaborating = array('relation' => 'OR');

        foreach ($collaborating as $post_id) {
            for ($i = 0; $i < $max_repeater_fields; $i++) {
                $meta_query_collaborating[] = array(
                    'key' => "profile_collab_on_{$i}_collab_on_post_id",
                    'value' => $post_id,
                    'compare' => 'LIKE',
                );
            }
        }

        $args['meta_query'][] = $meta_query_collaborating;
    }

    if (!empty($research)) {
        $max_repeater_fields = 25;

        $meta_query_research = array('relation' => 'OR');

        foreach ($research as $post_id) {
            for ($i = 0; $i < $max_repeater_fields; $i++) {
                $meta_query_research[] = array(
                    'key' => "profile_research_{$i}_profile_research_id",
                    'value' => $post_id,
                    'compare' => 'LIKE',
                );
            }
        }

        $args['meta_query'][] = $meta_query_research;
    }

   error_log('Query Args: ' . print_r($args, true));
    //$query = new WP_Query($args);

   //error_log($query->request);


//    $args = array(
//     'post_type' => 'profiles',
//     'posts_per_page' => -1,
//     'meta_query' => array(
//         array(
//             'key' => 'profile_types_repeater_0_profile_type_role',
//             'value' => 'TEST',
//             'compare' => 'LIKE',
//         ),
//     ),
// );


$query = new WP_Query($args);


    if ($query->have_posts()) {
        $results = array();
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            get_template_part('template-parts/user-result');
            $profile_html = ob_get_clean();
            $results[] = $profile_html;
        }
        wp_send_json_success($results);
    } else {
        wp_send_json_error('No profiles found.');
    }

    wp_die();
}
add_action('wp_ajax_nopriv_search_profiles', 'ajax_search_profiles');
add_action('wp_ajax_search_profiles', 'ajax_search_profiles');

//ajax on reseach interests
add_action('wp_ajax_nopriv_ajax_search_research_interests', 'ajax_search_research_interests');
add_action('wp_ajax_ajax_search_research_interests', 'ajax_search_research_interests');

function ajax_search_research_interests() {
    check_ajax_referer('ajax_search_nonce', 'security_nonce_research');

    $search_query = sanitize_text_field($_GET['q']);
    $args = array(
        'post_type' => 'research_interests',
        'posts_per_page' => 50,
        's' => $search_query,
        'orderby' => 'title',
        'order' => 'ASC',
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = array(
                'id' => get_the_ID(),
                'text' => get_the_title(),
            );
        }
    }

    wp_reset_postdata();
    wp_send_json($results);
    wp_die();
}