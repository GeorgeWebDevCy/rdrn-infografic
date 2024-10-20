
<?php
include(get_stylesheet_directory().'/inc/emails/header.php');

$subject = 'User Account Approved';

$body .= '<p style="text-align:left">Hello,</p>';
$body .= '<p style="text-align:left">Your account is now approved and you can now login.</p>';
$body .= '<p style="text-align:left">Please note that if you created your profile during the sign up process this may still need to be approved.</p>';
$body .= '<p style="text-align:left"><a href="'.$link.'?login">Login to The Rare Disease Research Network website</a></p>';

include(get_stylesheet_directory().'/inc/emails/footer.php');

if (wp_mail($email, $subject, $body, $headers)) {
    return true;
} else {
    error_log('Error sending email for email verification');
}