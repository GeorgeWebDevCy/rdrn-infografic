<!-- Footer logos -->
<?php get_template_part('template-parts/footer-logos');  ?>

<footer class="container-fluid bg-primary p-4">
    <div class="container py-4">
        <div class="row">

            <div class="col-md-5 col-lg-3">
                <?php if ( get_field('footer_logo','option') ) : ?>
                    <img src="<?php echo get_field('footer_logo','option')['url']; ?>" alt="<?php echo get_option('blogname'); ?>" class="img-fluid">
                <?php endif; ?>
                <?php if ( get_field('email_address','option') ) : ?>
                    <a class="d-block pt-4 pb-1 w-100 email" href="mailto:<?php echo get_field('email_address','option'); ?>">
                        <?php echo get_field('email_address','option'); ?>
                    </a>
                <?php endif; ?>

                <div class="socials text-white">
                    <?php if ( get_field('linkedin','option') ) : ?>
                        <a href="<?php echo get_field('linkedin','option'); ?>" class="text-white pe-2" title="LinkedIn" target="_blank"><i class="bi bi-linkedin"></i></a>
                    <?php endif; ?>
                    <?php if ( get_field('facebook','option') ) : ?>
                        <a href="<?php echo get_field('facebook','option'); ?>" class="text-white pe-2" title="Facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if ( get_field('twitter','option') ) : ?>
                        <a href="<?php echo get_field('twitter','option'); ?>" class="text-white pe-2" title="Twitter" target="_blank"><i class="bi bi-twitter"></i></a>
                    <?php endif; ?>
                    <?php if ( get_field('instagram','option') ) : ?>
                        <a href="<?php echo get_field('instagram','option'); ?>" class="text-white pe-2" title="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ( get_field('youtube','option') ) : ?>
                        <a href="<?php echo get_field('youtube','option'); ?>" class="text-white pe-2" title="youtube" target="_blank"><i class="bi bi-youtube"></i></a>
                    <?php endif; ?>
                    <?php if ( get_field('threads','option') ) : ?>
                        <a href="<?php echo get_field('threads','option'); ?>" class="text-white pe-2" title="threads" target="_blank"><i class="bi bi-threads"></i></a>
                    <?php endif; ?>
                </div>

                <div class="copyright text-white pt-5  d-none d-md-block"">
                    <small>Copyright Rare Disease Research Network <?php echo date('Y'); ?></small>
                </div>

                <div class="redweb d-none d-md-block">
                    <small><a target="_blank" href="https://redwebcambridge.com" target="_blank">Website Design & Development: Red Web</a></small>
                </div>

            </div>

            <div class="col-md-6 col-lg-4">
                <div class="footer-menu">
                    <?php wp_nav_menu(array('theme_location' => 'footer-menu')); ?>
                </div>
                <div class="mailing-list mt-5 mt-md-1">
                       
                        <?php get_template_part('template-parts/mailchimp-signup'); ?>

                </div>
            </div>

            <div class="col-12 col-lg-5 mt-5 mt-md-1">

                <form class="footer-form container-fluid" action="#contactus" method="post" enctype="multipart/form-data" id="contactus">
                    <label for="message">Send us a Message</label>
                    <?php 
                if ( isset($_POST['contact_form'])) :
                    $captcha=$_POST['cf-turnstile-response'];

                    if (!$captcha) {
                        echo '<div id="alert" class="w-100 alert alert-danger">Please confirm you are not a robot to submit the form.</div>';
                    } else {
                            
                        $secretKey = "0x4AAAAAAAC1dS_7ue2qt7VI8q4XHvzR4ts";
                        $ip = $_SERVER['REMOTE_ADDR'];

                        $url_path = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
                        $data = array('secret' => $secretKey, 'response' => $captcha, 'remoteip' => $ip);

                        $options = array(
                            'http' => array(
                            'method' => 'POST',
                            'content' => http_build_query($data))
                        );

                        $stream = stream_context_create($options);

                        $result = file_get_contents(
                        $url_path, false, $stream);

                        $response =  $result;
                        $responseKeys = json_decode($response,true);

                if(intval($responseKeys["success"]) !== 1) {
                        echo '<div id="alert" class="w-100 alert alert-danger">Something went wrong, please try again.</div>';
                    } else { 


                        $name = ( isset($_POST['fullname']) ? sanitize_text_field($_POST['fullname']) : '' );
                        $email = ( isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '' );
                        $message = ( isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '' );


                        //send email
                        if ( get_field('email_address','option') ) : 
                            $email_to = get_field('email_address','option'); 
                        else :
                            $email_to = 'lewis@redwebcambridge.com';
                        endif;
                        
                        set_query_var( 'to_email', $email_to );

                        set_query_var( 'name', $name );
                        set_query_var( 'email', $email  );
                        set_query_var( 'message',  $message );

                        get_template_part('inc/emails/contactform');
                    }
                }
        endif;
        ?>



                    <div class="row pt-2">
                        <div class="form-group col-md-6">
                            <input class="w-100 form-control name" id="name" type="text" placeholder="Name" autocomplete="off" name="fullname" />
                        </div>
                        <div class="form-group col-md-6 pt-2 pt-md-0">
                            <input class="w-100 form-control email" id="email_footer" type="email" placeholder="Email Address" autocomplete="email" name="email"/>
                        </div>
                        <div class="col-12">
                            <textarea class="py-3 mt-2 form-control" id="message" placeholder="Message" name="message" ></textarea>
                        </div>
                    </div>
                    
                    <div class="row pt-2 align-items-center">
                        <div class="col-xl-6 text-xl-center">
                            <div class="cf-turnstile" data-theme="light" data-sitekey="0x4AAAAAAAC1dTv4H--eEarL"></div>                        
                        </div>
                        <div class="col-xl-6 mb-3 text-end">
                            <input type="hidden" name="contact_form" value="true"/>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>                        
                    </div>
                </form>

                <div class="copyright text-white pt-5 d-block d-md-none">
                    <small>Copyright Rare Disease Research Network <?php echo date('Y'); ?></small>
                </div>
                <div class="redweb d-block d-md-none">
                    <small><a target="_blank" href="https://redwebcambridge.com" target="_blank">Website Design & Development: Red Web</a></small>
                </div>
            </div>

        </div>
    </div>
</footer> 

<?php wp_footer(); ?>
</body>
</html>
