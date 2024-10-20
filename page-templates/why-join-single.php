<?php
/*
Template Name: Why Join Single
*/

get_header();
?>

<div class="container-fluid wrapper" id="why_join_single">

<div class="container py-5">

    <header id="internal_header" class="mb-5" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');">
        <div class="content">
            <h1 class="ms-md-4 py-5">
                <?php 
                if (get_field('why_join_link')) :
                    set_query_var( 'type', get_field('why_join_link'));
                    get_template_part( 'template-parts/icons/type-icon' );
                endif;
                echo the_title(); ?>
            </h1>
        </div>
    </header>

    <div class="row px-3 py-md-5 align-items-center">
        <?php if ( get_field('why_join_full') ) : ?>
            <div class="col-lg-6 px-md-5">
                <?php echo get_field('why_join_full'); ?>
                <div class="py-4">
                    <?php get_template_part( 'template-parts/buttons/join-button' ); ?>
                    <?php get_template_part( 'template-parts/buttons/login-button' ); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( have_rows('why_join_word_cloud') ) : ?>
            <div class="col-lg-6 px-md-5 d-flex align-items-center flex-wrap justify-content-center h-100" id="word_cloud">
                <?php while( have_rows('why_join_word_cloud') ) : the_row(); ?>
                    <div class="badge m-2 text-uppercase p-2"><?php the_sub_field('Word'); ?></div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="row pxlgd-5 py-lg-5 align-items-stretch gx-5" id="statements">
        <?php if ( have_rows('statements') ) : ?>
            <?php while( have_rows('statements') ) : the_row(); ?>
                <div class="col-lg-4 statement mt-5 mt-lg-0">
                    <div class="statement_content">
                        <?php the_sub_field('Statement'); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <?php if ( have_rows('projects') ) : ?>
        <div id="projects" class="mt-5 mt-lg-0">
            <?php while( have_rows('projects') ) : the_row(); ?>
            <div class="row px-0 px-md-5 py-md-5 gx-0 project">
                <div class="col-lg-8 project_content">
                    <div class="">
                        <?php the_sub_field('Content'); ?>
                        <?php get_template_part( 'template-parts/buttons/join-button' ); ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="project_image" style="background-image:url(<?php echo get_sub_field('project_image')['url']; ?>)">
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <h2 class="text-center py-5">Other Account Types</h2>
    <?php get_template_part('template-parts/account-types'); ?>

</div>

</div>

<?php
get_footer();
?>