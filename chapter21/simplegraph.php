<?php

// setup image canvas
$h = 200;
$w = 200;
$im = imagecreatetruecolor($w, $h);
$white = imagecolorallocate($im, 255, 255, 255);
$blue = imagecolorallocate($im, 0, 0, 255);

// draw on image
imagefill($im, 0, 0, $blue);
imageline($im, 0, 0, $w, $h, $white);
imagestring($im, 4, 50, 150, 'Sales', $whtie);

// output image
header('Content-type: image/png');
imagepng($im);

// clean up
imagedestroy($im);

?>