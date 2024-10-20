<div class="container-fluid py-5" id="news-slider">
    <div class="swipe d-md-none text-center pt-5" ><i class="bi bi-hand-index-fill"></i> </div>
    <div class="container">
        <div class="row news-slide-row">
            <div class="news_swiper py-5">
                <div class="swiper-wrapper" aria-label="Swipe left and right for more news">
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 20, 
                    );
                    $query = new WP_Query( $args );
                    
                    if ( $query->have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            echo '<div class="swiper-slide">';
                                echo '<div class="thumbnail" style="background-image:url('.$thumbnail_url.')"></div>';
                                echo '<div class="content">';
                                    echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
                                    echo '<p>'.the_excerpt().'</P>'; 
                                echo '</div>';
                                echo '<a class="more_link" href="'. get_permalink() .'">Read More</a>';
                            echo '</div>';
                            
                        }
                    } else {
                        echo 'No posts found.';
                    }
                    wp_reset_postdata();
                    ?>

                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</div>