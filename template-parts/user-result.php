<?php $profile_owner = get_field('profile_related_user'); ?>
<a href="<?php the_permalink(); ?>">
    <div class="user_result p-4 mb-4">
        <div class="row d-flex">
            <div class="col-12 text-center">
                <?php if ( get_field('profile_image') ) : ?>
                    <div class="profile-pic" style="background-image:url(<?php echo get_field('profile_image'); ?>)"></div>
                <?php else : ?>
                    <div class="profile-pic" style="background-image:url(<?php echo get_field('default_profile','option')['url']; ?>)"></div>
                <?php endif; ?>
            </div>
            <div class="col-12 text-center">
                    <?php     
                        if ($profile_owner) {
                            echo '<h3 class="text-primary">'.$profile_owner['user_firstname'].' '.$profile_owner['user_lastname'].'</h1>';
                        }  else {
                            echo '<h3></h3>';
                        }
                    ?>
                    <?php if ( have_rows('profile_types_repeater') ) : ?>
                        <div class="profile_types" >
                            <?php 
                            while( have_rows('profile_types_repeater') ) : the_row();
                                set_query_var( 'type', get_sub_field('profile_type') );
                                set_query_var( 'role', get_sub_field('profile_type_role') );
                                get_template_part( 'template-parts/icons/type-icon' );
                            endwhile; ?>
                        </div>
                    <?php endif; ?>
                <?php if ( get_field('profile_summary') ) : ?>
                    <div class="summary my-2">
                        <?php echo get_field('profile_summary'); ?>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</a>

    
    
