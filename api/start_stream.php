<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 11/08/14
 * Time: 9:47 AM
 */
include_once('../wp-load.php');

include_once('message.php');

$name = "start_stream";
$profile_id = "";
$message = "start_stream";

$post = array(
    'post_title'    => date('d/m/Y-G:i:s') . " | " . $name,
    'post_type'     => 'cah-chat-message',
    'post_status'   => 'publish'
);

$id = wp_insert_post( $post );

add_post_meta($id, "chat_name", $name);
add_post_meta($id, "profile_id", $profile_id);
add_post_meta($id, "chat_message", $message);
add_post_meta($id, "message_date", date('d/m/Y'));
add_post_meta($id, "message_id", $id);
add_post_meta($id, "command", "1");

// Create JSON file
error_reporting(E_ERROR | E_PARSE);

// Get the latest post. Should be the Restart command
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

$commands = array();

if(file_exists('commands.json')) {
    // Do nothing, we're good
} else {
    // need to create file, then close it. This should only ever happen once.
    $fp = fopen("commands.json", "x");
    fclose($fp);
}

foreach($posts as $post) {

    $command = new messageObject();

    $command->status = true;
    $command->name = get_post_meta($post->ID, 'chat_name')[0];
    $command->profile_id = get_post_meta($post->ID, 'profile_id')[0];
    $command->chat_message = get_post_meta($post->ID, 'chat_message')[0];
    $command->message_id = get_post_meta($post->ID, 'message_id')[0];
    $command->command = get_post_meta($post->ID, 'command')[0];

    array_push($commands, $command);
}

// Open file and demolish contents.
$fp = fopen("commands.json", "w");

// Lock the file, hopefully
if (flock($fp, LOCK_EX)) {
    // write the array of commands, but it's only a single command
    fwrite($fp, json_encode($commands));

    // unlock the file
    flock($fp, LOCK_UN);
} else {
    // flock returned false, so we didn't lock it, we should try again until it works
}

header('Location: http://churchathome.preview.ldm.ca');