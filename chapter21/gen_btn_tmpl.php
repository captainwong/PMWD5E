<?php
$im = imagecreatetruecolor(500, 230);

$red = imagecolorallocate($im, 255, 0, 0);
$green = imagecolorallocate($im, 0, 255, 0);
$blue = imagecolorallocate($im, 0, 0, 255);


imagefill($im, 0, 0, $red);
imagepng($im, 'red-button.png');



imagefill($im, 0, 0, $green);
imagepng($im, 'green-button.png');



imagefill($im, 0, 0, $blue);
imagepng($im, 'blue-button.png');


imagedestroy($im);



?>