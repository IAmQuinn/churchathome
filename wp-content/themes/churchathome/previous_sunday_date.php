<?php
$hour = 10;
$minutes = 30;
$day_number = 7;
$day_of_week = date('N');
// Need to put the Date of the previous Sunday in here
if($day_of_week < 7)
    $prev_sunday = date("F j, Y", mktime($hour, $minutes, 0, date("m")  , date("d")-$day_of_week, date("Y")));
else
    $prev_sunday = date("F j, Y", mktime($hour, $minutes, 0, date("m")  , date("d"), date("Y")));

echo $prev_sunday;