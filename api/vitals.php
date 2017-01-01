<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 10/01/2015
 * Time: 9:34 PM
 */
include_once('message.php');
include_once('../wp-load.php');

$day_number = 7;
$hour = 8;
$minutes = 55;

$end_hour = 12;
$end_minutes = 30;
//need to get date time of next sunday
$day_of_week = date('N');
//format 2014/07/31-10-30
$date = date('Y/m/j') + (7-$day_of_week);

// Calculated the days to add, at first attempt that is simply the difference between the "Display Day" and the "Current Day"
$days_to_add = $day_number - $day_of_week;

echo "Day of week: " . $day_of_week;
echo "<br>";
echo "Days to add: " . $days_to_add;
echo "<br>";
if(end_stream()) {
    echo "End Stream: Yes";
}
echo "<br>";
echo "Day light savings: " . date("I");
echo "<br>";
echo "<br>";

$messages = array();
$messages_to_send = array();
$messages_exist = true;

if(file_exists('messages.json')) {

    $messages_text = file_get_contents('messages.json');

    if($messages_text != "") {
        $messages = json_decode($messages_text);
    } else {
        $messages_exist = false;
    }
} else {
    $messages_exist = false;
}

if($messages_exist) {

    $latest_message = $messages[0];

    if($latest_message->message_id > 0) {
        // There are new messages
        $posts = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'cah-chat-message',
            'meta_query' => array(
                // meta query takes an array of arrays, watch out for this!
                'relation' => 'AND',
                array(
                    'key'     => 'message_date',
                    'value'   => date('d/m/Y'),
                    'compare' => '=='
                ),
                array(
                    'key'     => 'command',
                    'value'   => "0",
                    'compare' => '=='
                ),
                array(
                    'key'     => 'message_id',
                    'value'   => "0",
                    'compare' => '>'
                )
            )
        ));

        foreach($posts as $post) {
            //if(get_post_meta($post->ID, 'message_id') > $last_id) {
            $message = new messageObject();

            $message->status = true;
            $message->name = get_post_meta($post->ID, 'chat_name')[0];
            $message->profile_id = get_post_meta($post->ID, 'profile_id')[0];
            //        $message->chat_message = $last_id;
            $message->chat_message = get_post_meta($post->ID, 'chat_message')[0];
            $message->message_id = get_post_meta($post->ID, 'message_id')[0];
            $message->command = get_post_meta($post->ID, 'command')[0];

            array_push($messages_to_send, $message);
            //}
        }
    }
}

var_dump($messages_to_send);


function end_stream() {

    /** Get and send commands **/
    $commands = array();
    $commands_exist = true;
    if(file_exists('commands.json')) {

        $commands_text = file_get_contents('commands.json');

        if($commands_text != "") {
            $commands = json_decode($commands_text);
        } else {
            $commands_exist = false;
        }
    } else {
        $commands_exist = false;
    }
    if($commands_exist) {
        // Loop through array and add anything the user doesn't already have to the messages array
        foreach($commands as $key => $command) {

            // loop through commands and see if there is an end stream command
            if($command->name == 'end_stream') {

                return true;
            }
        }
    }
    return false;
}