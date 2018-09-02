<?php

// check input
$vote = $_POST['vote'];
if(empty($vote)){
    die('<p>You have not voted for a politician</p>');
}



/***********************************
   Database query to get poll info 
***********************************/

// login db
$db = new mysqli('localhost', 'poll', 'poll', 'poll');
if(mysqli_connect_errno()){
    die('<p>Error: Could not connect to database.<br/>Please try again later.</p>');
}

// add the user's vote
$v_query = "UPDATE poll_results
            SET num_votes = num_votes + 1
            WHERE candidate = ?";
$v_stmt = $db->prepare($v_query);
$v_stmt->bind_param('s', $vote);
$v_stmt->execute();
$v_stmt->free_result();

// get current results of poll
$r_query = "SELECT candidate, num_votes FROM poll_results";
$r_stmt = $db->prepare($r_query);
$r_stmt->execute();
$r_stmt->store_result();
$r_stmt->bind_result($candidate, $num_votes);
$num_candidates = $r_stmt->num_rows;

echo 'num_candidates='.$num_candidates.'<br/>';

// calculate total number of votes so far
$total_votes = 0;
while($r_stmt->fetch()){
    $total_votes += $num_votes;
}
$r_stmt->data_seek(0);



/***********************************
   Initial calculations for graph
***********************************/

// setup constants
putenv('GDFONTPATH=/usr/share/fonts/truetype/dejavu');

$width = 500;
$margin_left = 50;
$margin_right = 50;
$bar_height = 40;
$bar_spacing = $bar_height / 2;
$font_name = 'DejaVuSans';
$title_size = 16;
$main_size = 12;
$small_size = 12;
$text_indent = 10;

// setup initial point to draw from
$x = $margin_left + 60;
$y = 50;
$bar_unit = ($width - ($x + $margin_right)) / 100;

// calculate height of graph - bars plus gaps plus some margin
$height = $num_candidates * ($bar_height + $bar_spacing) + 50;
echo 'width='.$width.'<br/>height='.$height.'<br/>';


/***********************************
   Setup base image
***********************************/

// create a bland canvas
$im = imagecreatetruecolor($width, $height);
echo '<p>im='.$im.'</p>';
//imagepng($im, 'result2.png');
//echo '<img src="result2.png" />';
//exit;

// allocate colors
$white = imagecolorallocate($im, 255, 255, 255);
$blue = imagecolorallocate($im, 0, 64, 128);
$black = imagecolorallocate($im, 0, 0, 0);
$pind = imagecolorallocate($im, 255, 78, 243);

$text_color = $black;
$percent_color = $black;
$bg_color = $white;
$line_color = $black;
$bar_color = $blue;
$number_color = $pink;

// create 'canvas' to draw on
imagefilledrectangle($im, 0, 0, $width, $height, $bg_color);

// create outline around canvas
imagerectangle($im, 0, 0, $width - 1, $height - 1, $line_color);

// add title
$title = 'Poll Results';
$title_dimensions = imagettfbbox($title_size, 0, $font_name, $title);
$title_width = $title_dimensions[2] - $title_dimensions[0];
$title_height = abs($title_dimensions[7] - $title_dimensions[0]);
$title_above_line = abs($title_dimensions[7]);
$title_x = ($width - $title_width) / 2;
$title_y = ($y - $title_height) / 2 + $title_above_line;
imagettftext($im, $title_size, 0, $title_x, $title_y, $text_color, $font_name, $title);




// draw a base line from a little above first bar location
// to a little below last
echo 'x='.$x.'<br/>y='.$y.'<br/>';
imageline($im, $x, $y - 5, $x, $height - 15, $line_color);






/***********************************
   Draw data into graph
***********************************/

// get each line of DB data and draw corresponding bars
while($r_stmt->fetch()){
    if($total_votes > 0){
        $percent = intval($num_votes * 100 / $total_votes);
    }else{
        $percent = 0;
    }

    // display percent for this value
    $percent_dimensions = imagettfbbox($main_size, 0, $font_name, $percent.'%');
    $percent_width = $percent_dimensions[2] - $percent_dimensions[0];
    imagettftext($im, $main_size, 0, $width - $percent_width - $text_indent, 
                    $y + ($bar_height / 2), $percent_color, $font_name, $percent.'%');

    // length of bar for this value
    $bar_width = $x + ($percent * $bar_unit);

    // draw bar for this value
    imagefilledrectangle($im, $x, $y - 2, $bar_width, $y + $bar_height, $bar_color);

    // draw title for this value
    imagettftext($im, $main_size, 0, $text_indent, $y + ($bar_height / 2), 
                    $text_color, $font_name, $candidate);

    // draw outline showing 100%
    imagerectangle($im, $bar_width + 1, $y - 2, 
                    ($x + (100 * $bar_unit)), $y + $bar_height, $line_color);

    // display numbers
    imagettfbbox($im, $small_size, 0, $x + (100 * $bar_unit) - 50, $y + ($bar_height / 2),
                     $number_color, $font_name, $num_votes.'/'.$total_votes);

    // move down to next bar
    $y = $y + ($bar_height + $bar_spacing);
}



/***********************************
   Display image
***********************************/

//header('Content-type: image/png');
imagepng($im, 'result2.png');
echo '<img src="result2.png" />';


/***********************************
   Clean up
***********************************/
echo ('<p>Clean up</p>');
$r_stmt->free_result();
$db->close();
imagedashedline($im);

?>