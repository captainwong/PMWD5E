<?php

require_once('db_fns.php');


// register new person with db 
// return true or error message
function register($username, $email, $passwd){
    $db = db_connect();

    // check if username is unique
    $res = $db->query("select * from user where username='".$username."' or email='$email'");
    if(!$res){
        throw new Exception('Could not execute query');
    }

    if($res->num_rows > 0){
        throw new Exception('That username or email is taken - go back and choose another one');
    }

    // if ok, put in db
    $res = $db->query("insert into user values('".$username."', sha1('".$passwd."'), '".$email."')");
    if(!$res){
        throw new Exception('Could not register you in database - please try again later');
    }

    return true;
}

// see if somebody is logged in and notify them if not
function check_valid_user(){
    
    if(isset($_SESSION['valid_user'])){
        echo 'Hi dear user <strong>'.$_SESSION['valid_user'].'</strong>.<br/>';
    }else{
        // they are not logged in
        // do_html_header('Problem:');
        echo 'You are not logged in.<br/>';
        do_html_url('login.php', 'Login');
        do_html_footer();
        exit;
    }
}

// check username and password with db
// return true or throw exceptoin
function login($username, $passwd){
    $db = db_connect();
    $query = "select * from user where username='".$username."' and passwd=sha1('".$passwd."')";
    //echo $query;
    $res = $db->query($query);
    if(!$res || $res->num_rows == 0){
        throw new Exception('Could not log you in.<br/>'.$query);
    }else{
        return true;
    }
}

// change password for username/old_passwd to new_passwd
// return true or false
function change_passwd($username, $old_passwd, $new_passwd){
    // if the old password is right
    // change their password to new_passwd and return true
    login($username, $old_passwd);

    $db = db_connect();
    $query = "update user set passwd=sha1('".$new_passwd."') where username='".$username."'";
    $res = $db->query($query);
    if(!$res){
        throw new Exception("Password could not be changed.<br/>".$query);
    }else{
        return true;
    }
}

// grab a random word from dictionary between the two lengths and return it
// return random word or false
function get_random_word($min_len, $max_len){
    $word = '';
    //remember to change this path to suite your system
    $dict = '/user/dict/words'; // the ispell dictionary
    $fp = @fopen($dict, 'r'); 
    if(!$fp){
        return false;
    }

    $size = filesize($dict);

    // go to a random locatoin in dictionary
    $rand_location = rand(0, $size);
    fseek($fp, $rand_location);

    // get the next whole word of the right length in the file
    while((strlen($word) < $min_len) || (strlen($word) > $max_len) || strstr($word, "'")){
        if(feof($fp)){
            fseek($fp, 0); // if at end, goto start
        }
        $word = fgets($fp, 80); // skip first word as it could be partial
        $word = fgets($fp, 80); // the potential password
    }
    $word = trim($word);
    return $word;
}

// set password for username to a random value
// return the new password or throw exception
function reset_passwd($username){
    $new_passwd = get_random_word(6, 13);
    if($new_passwd == false){
        // give a default password
        $new_passwd = 'changeMe!';
    }

    // add a number, between 0 and 999 to it
    // to make it a slightly better password
    $rand_number = rand(0, 999);
    $new_passwd .= $rand_number;

    // set user's password to this in database or return false
    $db = db_connect();
    $res = $db->query("update user set passwd=sha1('".$new_passwd."') where username='".$username."'");
    if(!$res){
        throw new Exception('Could not change password.');
    }else{
        return $new_passwd;
    }
}

// notify the user that their password has been changed
// return true or throw exception
function notify_user_passwd_changed($username, $passwd){
    $db = db_connect();
    $res = $db->query("select email from user where username='".$username."'");
    if(!$res || $res->num_rows == 0){
        throw new Exception('Could not find email address.');
    }else{
        $row = $res->fetch_object();
        $email = $row->email;
        $from = "From: support@phpbookmark \r\n";
        $msg = "Your PHPBookmark password has been changed to ".$passwd."\r\n"
            ."Please change it next time you login.\r\n";
        
        if(mail($email, 'PHPBookmark login information', $msg, $from)){
            return true;
        }else{
            throw new Exception('Could not send mail.');
        }
    }
}

?>
