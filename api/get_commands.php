<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 01/08/14
 * Time: 11:23 AM
 */

include_once('../wp-load.php');
include_once('message.php');
$last_command_id = $_GET['last_command_id'];

error_reporting(E_ERROR | E_PARSE | E_WARNING);

$messages_to_send = array();
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
        ),
        // We want only messages with an ID greater than the last ID the client got
        array(
            'key'     => 'message_id',
            'value'   => $last_command_id,
            'compare' => '>'
        )
    )
));

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

// echo the remains
echo json_encode($messages_to_send);

