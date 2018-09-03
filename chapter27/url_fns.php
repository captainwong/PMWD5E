<?php

require_once('db_fns.php');

// extract from the db all the urls this user has stored
// return url array or throw exception
function get_user_urls($username){
    $db = db_connect();
    $res = $db->query("select bm_url from bookmark where username='".$username."'");
    if(!$res){
        return false;
    }

    // create an array of the URLs
    $url_array = array();
    for($count = 0; $row = $res->fetch_row(); ++$count){
        $url_array[$count] = $row[0];
    }

    return $url_array;
}

// add new bookmark to the db
// return true or throw execption
function add_bm($new_url){
    echo 'Attempting to add '.htmlspecialchars($new_url).'<br/>';
    $valid_user = $_SESSION['valid_user'];
    $db = db_connect();
    $res = $db->query("select * from bookmark where username='$valid_user' and bm_url='".$new_url."'");
    if($res && ($res->num_rows > 0)){
        throw new Exception('Bookmark already exsits.');
    }

    // insert it
    if(!$db->query("insert into bookmark values('$valid_user', '$new_url')")){
        throw new Exception('Bookmark could not be inserted.');
    }

    return true;
}

// delete one url from the db
function delete_bm($user, $url){
    $db = db_connect();
    $query = "delete from bookmark where username='".$user."' and bm_url='".$url."'";
    //echo $query.'<br/>';
    if(!$db->query($query)){
        throw new Exception('Bookmark could not be deleted. <br/>'.$query);
    }
    return true;
}

// we will provide semi intelligent recommendations to people
// if they have and url in common with other users, they may like
//   other urls that these people like
function recommend_urls($valid_user, $popularity = 1){
    $db = db_connect();

    // find other matching users with an url the same as you
    //   as a simple way of excluding people's private pages,
    //   and increasing the chanse of recommending appealing URLs,
    //   we specify a minimum popularity level if $popularity=1, 
    //   then more than one person must have an url before we will recommend it

    $query = "select bm_url from bookmark
                where username in 
                    (select distinct(b2.username) from bookmark b1, bookmark b2 
                        where b1.username = '".$valid_user."'
                        and b1.username != b2.username
                        and b1.bm_url = b2.bm_url)
                and bm_url not in
                    (select bm_url from bookmark 
                        where username='".$valid_user."')
                group by bm_url
                having count(bm_url)>".$popularity;

    //echo $query.'<br/>';

    if(!($res = $db->query($query)) || ($res->num_rows == 0)){
        throw new Exception('Could not find any bookmarks to recommend.');
    }

    $urls = array();
    for($count = 0; $row = $res->fetch_row(); ++$count){
        $urls[$count] = $row[0];
    }

    return $urls;
}

?>

