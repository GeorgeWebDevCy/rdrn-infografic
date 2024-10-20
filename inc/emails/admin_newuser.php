
<?php
include(get_stylesheet_directory().'/inc/emails/header.php');

$headers[] .= 'reply-to: '.$username.'<'.$email.'>';

$subject = 'New user approval request';

$body .= '<p style="text-align:left">A new user has registered and will need approval before they are able to login.</p>';
$body .= '<p style="text-align:left">Email: '.$email.'</p>';
$body .= '<p style="text-align:left">Username: '.$username.'</p>';
$body .= '<p style="text-align:left"><a href='.$admin_url.'"">View and approve user</a></p>';

include(get_stylesheet_directory().'/inc/emails/footer.php');
 

if ( wp_mail( $to_email, $subject, $body, $headers ) ) {
    return;
} else {
    error_log('Error sending email for admin_newuser');
    return;
};

