<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 30/07/14
 * Time: 3:27 PM
 */
include_once('../wp-load.php');

$override = get_field('over-ride', 'option');
$gmt = $_GET['gmt'];

$GMToffset = $gmt + 4;
// If daylight savings is "off" (we're back one hour) add another hour to our offset.
if(date("I") === "0") :
    $GMToffset += 1;
endif;

// If over ride is on, and end stream isn't clicked.
if($override == "yes" && end_stream() == false ) { //&& $message != 'end_stream'
    $date = get_field('date', 'option');
    $hour = get_field('hour', 'option');
    $minute = get_field('minute', 'option');

    $date_time = $date . " " . ($hour + $GMToffset) . ":" . $minute . ":00";

    echo $date_time;
} else {
    //    1,      2,        3,         4,       5,      6,       7
    // Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday
    $day_number = 7;
    $hour = get_field('reg-hour', 'option') + $GMToffset;
    $minutes = get_field('reg-minute', 'option');

    $end_hour = 12;
    $end_minutes = 30;
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

    // Create the default end time
    $end_time = new DateTime(date("G:i", mktime($end_hour, $end_minutes)));

    if($day_number == $day_of_week && end_stream() == false ) { // If it's the live day, then we need to check times
        $next_sunday  = date("Y/m/d G:i:00", mktime($hour, $minutes, 0, date("m")  , date("d")+$days_to_add, date("Y")));
    } else { // It's not the live day, so don't check times, just get the next sunday
        if(end_stream()) {
            // We need to get the next Sunday. That could be a week from now, or tomorrow.
            $days_to_add = $day_number - $day_of_week;
            // If today is Sunday, then we need to force it to go forward a week
            if($days_to_add <= 0) {
                $days_to_add += 7;
            }
        }
        $next_sunday  = date("Y/m/d G:i:00", mktime($hour, $minutes, 0, date("m")  , date("d")+$days_to_add, date("Y")));
    }

    echo $next_sunday;
}

function end_stream() {

    /** Get and send commands **/
    $posts = get_posts(array(
        'posts_per_page' => 1,
        'post_type' => 'cah-chat-message',
        'meta_query' => array(
            // meta query takes an array of arrays, watch out for this!
            'relation' => 'AND',
            array(
                'key'       => 'message_date',
                'value'     => date('d/m/Y'),
                'compare'   => '=='
            ),
            array(
                'key'       => 'command',
                'value'     => '1',
                'compare'   => '=='
            )
        )
    ));
    $post = null;
    if($posts != null & count($posts)) {
        $post = $posts[0];
    }
    if(get_post_meta($post->ID, 'chat_message')[0] == "end_stream") {
        return true;
    }
    return false;
}