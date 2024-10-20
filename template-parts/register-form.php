<form action="#register" method="post" enctype="multipart/form-data" id="registration_form">

<input type="hidden" id="security_nonce" value="<?php echo wp_create_nonce('user_reg'); ?>">
<input type="hidden" id="ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>">

    <!-- Step 1 - User type -->
    <div class="step active" data-step-number="1">

        <div class="row">
            <div class="col-10 col-xl-12">
                <h2 class="question ps-1">I am a ...</h2>
                <small class="ps-1">Select all that apply</small>
            </div>
            <div class="col-2 d-xl-none pt-2">
                <i class="h1 text-primary bi bi-info-circle-fill" id="toggle_help"></i>
            </div>
        </div>

        <?php get_template_part('/inc/functions/account-types'); global $account_types; ?>
        <?php get_template_part('/inc/functions/individual-options'); global $indv_options; ?>

            <?php foreach ($account_types as $type): ?>
                <input type="checkbox" class="btn-check account_type_button" id="type-<?php echo str_replace(' ', '_', strtolower($type)); ?>" name="<?php echo $type; ?>" autocomplete="off">
                <label class="mt-2 btn w-100 text-start" for="type-<?php echo str_replace(' ', '_', strtolower($type)); ?>"><?php echo $type; ?></label>

                <?php if ($type === 'Individual') : ?>
                    <div id="type-individual-option" class="mt-2 d-none p-2">
                        <div class="w-100 p-2 text-primary">Please select all options that best describe you.</div>
                        <?php foreach ($indv_options as $indv_type): ?>
                                <input type="checkbox" class="btn-check" id="indv_<?php echo $indv_type; ?>" autocomplete="off" value="<?php echo $indv_type; ?>">
                                <label class="mb-3 btn text-start" for="indv_<?php echo $indv_type; ?>"><?php echo $indv_type; ?></label>                       
                        <?php endforeach; ?>
                    </div>
                <?php else :?>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control my-2 d-none role_type_field" name="type-<?php echo str_replace(' ', '_', strtolower($type)) ?>-org" placeholder="Organisation name" id="type-<?php echo str_replace(' ', '_', strtolower($type)); ?>-org" />
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control my-2 d-none role_type_field" name="type-<?php echo str_replace(' ', '_', strtolower($type)) ?>-role" placeholder="Role" id="type-<?php echo str_replace(' ', '_', strtolower($type)); ?>-role" />
                        </div>
                    </div>
                    
                <?php endif; ?>
            <?php endforeach; ?>
        
    </div>

    <!-- Step 2 -->
    <div class="step" data-step-number="2">
        <h2 class="question">Consent & Expectations</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <input type="checkbox" class="btn-check" id="consent-agree" name="consent-agree" autocomplete="off">
        <label class="mt-2 btn w-100 text-start" for="consent-agree">I Agree</label>
    </div>


    <!-- Step 3 -->
    <div class="step" data-step-number="3">

        <h2 class="question">Account Information</h2>
        <div class="alert alert-danger d-none" id="reg_error_msg">There was an error setting up your user account. </div>
        <div class="alert alert-primary d-none" id="reg_already_done_msg">As your account has already been set up, these fields can no longer be edited. You can update them after logging in once your account is approved.</div>

        <small>This information will be used to create your account</small>

        <div class="row">
            <div class="mt-3 form-group col-lg-6">
                <label for="firstname" class="form-label">First Name</label>
                <input name="firstname" type="text" class="form-control" id="firstname" placeholder="John" required tabindex="1">
            </div>
            <div class="mt-3 form-group col-lg-6">
                <label for="lastname" class="form-label">Last Name</label>
                <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Doe" required tabindex="2">
            </div>
        </div>
        <div class="row">
            <div class="mt-3 form-group col-lg-6">
                <label for="email" class="form-label">Email Address</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="email@example.com" required autocomplete="email" tabindex="3">
            </div>
            <div class="mt-3 form-group col-lg-6">
                <label for="email-confirm" class="form-label">Confirm Email Address</label>
                <input name="email-confirm" type="email" class="form-control" id="email-confirm" placeholder="email@example.com" required tabindex="4">
            </div>
            <div class="col-12 d-none mt-1" id="email-match-error">
                <div class="alert alert-warning">Email addresses must match</div>
            </div>
        </div>
        <div class="row">
            <div class="mt-3 form-group col-lg-6">
                <label for="telephone" class="form-label">Telephone Number (Optional)</label>
                <input name="telephone" type="text" class="form-control" id="telephone" placeholder="+44 00000 000 000" autocomplete="on" tabindex="5"> 
            </div>
        </div>
        
        <h2 class="question mt-4">Login Credentials</h2>
        <div class="row mt-3">
            <div class="form-group col-lg-6">
                <label for="username" class="form-label">Username</label>
                <input name="username" type="text" class="form-control" id="username" placeholder="username" required autocomplete="off" tabindex="6">
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group col-lg-6 password">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="*******" required tabindex="7">
                <button class="btn" type="button" id="togglePassword">
                    <i class="bi bi-eye-fill" id="password-toggle-icon"></i>
                </button>
            </div>
            <div class="form-group col-lg-6 password">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input name="password-confirm" type="password" class="form-control" id="password-confirm" placeholder="*******" required tabindex="8">
                <button class="btn" type="button" id="togglePasswordConfirm">
                    <i class="bi bi-eye-fill" id="password-confirm-toggle-icon"></i>
                </button>
            </div>
            <div class="col-12 d-none mt-1" id="password-match-error">
                <div class="alert alert-warning">Passwords must match</div>
            </div>
            <div class="col-12 d-none mt-1" id="password-weak-error">
                <div class="alert alert-warning">For optimal security, use a password with at least 12 characters, including uppercase and lowercase letters, numbers, and symbols.</div>
            </div>
        </div>

    </div>

    <!-- Step 4 -->
    <div class="step d-none" data-step-number="4">
        <div class="alert alert-primary d-none" id="reg_success_msg">Your user account has been setup!</div>

        <div class="row" data-org-index="1">  
            Next steps & video - RDRN please supply content/video
        </div>


        

    </div>

     <!-- Step 5 -->
     <div class="step" data-step-number="5">
        <h2 class="question">Web Links (Optional)</h2>
        <p>Share links to your organisations, LinkedIn, Facebook groups, publications, or other affiliations</p>
        <div class="row labels">
            <div class="col-6">
                Website / Title
            </div>
            <div class="col-6">
                URL
            </div>
        </div>

        <div class="profile_link row">
            <div class="col-6">
                <input name="profile_link_name-1" type="text" class="mt-2 form-control" placeholder="ResearchGate">
            </div>
            <div class="col-6">
                <div class="d-flex align-items-center">
                    <input name="profile_link_url-1" type="text" class="mt-2 form-control" placeholder="https://www.researchgate.net/profile"><a type="button" class="ps-2 pt-2 text-red delete-link-btn d-none"><i class="bi bi-x-circle-fill"></i></a>
                </div>
            </div>
        </div>   

        <div class="d-flex justify-content-between mt-3 add-another-org align-items-center" id="profileLinksFooter">
            <div class="fst-italic max-5 ps-2">You may add up to 10 Links</div>
            <a id="addAnotherProfileLink" class="btn btn-secondary"><i class="bi bi-plus-circle"></i> Add Another Link</a>
        </div>             
    </div>

    <!-- Step 6 collab -->
    <div class="step" data-step-number="6">
        <h2 class="question">I want to collaborate on...</h2>
        <div id="collab_on" class="pt-3">
            <?php
            $args = array(
                'post_type' => 'collaboration_topics',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post(); ?>
                    <input type="checkbox" class="btn-check" id="collab_<?php echo the_ID(); ?>" autocomplete="off" value="<?php echo the_ID(); ?>">
                    <label class="mb-3 btn text-start" for="collab_<?php echo the_ID(); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo get_field('collab_tooltip_content') ?? ''; ?>"><?php echo the_title();?></label>
                <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
        
        <div class="p-1">
        <a href="mailto:<?php echo get_field('email_address','option'); ?>?subject=RDRN%20Collaboration%20Tag%20Suggestion" class="btn btn-primary">Suggest Tag</a>
        </div>

    </div>

    <!-- Step 7 -->
    <div class="step" data-step-number="7">
        <h2 class="question">My Research Ideas are....</h2>
        <div id="research-selected" class="mt-2 d-flex flex-wrap"></div>

        <input type="hidden" id="security_nonce_research" value="<?php echo wp_create_nonce('ajax_search_nonce'); ?>">
       
        <div class="mt-3 form-group col-12">
            <label for="research_ideas" class="form-label">Start typing to search and click on each tag to add (Max 25)</label>
            <input name="research_ideas" type="text" class="form-control" id="research_ideas" placeholder="Start typing to search..." required tabindex="1">
        </div>

        <div id="research-search-results" class="mt-3 d-flex flex-wrap"></div>

    </div>

    <!-- Step 8 -->
    <div class="step" data-step-number="8">

        <h2 class="question">Profile Information</h2>
        <input name="userid" id="userid" type="hidden">
       
        <div class="row mt-3">
            <div class="profile-picture-wrapper col-lg-3 d-flex flex-wrap align-items-center justify-content-center">
                <div class="profile-picture ">
                    <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" class="d-none">
                    <label for="profilePictureInput" class="text-center mb-0">
                        <img src="<?php echo get_field('default_profile','option')['url']; ?>" alt="Default Profile Picture" id="defaultProfilePic" class="img-fluid mb-2">
                        <img id="profile-img-loading-indicator" src="<?php echo get_stylesheet_directory_uri(); ?>/images/loading.svg" alt="Uploading..." class="d-none"> 

                    </label>
                </div>
                <label for="profilePictureInput" class="text-center mb-0 w-100 upload">
                    <i class="bi bi-camera-fill"></i> Upload Image
                </label>
                <div class="img-rules mt-3">
                    <span><i class="bi bi-check2-circle"></i>File Format: JPG/PNG<br/></span>
                    <span><i class="bi bi-check2-circle"></i>Max filesize: 10MB<br/></span>
                    <span><i class="bi bi-check2-circle"></i>Community Friendly - Once approved your profile image will be made public</span>
                </div>
              
            </div>
            <div class="form-group col-lg-9">
                <label for="summary" class="form-label d-flex justify-content-between align-items-center">
                    Summary headline <span class="badge text-wrap text-bg-secondary" id="word-count-summary"></span>
                </label>
                <textarea rows="4" name="summary" class="form-control" id="summary" data-word-limit="50" onkeyup="countWords(this)"></textarea>
                <label for="about" class="form-label d-flex justify-content-between align-items-center mt-2">
                    About me <span class="badge text-wrap text-bg-secondary" id="word-count-about"></span>
                </label>
                <textarea rows="9" name="about" class="form-control" id="about" data-word-limit="300" onkeyup="countWords(this)"></textarea>
            </div>
        </div>
    </div>


   <!-- Step 9 -->
    <div class="step" data-step-number="9">
        <h2 class="question mb-3">Additional Information</h2>

                
        <div class="row">

            <div class="col-xl-6">
                <div class="country-location mt-3">
                    <div class="text-primary">What country are you based in?</div>   
                    <?php get_template_part('/inc/functions/profile-countries'); global $countries; ?>

                    <select id="country" name="country" class="form-select" autocomplete="country">
                        <option disabled selected>Please select</option>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo esc_attr($country); ?>"><?php echo esc_html($country); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="pref-language mt-3">
                    <div class="text-primary">Preferred language?</div>  
                    <?php get_template_part('/inc/functions/profile-languages'); global $languages; ?>
        
                    <select id="language" name="language" class="form-select" autocomplete="country">
                        <option disabled selected>Please select</option>
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo esc_attr($language); ?>"><?php echo esc_html($language); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </div>
        

        

        <div id="share-expertise">
            <div class="text-primary mt-3">Mentoring</div>
            <div>Are you open to sharing your expertise through mentoring, answering questions from the community, or more</div>
            <div class="form-check form-switch">
                <input class="form-check-input" name="mentoring" type="checkbox" id="mentor">
                <label class="form-check-label" for="mentor">Yes/No</label>
            </div>
        </div>

        <div class="text-primary mt-3">Newsletter</div>
        <div>Stay updated with our latest news and developments by subscribing to our newsletter?</div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="newsletter" type="checkbox" id="newsletter">
            <label class="form-check-label" for="newsletter">Yes/No</label>
        </div>

       


        

    </div>

    <!-- Complete -->
    <div class="complete d-none">
        <div class="alert alert-success">
            Your profile has been setup. Please note that profile changes may be subject to admin approval. This usually takes betweeen 1 Day. You will receive an email once approved.<br>You can now <span>close</span> this window.
        </div>
    </div>

</form>

