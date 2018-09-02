<?php

function db_connect(){
    $db = new mysqli('localhost', 'bm_user', 'bm_passwd', 'bookmarks');
    if(!$db){
        throw new Exception('Could not connect to database server.');
    }else{
        return $db;
    }
}

?>
