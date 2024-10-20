    <?php if ( basename( get_template_directory() . '/' . get_page_template()) === 'why-join-single.php') {$single_page = true;} ?>

    <div id="all_account_types" class="row <?php if (isset($single_page)) {echo 'px-md-4 gx-0';}   ?>
">

    <?php if ( have_rows('why_join_order', 110) ) : ?>
    <?php while( have_rows('why_join_order', 110) ) : the_row(); ?>

        <?php 
        $post_id = get_sub_field('account_type_page', 110); 
        if ($post_id) :
            $post = get_post($post_id);
            $title = get_the_title($post_id);

        ?>

        <?php if (isset($single_page)) {echo '<div class="col-md-4">';}   ?>
            


            <div class="gx-0 mb-4 project <?php if (isset($single_page))  {echo 'single_page px-0 px-lg-4';} else {echo 'row';}   ?>">
                
                <div class="col-lg-8 <?php if (isset($single_page)) {echo 'col-lg-12';}   ?>" >
                    <div class="project_content">
                        <h2><?php echo esc_html($title); ?></h2>
                        <?php if ( get_field('why_join_short_desc', $post_id) && !isset($single_page) ) : ?>
                            <?php echo get_field('why_join_short_desc', $post_id); ?>
                        <?php endif; ?>
                        <a class="btn btn-secondary" href="<?php echo the_permalink( $post_id ); ?>">Read More</a>
                        <?php get_template_part( 'template-parts/buttons/join-button' ); ?>
                    </div>
                </div>
                <div class="col-lg-4 <?php if (isset($single_page)) {echo 'col-lg-12';}   ?>">
                    <?php if (get_field('why_join_short_desc', $post_id)) : ?>
                        <div class="project_image text-center" style="background-image:url(<?php echo get_the_post_thumbnail_url($post_id, 'full'); ?>)">
                            <?php 
                             if (get_field('why_join_link')) :
                                set_query_var( 'type', get_field('why_join_link'));
                                get_template_part( 'template-parts/icons/type-icon' );
                            endif;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        <?php if (isset($single_page))  {echo '</div>';}   ?>



    <?php endif; ?>

    <?php endwhile; ?>
    <?php endif; ?>

</div>