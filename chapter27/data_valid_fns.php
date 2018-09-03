<?php

// test that each variable has value
function filled_out($form_vars){
    foreach($form_vars as $key => $value){
        if(!isset($key) || $value==''){
            return false;
        }
    }
    return true;
}

// check an email address is possibly valid
function valid_email($address){
    return preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-\.]+$/', $address);
}

?>
