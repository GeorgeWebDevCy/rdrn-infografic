<?php get_header(); ?>

<!-- Homepage slider -->
<div id="hero" class="container">
    <div class="home_swiper">
    <div class="swipe d-md-none text-center pt-2" ><i class="bi bi-hand-index-fill"></i> </div>

      <div class="swiper-wrapper">
        <?php if ( have_rows('header_slides') ) : ?>

          <?php while( have_rows('header_slides') ) : the_row(); ?>
          <div class="swiper-slide">

            <div class="slide-inner" style="background-image:url(<?php echo get_sub_field('background')['url']; ?>)">
                <div class="content-container">
                    <?php echo get_sub_field('content'); ?>
                    <?php if ( get_sub_field('button1') ) : ?>
                        <a class="mt-2 mt-lg-5 btn btn-primary" href="<?php echo get_sub_field('button1')['url']; ?>" title="<?php echo get_sub_field('button1')['title']; ?>" target="<?php echo get_sub_field('button1')['target']; ?>"><i class="bi <?php echo get_sub_field('button1_icon'); ?>"></i> <?php echo get_sub_field('button1')['title']; ?></a>
                    <?php endif; ?>
                    <?php if ( get_sub_field('button2') ) : ?>
                        <a class="mt-2 mt-lg-5 ms-2 btn btn-secondary" href="<?php echo get_sub_field('button2')['url']; ?>" title="<?php echo get_sub_field('button2')['title']; ?>" target="<?php echo get_sub_field('button2')['target']; ?>"><i class="bi <?php echo get_sub_field('button2_icon'); ?>"></i> <?php echo get_sub_field('button2')['title']; ?></a>
                    <?php endif; ?>
                </div>
              
            </div>

          </div>
          <?php endwhile; ?>
        <?php endif; ?>
        </div>

    </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
</div>

<!-- Homepage cards -->
<?php if ( have_rows('cards') ) : ?>
    <div class="container my-5" id="home_cards">
        <div class="row pb-5">
            <?php while( have_rows('cards') ) : the_row(); ?>
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <div class="card text-center">
                        <div class="icon pt-4">
                            <i class="bi <?php echo get_sub_field('card_icon'); ?>"></i>
                        </div>
                        <div class="content">
                            <h3 class="pb-2"><?php echo get_sub_field('card_title'); ?></h3>
                            <?php echo get_sub_field('card_content'); ?>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Infographic -->
<?php get_template_part('template-parts/infographic'); ?>

<!-- Get involved -->
<?php get_template_part('template-parts/get-involved'); ?>

<!-- Counters -->
<?php get_template_part('template-parts/counters'); ?>

<!-- //Testimonial -->
<?php get_template_part('template-parts/testimonials'); ?>

<!-- Latest News Slider -->
<?php get_template_part('template-parts/latest-news-slider'); ?>




<?php get_footer(); ?>
