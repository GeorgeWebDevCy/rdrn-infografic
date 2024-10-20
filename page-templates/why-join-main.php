<?php
/*
Template Name: Why Join Main Page 
*/

get_header();
?>

<div class="container-fluid wrapper" id="why_join_main">

    <div class="container py-5">

        <header id="internal_header" class="mb-5" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');">
            <div class="content">
                <?php echo the_title('<h1 class="p-md-5">','</h1>'); ?>
            </div>
        </header>


        <?php if ( get_field('why_join_main_intro') ) : ?>
            <div class="intro row px-3 py-md-5">
                <div class="col-lg-6 px-md-5" id="intro">
                    <?php echo get_field('why_join_main_intro'); ?>
                    <div class="pt-4">
                        <?php get_template_part( 'template-parts/buttons/join-button' ); ?>
                        <?php get_template_part( 'template-parts/buttons/login-button' ); ?>
                    </div>
                </div>
                <div class="col-lg-6 pt-4 d-none d-md-block text-center" id="icons">
                    <?php 
                    get_template_part('/inc/functions/account-types'); 
                    global $account_types; 
                    foreach ($account_types as $type): 
                        set_query_var( 'type', $type );
                        get_template_part( 'template-parts/icons/type-icon' );
                    endforeach; 
                    ?>
                </div>
            </div>
        <?php endif; ?>
 
        <div class="my-5">
            <?php get_template_part('template-parts/account-types'); ?>
        </div>

        </div>


</div>

<?php get_template_part('template-parts/testimonials'); ?>

<div class="pt-5">
    <?php get_template_part('template-parts/infographic'); ?>
</div>

<?php
get_footer();
?>