<!DOCTYPE html>
<html>
<head>
<title>Browse Directories</title>
</head>
<body>
<h1>Browsing</h1>

<?php

$dir='uploads/';
$file1 = scandir($dir);
$file2 = scandir($dir, 1);

echo '<p>Upload directory is '.$dir.'</p>';
echo '<p>Directory Listing in alphabetical order, ascending:</p><ul>';

foreach($file1 as $file){
    if($file != '.' && $file != '..'){
        echo '<li>'.$file.'</li>';
    }
}

echo '</ul>';

echo '<p>Upload directory is '.$dir.'</p>';
echo '<p>Directory Listing in alphabetical order, decsending:</p><ul>';

foreach($file2 as $file){
    if($file != '.' && $file != '..'){
        echo '<li>'.$file.'</li>';
    }
}

echo '</ul>';


?>

</body>
</html>