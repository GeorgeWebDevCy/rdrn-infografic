<?php get_header(); ?>

<div class="container my-5" id="single">
    <div class="row g-5">
        <div class="col-md-4 thumbnail">
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail('full', array('class' => 'img-fluid')); } ?>
        </div>
        <div class="col-md-8  p-5">
            <?php 
                the_title('<h2>','</h2>'); 
                the_content();
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
