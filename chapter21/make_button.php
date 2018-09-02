<?php
// check if we have the appropriate variable data

$button_text = $_POST['button_text'];
$button_color = $_POST['button_color'];

if(empty($button_text) || empty($button_color)){
    echo '<p>Could not create image: form not filled out correctly.</p>';
    exit;
}
$msg = '<p>button_text:'.$button_text.'<br />'.'button_color:'.$button_color.'</p>';
echo $msg;

//echo "<script type='text/javascript'>alert('$msg');</script>";

// create an image using the right color of button, and check the size
$im = imagecreatefrompng($button_color.'-button.png');

$w = imagesx($im);
$h = imagesy($im);

// our image need an 18pix margin in from the edge of the image
$w_wo_margins = $w - (2 * 18);
$h_wo_margins = $h - (2 * 18);

echo 'w='.$w.'<br/>h='.$h.'<br/>';
echo 'w_wo_margins='.$w_wo_margins.'<br/>h_wo_margins='.$h_wo_margins.'<br/>';

// tell GD2 where the font you want to use resides
putenv('GDFONTPATH=/usr/share/fonts/truetype/dejavu');

$font_name = 'DejaVuSans';

// workout if the font size will fit and make it smaller until it does
// start out with the biggest size that will reasonably fit on our buttons
$font_size = 33;

do{
    $font_size--;

    // find out the size of the text at that font size
    $bbox = imagettfbbox($font_size, 0, $font_name, $button_text);

    $r = $bbox[2]; // right coordinate
    $l = $bbox[0]; // left coordinate
    $w_ = $r - $l;
    $h_ = abs($bbox[7] - $bbox[1]);

    //echo 'w_='.$w_.'<br/>h_='.$h_.'<br/>';

}while($font_size > 8 && ($h_ > $h_wo_margins || $w_ > $w_wo_margins));

echo '<p>while ended</p>';
echo 'w_='.$w_.'<br/>h_='.$h_.'<br/>';

if($h_ > $h_wo_margins || $w_ > $w_wo_margins){
    // no readable font size will fit on button
    echo '<p>Text given will not fit on button.</p>';
}else{
    // we have found a font size that will fit.
    // now work out where to put it.
    $x = $w / 2.0 - $w_ / 2.0;
    $y = $h / 2.0 - $h_ / 2.0;

    echo 'x='.$x.'<br/>y='.$y.'<br/>';

    if($l < 0){
        $x += abs($l); // add factor for left overhang
    }

    $above_line_text = abs($bbox[7]); // how far above the baseline?

    $y += $above_line_text; // add base line factor

    $y -= 2; // adjustment factor for shape of our template

    $white = imagecolorallocate($im, 0, 0, 0);

    echo 'x='.$x.'<br/>y='.$y.'<br/>';

    imagettftext($im, $font_size, 0, $x, $y, $white, $font_name, $button_text);

    //header('Content-type: image/png');
    imagepng($im, 'result.png');

    echo '<img src="result.png" />';
}

imagedestroy($im);

?>