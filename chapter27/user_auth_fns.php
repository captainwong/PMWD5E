<?php

require_once('db_fns.php');

function register($username, $email, $passwd){
    // register new person with db 
    // return true or error message

    $db = db_connect();

    // check if username is unique
    $res = $db->query("select * from user where username='".$username."'");
    if(!$res){
        throw new Exception('Could not execute query');
    }

    if($res->num_rows > 0){
        throw new Exception('That username is taken - go back and choose another one');
    }

    // if ok, put in db
    $res = $db->query("insert into user values('".$username."', sha1('".$passwd."'), '".$email."')");
    if(!$res){
        throw new Exception('Could not register you in database - please try again later');
    }

    return true;
}