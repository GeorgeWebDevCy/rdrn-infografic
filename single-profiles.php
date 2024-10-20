<?php get_header(); ?>

<div class="container-fluid wrapper" id="profile-single">
    
    <div class="container px-2 py-5">
        <div class="alert alert-warning">This profile is to display what information is to be displayed. Layout to be discussed during RDRN Community meeting</div>
        <header class="row my-5 p-5">
                <?php if ( get_field('profile_image') ) : ?>
                <div class="profile-pic" style="background-image:url(<?php echo get_field('profile_image'); ?>)"></div>
                <?php endif; ?>
            
            <div class="details">
                <?php $profile_owner = get_field('profile_related_user'); ?>

                <div class="profile_name">
                <?php 
                if ($profile_owner) {
                    echo '<h1 class="text-secondary">'.$profile_owner['user_firstname'].' '.$profile_owner['user_lastname'].'</h1>';
                ?>
                <?php if ( get_field('profile_mentoring') ) : ?>
                    <div class="ms-3 profile_mentor text-white"><i class="bi bi-person-workspace"></i> Mentor</div>
                <?php endif; ?>
                
                </div>
                

                <?php if ( have_rows('profile_types_repeater') ) : ?>
                    <div class="profile_types">
                        <?php while( have_rows('profile_types_repeater') ) : the_row(); ?>
                            <div class="badge bg-white text-primary me-2 mt-1">
                                <?php  
                                    set_query_var( 'type',get_sub_field('profile_type'));
                                    get_template_part( 'template-parts/icons/type-icon' ); 

                                    if(get_sub_field('profile_type') != 'Individual') {
                                        if(get_sub_field('profile_type_org')) {
                                            echo get_sub_field('profile_type_org').': &nbsp;';
                                        }
                                    }
                                ?>
                                
                                <strong><?php the_sub_field('profile_type_role'); ?></strong>
                            </div>                    
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php if ( get_field('profile_summary') ) : ?>
                    <div class="text-white mt-3">
                        <?php echo get_field('profile_summary'); ?>
                    </div>
                    <div class="text-white mt-3"><i class="bi bi-envelope-fill text-secondary"></i> email@email.com  <i class="ms-3 bi bi-telephone-fill text-secondary"></i> +44 01223 655395</div>
                    <div class="badge bg-white text-primary mt-5">Future development can include 'connect' and 'message' buttons here</div>
                <?php endif; ?>
                
                
                   
                <?php } ?>
            </div>
        </header>

        <div class="row g-5">
            <?php if ( get_field('profile_about') ) : ?>
                <div class="col-md-6" >
                    <div class="profile_block">
                        <h3>About</h3>
                        <?php echo get_field('profile_about'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( get_field('profile_country') ) : ?>
                <div class="col-12 col-md-6 profile_interests">
                    <div class="profile_block bg-primary">
                        <?php if ( have_rows('profile_research_interests') ) : ?>
                            <h3>Seeking Information on</h3>
                            <?php while( have_rows('profile_research_interests') ) : the_row(); ?>
                                <span class="badge bg-white text-primary"><?php echo get_the_title(get_sub_field('profile_research_interest_seeking')); ?></span>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if ( have_rows('profile_research_interests') ) : ?>
                            <h3>Offering Information on</h3>
                            <?php while( have_rows('profile_research_interests') ) : the_row(); ?>
                                <span class="badge bg-white text-primary"><?php echo get_the_title(get_sub_field('profile_research_interest_seeking')); ?></span>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                    
                </div>

                <div class="col-12 col-md-4 mt-3">
                    <?php if ( get_field('profile_professional') ) : ?>
                        <?php if ( have_rows('profile_professional_employer') ) : ?>
                                <div class="profile_block mt-3">
                                    <h3>Professional</h3>
                                    <?php while( have_rows('profile_professional_employer') ) : the_row(); ?>
                                        <div class="w-100"><strong><?php the_sub_field('profile_employer_name'); ?></strong> -  <?php the_sub_field('profile_role'); ?></div>
                                    <?php endwhile; ?>
                                </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="col-12 col-md-4 mt-3">
                    <?php if ( have_rows('profile_website_links') ) : ?>
                        <div class="profile_block mt-3">
                            <h3>Website Links</h3>
                            <?php while( have_rows('profile_website_links') ) : the_row(); ?>
                        
                                <a href="<?php echo get_sub_field('profile_link_url'); ?>" title="<?php echo get_sub_field('profile_link_title'); ?>" target="_blank" ><?php echo get_sub_field('profile_link_title'); ?></a>
                        
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-12 col-md-4 mt-3">
                    <div class="profile_block mt-3">
                        <h3>Locality & Language</h3>
                        <strong>Country:</strong> <?php echo get_field('profile_country'); ?>
                        <?php if ( get_field('profile_language') ) : ?>
                           <br> <strong>Language</strong> <?php echo get_field('profile_language'); ?>
                        <?php endif; ?>
                        
                    </div>
                </div>

                
    
                   


            <?php endif; ?>

           
            
                
        
                        
    
        </div>

    </div>
</div>

<?php get_footer(); ?>
