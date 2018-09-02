<!DOCTYPE html>
<html>
<head>
<title>Browse Directories</title>
</head>
<body>
<h1>Browsing</h1>

<?php
$dir=dir('uploads/');
echo '<p>Handle is '.$dir->handle.'</p>';
echo '<p>Upload directory is '.$dir->path.'</p>';
echo '<p>Directory Listing:</p><ul>';

while(false !== ($file = $dir->read())){
    if($file != '.' && $file != '..'){
        echo '<li><a href="filedetails.php?file='.$file.'">'.$file.'</a></li>';
    }
}

echo '</ul>';
$dir->close();

?>

</body>
</html>