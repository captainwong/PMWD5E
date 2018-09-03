<?php

require_once('bookmark_fns.php');
session_start();

$del_me = $_POST['del_me'];
$valid_user = $_SESSION['valid_user'];

do_html_header('Deleting bookmarks');
check_valid_user();

if(!filled_out($_POST)){
    echo '<p>You have not chosen any bookmarks to delete.<br>
            Please try again.</p>';
    display_user_menu();
    do_html_footer();
    exit;
}else{
    if(count($del_me) > 0){
        foreach($del_me as $url){
            if(delete_bm($valid_user, $url)){
                echo 'Deleted '.htmlspecialchars($url).'.<br/>';
            }else{
                echo 'Could not delte '.htmlspecialchars($url).'<br/>';
            }
        }
    }else{
        echo 'No bookmarks selected for deletion.';
    }
}

if($urls = get_user_urls($valid_user)){
    display_user_urls($urls);
}

display_user_menu();
do_html_footer();

?>
