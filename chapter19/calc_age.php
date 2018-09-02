<?php
// set date for calculation
$day=21;
$month=11;
$year=1989;

// remember you need bday as day month and year
$bdayunix = mktime(0, 0, 0, $month, $day, $year); // get ts for then
$nowunix=time(); // get unix ts for today
$ageunix=$nowunix - $bdayunix; // work out the difference
$age = floor($ageunix / (365 * 24 * 60 * 60)); // convert from seconds to years
$days = floor($ageunix % (365 * 24 * 60 * 60) / (24 * 60 * 60));
echo 'Current age is '.$age.' and '.$days.' days.';

?>