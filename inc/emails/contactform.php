
<?php

include(get_stylesheet_directory().'/inc/emails/header.php');


$headers[] .= 'reply-to: '.$name.'<'.$email.'>';


//ENTER COMPANY NAME AS SUBJECT
$subject = 'Message from RDRN Website';

$body .= '<p style="text-align:center">Name: '.$name.'</p>';
$body .= '<p style="text-align:center">Email: '.$email.'</p>';
$body .= '<p style="text-align:center">Message: '.$message.'</p>';


include(get_stylesheet_directory().'/inc/emails/footer.php');
 

if ( wp_mail( $to_email, $subject, $body, $headers ) ) {

    echo '<div class="w-100 alert alert-success">Thank you for your message. This has been sent.</div>';

    return;
} else {
    echo '<div class="w-100 alert alert-danger">There was an error sending your message</div>';
    return;
};
