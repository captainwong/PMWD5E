<?php

function filled_out($form_vars){
    // test that each variable has value
    foreach($form_vars as $key => $value){
        if(!isset($key) || $value==''){
            return false;
        }
    }
    return true;
}

function valid_email($address){
    // check an email address is possibly valid
    return preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-\.]+$/', $address);
}

?>
