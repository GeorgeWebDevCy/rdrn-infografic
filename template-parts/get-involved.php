<?php $homepage = get_option( 'page_on_front' ); ?>

<div class="container-fluid pt-5" id="get-involved">
   <div class="container">
        <div class="row px-md-5 mt-3">
            <?php if ( have_rows('get_involved_tabs',$homepage) ) : ?>
            
                <?php while( have_rows('get_involved_tabs',$homepage) ) : the_row(); ?>
                    <div class="col-sm-6">
                        <div class="get_involved_header bg-primary text-white py-2 px-4 rounded fw-bold" onclick="window.location.href='<?php if ( get_sub_field('page_link') ) { echo get_sub_field('page_link')['url']; } ?>'">
                            <?php if ( get_sub_field('title') ) : ?>
                                <?php echo get_sub_field('title'); ?>
                            <?php endif; ?>
                        </div>
                        <div class="get_involved_content py-3 px-4 mb-4">
                            <?php if ( get_sub_field('content') ) : ?>
                                <?php echo get_sub_field('content'); ?>
                            <?php endif; ?>
                            <?php if ( get_sub_field('page_link') ) : ?>
                                <a href="<?php echo get_sub_field('page_link')['url']; ?>" class="btn btn-secondary">Find out more</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            
            <?php endif; ?>

            
            
        </div>
    </div>

</div>