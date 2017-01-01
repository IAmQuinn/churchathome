<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 07/08/14
 * Time: 10:33 AM
 */

//    1,      2,        3,         4,       5,      6,       7
// Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday
$day_number = 4;
$hour = 10;
$minutes = 30;
//need to get date time of next sunday
$day_of_week = date('N');
//format 2014/07/31-10-30
$date = date('Y/m/j') + (7-$day_of_week);

// Calculated the days to add, at first attempt that is simply the difference between the "Display Day" and the "Current Day"
$days_to_add = $day_number - $day_of_week;
/*
However if we have passed the "Display Day" then we end up with a negative number. If we add that to the current day in the function below
then we'll be sending a date to the countdown that is in the past, we don't want that. So we simply add 7 because that will wrap us around
to the next week. Beauty!
*/
if($days_to_add < 0) {
    $days_to_add += 7;
}

/**
 * So. If we are currently on the "Display Day" this works, it will add 0 to the date and we'll end up displaying the video today, after 10:30.
 * However, it will display the video for the entire rest of the day too, so eventually (after 2 hours) we need force it to look for the next week
 */

$next_sunday  = date("Y/m/d G:i:00", mktime($hour, $minutes, 0, date("m")  , date("d")+$days_to_add, date("Y")));
//2014/08/03 10:30:00

echo "Next Display Time " . $next_sunday;
echo "<br>";
echo "Current Date Time " . date("Y/m/d G:i:00");
echo "<br>";
echo "Difference to Greenwich time (GMT) " . date("P");
echo "<br>";
echo "Timezone identifier " . date("e");
echo "<br>";
echo "Server time " . date("G:i");
echo "<br>";
echo "mktime " . mktime(date("G"), date("i"));
echo "<br>";
echo "Local time " . date("G:i", mktime(date("G") - 4, date("i")));
echo "<br>";
$end = new DateTime(date("G:i", mktime(10, 30)));
$local_now = new DateTime(date("G:i", mktime(date("G") - 4, date("i"))));
if($local_now > $end) {
    echo "we should end stream";
} else {
    echo "not 11:30 yet";
}
echo "<br>";
echo "Day light savings? " . date("I");
echo "<br>";
echo "Local Date/Time " . date("Y/m/d G:i", mktime(date("G") - 4, date("i")));
echo "<br>";
//$diff = $end->diff($local_now);
//echo "Time Comparison " . $diff->format("%H:%i");