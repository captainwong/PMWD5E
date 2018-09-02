<?php

echo 'Function sets supported in this install are:<br />';
$extentions = get_loaded_extensions();
foreach($extentions as $extention){
    echo $extention.'<br />';
    echo '<ul>';
    $exe_funcs = get_extension_funcs($extention);
    foreach($exe_funcs as $func){
        echo '<li>'.$func.'</li>';
    }
    echo '</ul>';
}

?>