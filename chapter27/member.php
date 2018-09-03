<?php

require_once('bookmark_fns.php');
session_start();

if(!isset($_SESSION['valid_user'])){
    if(!isset($_POST['username'])){
        $_POST['username'] = ' ';
    }
    
    $username = $_POST['username'];
    
    if(!isset($_POST['passwd'])){
        $_POST['passwd'] = ' ';
    }
    $passwd = $_POST['passwd'];
    
    //echo 'username='.$username.", password=".$passwd;
    
    if($username && $passwd){
        try{
            login($username, $passwd);
            $_SESSION['valid_user'] = $username;
        }catch(Exception $e){
            // login failed
            do_html_header('Problem:');
            echo 'You could not be logged in.<br>
                You must be logged in to view this page.';
            do_html_url('login.php', 'Login');
            do_html_footer();
            exit;
        }
    }
}


do_html_header('Home');
check_valid_user();

// get the bookmarks this user has saved
if($url_array = get_user_urls($_SESSION['valid_user'])){
    display_user_urls($url_array);
}

// give menu of options
display_user_menu();

do_html_footer();

?>
