<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php 
    //Double check that the user is approved
    if (in_array('unapproved', wp_get_current_user()->roles)) {
      echo 'Your account is not approved yet. Please wait for admin approval.';
      wp_logout();
      get_footer();
      wp_die();
    }
    ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>



  <header id="masthead" class="container-fluid bg-primary py-2 px-3">
    <div class="row align-items-center">
      <div class="col-3">
        <?php if ( get_field('email_address','option') ) : ?>
          <a class="d-none d-sm-block text-secondary" href="mailto:<?php echo get_field('email_address','option'); ?>">
            <?php echo get_field('email_address','option'); ?>
          </a>
        <?php endif; ?>
        <i class="bi bi-list d-block d-sm-none menu-icon" data-bs-toggle="offcanvas" data-bs-target="#mobile_menu" aria-controls="mobile_menu"></i>
      </div>
      <?php if (is_user_logged_in()) : ?>
        <div class="col-9 d-flex justify-content-end">
            <?php get_template_part( 'template-parts/buttons/members-button' ); ?>
            <?php get_template_part( 'template-parts/buttons/logout-button' ); ?>
        </div>
      <?php else : ?>
        <div class="col-9 d-flex justify-content-end">
          <?php get_template_part( 'template-parts/buttons/join-button' ); ?>
          <?php get_template_part( 'template-parts/buttons/login-button' ); ?>
        </div>
      <?php endif; ?>
    </div>
  </header>

  <div class="container py-5" id="nav">
    <div class="row align-items-center">
        <div class="col-12 col-xl-3 text-center text-xl-start">
            <a href="/"><img class="logo pb-0 pb-sm-4 pb-xl-0" alt="<?php echo get_option('blogname'); ?>" src="<?php echo get_field('header_logo','option')['url']; ?>" /></a>
        </div>
        <div class="col-12 col-xl-9 d-none d-sm-block">
          <?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
        </div>
    </div>
  </div>

<!-- mobile menu -->
<?php get_template_part('template-parts/mobile-menu'); ?>

<!-- registration modal -->
<?php get_template_part('template-parts/register-modal'); ?>

<!-- login modal -->
<?php get_template_part('template-parts/login-modal'); ?>