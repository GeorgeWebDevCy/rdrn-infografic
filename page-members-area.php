<?php 

if (!is_user_logged_in()) : 
    wp_redirect(home_url().'?login');
    exit;
endif;



get_header();

$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();



//get users profile link
$args = array(
    'post_type' => 'profiles',
    'post_status' => array('publish', 'pending', 'draft', 'future', 'private', 'inherit'),
    'meta_query' => array(
        array(
            'key' => 'profile_related_user',
            'value' => $current_user_id,
            'compare' => '='
        )
    ),
    'posts_per_page' => 1
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    $query->the_post();
    $profile_url = get_permalink();
    $author_id = get_post_field('post_author', get_the_ID());
    $author_name = get_the_author_meta('display_name', $author_id);
    $post_status = get_post_status(get_the_ID());
    wp_reset_postdata();
} else {
    $profile_url = NULL; // Fallback URL if no profile is found
}

?>

<div class="container-fluid py-5" id="members_area">

<div class="container">
    <div class="row">
        <?php 
        //Display message to admins if accessing this page
        if (current_user_can('administrator')) {
            $admin_url = admin_url();
            echo '<div class="col-12"><div class="alert alert-warning admin-message">';
            echo 'This page is intended for members and may not function as you are logged in as an admin. To view the website admin visit <a href="' . esc_url($admin_url) . '">here</a>.';
            echo '</div></div>';
        } 
        ?>

        <div class="col-md-3 left-members-area">
            <div class="white-rounded h-100 pt-4">
                <div class="left_header px-5 py-3 text-center text-primary">
                    <?php if (get_field('profile_image', get_the_ID())) { ?>
                        <div class="profile-pic" style="background-image:url(<?php echo get_field('profile_image', get_the_ID()); ?>)"></div>
                    <?php } ?>
                    <h3 class="my-0 w-100">Welcome <br><?php echo $current_user->user_firstname.' '.$current_user->user_lastname;;?></h3>
                    @<?php echo $current_user->user_login; ?>

                </div>
                <div class="user-side-menu members-menu w-100 p-4">
                    <?php  if ($post_status == 'pending') : ?>
                        <a disabled target="_blank" class="btn disabled"><i class="bi bi-person-square "></i> View Profile<br>(Pending Review)</a>
                    <?php else : ?>
                        <a href="<?php echo $profile_url ;?>" target="_blank"><i class="bi bi-person-square"></i> View Profile</a>
                    <?php endif; ?>
                    <a href="/search"><i class="bi bi-search"></i> Member Search/Filter</a>
                </div>
                <div class="user-side-menu account-menu w-100 mt-5 p-5">
                    <a href=""><i class="bi bi-person-square"></i> Edit Profile</a>
                    <a href=""><i class="bi bi-gear-fill"></i> Account details</a>
                    <a href="<?php echo wp_logout_url(home_url());?>"><i class="bi bi-box-arrow-in-right"></i> Logout</a>
                </div>
            </div>
            
        </div>
        <div class="col-md-9">

            <div class="white-rounded p-5">
                

                <h2>Members Area</h2>

                <?php
                //message
                if ( get_field('members_notice_show') ) : 
                    echo '<div class="my-4 alert alert-primary">'.get_field('members_notice_message').'</div>'; 
                endif; 
                //intro
                if ( get_field('members_intro') ) : 
                    echo '<div class="my-4">'.get_field('members_intro').'</div>'; 
                endif; ?>



            </div>
            


        </div>
    </div>
   
</div>




</div>


<?php get_footer(); ?>
