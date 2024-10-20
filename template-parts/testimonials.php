<?php 
$homepage_id = get_option('page_on_front');
?>
<?php if ( get_field('testimonial_content', $homepage_id) ) : ?>
    <div class="container-fluid bg-primary" id="testimonial">
        <div class="container py-5">
            <div class="row">
                <div class="col-4 col-md-2 text-center d-flex justify-content-center">
                    <div class="testimonial-image" style="background-image:url(<?php echo get_field('testimonial_image', $homepage_id)['url']; ?>)">
                    </div>
                </div>
                <div class="col-8 col-md-10 text-white">
                    <?php if ( get_field('testimonial_content', $homepage_id) ) : ?>
                        <?php echo get_field('testimonial_content', $homepage_id); ?>
                    <?php endif; ?>
                    <?php if ( get_field('testimonial_author', $homepage_id) ) : ?>
                        <strong><?php echo get_field('testimonial_author', $homepage_id); ?></strong>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>