<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 01/08/14
 * Time: 11:23 AM
 */

include_once('../wp-load.php');
include_once('message.php');
$last_id = $_GET['last_id'];
$last_command_id = $_GET['last_command_id'];

error_reporting(E_ERROR | E_PARSE | E_WARNING);

$messages = array();
$messages_to_send = array();

//if(file_exists('messages.json')) {
//    $messages_text = file_get_contents('messages.json');
//
//    if($messages_text != "") {
//        $messages = json_decode($messages_text);
//    } else {
//        echo json_encode($messages_to_send);
//        die();
//    }
//} else {
//    echo json_encode($messages_to_send);
//    die();
//}

// Going to Query the DB for the latest message
//$latest_posts = get_posts(array(
//    'posts_per_page' => 1,
//    'post_type' => 'cah-chat-message',
//    'meta_query' => array(
//        // meta query takes an array of arrays, watch out for this!
//        'relation' => 'AND',
//        array(
//            'key'       => 'message_date',
//            'value'     => date('d/m/Y'),
//            'compare'   => '=='
//        ),
//        array(
//            'key'       => 'command',
//            'value'     => '0',
//            'compare'   => '=='
//        ),
//        // We want only messages with an ID greater than the last ID the client got
//        array(
//            'key'     => 'message_id',
//            'value'   => $last_id,
//            'compare' => '>'
//        )
//    )
//));
// If we returned one
//if(count($latest_posts) < 1) {
//    echo json_encode($messages_to_send);
//    die();
//}
/*
We got this far, so lets grab the message out of the JSON file and check its ID.
If it's greater than the 'last id' sent from the client, then we query the database
for the latest messages.
*/

// There should only be one message, the latest message, so we grab it
//$latest_message = $messages[0];

// Do a check to see if the one message has an ID greater than the last ID the client got
//if($latest_message->message_id > $last_id) {
    // There are new messages
    /** Database Query to get the latest messages **/
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
        // Don't get commands, we want messages
        array(
            'key'     => 'command',
            'value'   => "0",
            'compare' => '=='
        ),
        // We want only messages with an ID greater than the last ID the client got
        array(
            'key'     => 'message_id',
            'value'   => $last_id,
            'compare' => '>'
        )
    )
));

if(count($posts) < 1) {
    echo json_encode($messages_to_send);
    die();
}

    // Loop through posts (messages) and create message objects to send back
foreach($posts as $post) {
    $message = new messageObject();

    $message->status = true;
    $message->name = get_post_meta($post->ID, 'chat_name')[0];
    $message->profile_id = get_post_meta($post->ID, 'profile_id')[0];
    $message->chat_message = get_post_meta($post->ID, 'chat_message')[0];
    $message->message_id = get_post_meta($post->ID, 'message_id')[0];
    $message->command = get_post_meta($post->ID, 'command')[0];

    array_push($messages_to_send, $message);
}
//}
// echo the remains. If there are no new messages, then this array will be empty
echo json_encode($messages_to_send);

