<div class="offcanvas offcanvas-start" tabindex="-1" id="mobile_menu" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <a href="/"><img class="logo img-fluid pe-5" alt="<?php echo get_option('blogname'); ?>" src="<?php echo get_field('header_logo','option')['url']; ?>" /></a>
    <button type="button" class="btn-close pe-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
  </div>
</div>