<?php get_header(); ?>

<?php 
//verifiying email
if (is_page(140)) : 
    $verification_result = email_verification_handler();
    if ($verification_result === true) {
        echo '<div class="container my-5"><div class="alert alert-primary">Email verification successful.</div></div>';
    } elseif ($verification_result === false) {
        echo '<div class="container my-5"><div class="alert alert-danger">Invalid verification link.</div></div>';
    }
endif;
?>



<?php get_footer(); ?>
