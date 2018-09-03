<?php

require_once('bookmark_fns.php');
session_start();

do_html_header('Changing Password');

$old_pwd = $_POST['old_passwd'];
$new_pwd = $_POST['new_passwd'];
$new_pwd2 = $_POST['new_passwd2'];

try{
    check_valid_user();
    if(!filled_out($_POST)){
        throw new Exception('You have not filled out the form completely. Please try again.');
    }

    if($new_pwd != $new_pwd2){
        throw new Exception('Passwords entered were not the same. Not changed.');
    }

    if((strlen($new_pwd) > 16) || (strlen($new_pwd) < 6)){
        throw new Exception('New password must be between 6 and 16 characters. Try again.');
    }

    change_passwd($_SESSION['valid_user'], $old_pwd, $new_pwd);
    echo 'Password Changed.';
}catch(Exception $e){
    echo $e->getMessage();
}

display_user_menu();
do_html_footer();

?>
