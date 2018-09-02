<?php

// the error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline){
    echo "<p><strong>ERROR:</strong> ".$errstr."<br />
        Please try again, or contact us and tell us that the
        error occured in line ".$errline." of file ".$errfile."
        so that we can investigate further.</p>";

    if(($errno == E_USER_ERROR) || ($errno == E_ERROR)){
        echo "<p>Fatal error. Program ending.</p>";
        exit;
    }

    echo "<hr />";
}


set_error_handler('myErrorHandler');


// trigger different levels of error
trigger_error('Trigger function called.', E_USER_NOTICE);
fopen('nofile', 'r');
trigger_error('This computer is beige.', E_USER_WARNING);
include('nofile');
trigger_error('This computer will self destruct in 15 seconds.', E_USER_ERROR);

?>