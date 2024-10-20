<?php 

if (!is_user_logged_in()) : 
    wp_redirect(home_url().'?login');
    exit;
endif;

get_header();

?>




<div class="container-fluid wrapper">
    <div class="container px-2 py-5">
        <div class="row mb-5 p-5 bg-primary" id="filters">
            <h1 class="text-secondary col-12 mb-3">Search Profiles</h2>
            <div class="col-lg-6 mt-2 mt-lg-0">
                <div class="text-white py-2 label">Search: Name, Role or Organisation</div>   
                <input id="keyword" type="text" class="form-control" placeholder="Search by Name, Role or Organisation" />
            </div>
            <div class="col-lg-3 mt-2 mt-lg-0">
                <div class="account-type">
                    <div class="text-primary text-white py-2 label">Account Type</div>   
                    <?php get_template_part('/inc/functions/account-types'); global $account_types; ?>

                    <select id="account_type" name="account_type" class="form-select" multiple="multiple">
                        <?php foreach ($account_types as $type): ?>
                            <option value="<?php echo esc_attr($type); ?>"><?php echo esc_html($type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-3 mt-2 mt-lg-0">
                <div class="indv-type">
                    <div class="text-primary text-white py-2 label">Individual Type</div>   
                    <?php get_template_part('/inc/functions/individual-options'); global $indv_options; ?>

                    <select id="individual_type" name="individual_type" disabled class="form-select" multiple="multiple">
                        <?php foreach ($indv_options as $type): ?>
                            <option value="<?php echo esc_attr($type); ?>"><?php echo esc_html($type); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>


            <div class="col-lg-3 mt-2 mt-lg-0">
                <div class="country pt-2">
                    <div class="text-primary text-white py-2 label">Countries</div>   
                    <?php get_template_part('/inc/functions/profile-countries'); global $countries; ?>

                    <select id="countries" name="countries" class="form-select mt-2" multiple="multiple">
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo esc_attr($country); ?>"><?php echo esc_html($country); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 mt-2 mt-lg-0">
                <div class="language pt-2">
                    <div class="text-primary text-white py-2 label">Languages</div>   
                    <?php get_template_part('/inc/functions/profile-languages'); global $languages; ?>

                    <select id="languages" name="languages" class="form-select" multiple="multiple">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo esc_attr($language); ?>"><?php echo esc_html($language); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mt-2 mt-lg-0">
                    <h4 class="text-secondary col-12 pt-4">Collaborating on...</h4>
                    <?php 
                    $args = array(
                        'post_type' => 'collaboration_topics',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    );
                    $query = new WP_Query( $args ); 
                    ?>
                    <select id="collaborating" name="collaborating" class="form-select" multiple="multiple">
                        <?php 
                        if ( $query->have_posts() ) :
                            while ( $query->have_posts() ) : $query->the_post(); ?>
                                <option value="<?php echo the_ID(); ?>"><?php echo the_title();?></option>
                            <?php endwhile;
                            wp_reset_postdata();
                        endif; ?>
                    </select>
                </div>

                <div class="col-lg-6 mt-2 mt-lg-0">
                    <h4 class="text-secondary col-12 pt-4">Research Interests...</h4>
                    <input type="hidden" id="security_nonce_research" value="<?php echo wp_create_nonce('ajax_search_research_nonce'); ?>">
                    <input type="hidden" id="ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>">

                    <select id="research_interests" name="research_interests" class="form-select" multiple="multiple">
                        <!-- Options will be loaded dynamically via AJAX -->
                    </select>
                </div>

            </div>
            
            
            <div class="col-lg-4 mt-2 mt-lg-0">
                <div class="form-check form-switch d-flex align-items-center ">
                    <!-- <input class="form-check-input" name="professional" type="checkbox" id="professional">
                    <label class="form-check-label text-white" for="professional">Only show professional accounts</label> -->
                </div>
            </div>
        </div>

        <div class="col-lg-12 text-primary text-end" id="results_counter">
        </div>

        <div class="row">
            <div id="search-results" class="row mt-5">
                <!-- Results will be appended here -->
            </div>
        </div>
        
        
    </div>
</div>

<?php

get_footer();
?>