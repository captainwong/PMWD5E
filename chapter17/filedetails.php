<!DOCTYPE html>
<html>
<head> 
<meta content ="text/html; charset=utf-8" http-equiv ="Content-type">
<title>File Details</title>
</head>
<body>
<?php
if(!isset($_GET['file'])){
    echo 'You have not specified a file name.';
}else{
    $upload_dir = '/var/www/html/PMWD5E-master/chapter17/uploads/';

    // strip off directory information for security
    $the_file = basename($_GET['file']);
    //$safe_file = iconv('utf-8', 'gbk', $upload_dir.$the_file);

    echo '<h1>Details of File: '.$safe_file.'</h1>';

    echo '<h2>File Data</h2>';
    echo 'File last accessed:'.date('j F Y H:i', fileatime($safe_file)).'<br/>';
    echo 'File last modified:'.date('j F Y H:i', filemtime($safe_file)).'<br/>';
    
    $user = posix_getpwuid(fileowner($safe_file));
    echo 'File owner:'.$user['name'].'<br/>';

    $group = posix_getgrgid(filegroup($safe_file));
    echo 'File group:'.$group['name'].'<br/>';

    echo 'File permissions:'.decoct(fileperms($safe_file)).'<br/>';
    echo 'File type:'.filetype($safe_file).'<br/>';
    echo 'File size:'.filesize($safe_file).'<br/>';

    echo '<h2>File Tests</h2>';
    echo 'is_dir:'.(is_dir($safe_file) ? 'true' : 'false').'<br/>';
    echo 'is_executable:'.(is_executable($safe_file) ? 'true' : 'false').'<br/>';
    echo 'is_file:'.(is_file($safe_file) ? 'true' : 'false').'<br/>';
    echo 'is_link:'.(is_link($safe_file) ? 'true' : 'false').'<br/>';
    echo 'is_readable:'.(is_readable($safe_file) ? 'true' : 'false').'<br/>';
    echo 'is_writable:'.(is_writable($safe_file) ? 'true' : 'false').'<br/>';
}
?>
</body>
</html>