
<?php
include(get_stylesheet_directory().'/inc/emails/header.php');

$subject = 'Please approve your email address';

$body .= '<p style="text-align:left">Hello,</p>';
$body .= '<p style="text-align:left">A new user has registered with this email on the The Rare Disease Research Network website.</p>';
$body .= '<p style="text-align:left">Please click the link below to verify your account.</p>';
$body .= '<p style="text-align:left"><a href="'.$verification_link.'">'.$verification_link.'</a></p>';

include(get_stylesheet_directory().'/inc/emails/footer.php');

if (wp_mail($email, $subject, $body, $headers)) {
    return true;
} else {
    error_log('Error sending email for email verification');
}