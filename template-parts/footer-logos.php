<div id="footer_logos" class="container-fluid py-5">
    <?php if ( have_rows('footer_logos','option') ) : ?>
        <div class="swiper-wrapper">
            <?php while( have_rows('footer_logos','option') ) : the_row(); ?>
                <div class="swiper-slide">
                    <a href="<?php echo get_sub_field('link'); ?>" target="_blank" title="<?php echo get_sub_field('logo')['alt']; ?>"><img src="<?php echo get_sub_field('logo')['url']; ?>" alt="<?php echo get_sub_field('logo')['alt']; ?>"></a>
                </div> 
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>