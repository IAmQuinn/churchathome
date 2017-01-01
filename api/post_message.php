<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 01/08/14
 * Time: 11:23 AM
 */

include_once('../wp-load.php');
include_once('message.php');

$name = $_POST['name'];
$profile_id = $_POST['profile_id'];
$message = $_POST['message'];
$chat_user_id = $_POST['chat_user_id'];

// Before we do anything, we need to check if this user was blocked
$user = get_post( $chat_user_id, OBJECT );

$blocked = get_post_meta($user->ID, 'blocked');

if($blocked[0] == "1") {
    // Blocked!
    echo "blocked";
    return 0;
}

// Not blocked. Let's create a new post and insert it.
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
add_post_meta($id, "command", "0");

// Create JSON file
error_reporting(E_ERROR | E_PARSE);

$posts = get_posts(array(
    'posts_per_page' => 1,
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
        )
    )
));

$messages = array();

if(file_exists('messages.json')) {
    //$messages_text = file_get_contents('messages.json');

    //if($messages_text != "") {
        //$messages = json_decode($messages_text);
    //}

} else {
    // need to create file, then close it. This should only ever happen once.
    $fp = fopen("messages.json", "x");
    fclose($fp);
}
//if($posts) {
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

        array_push($messages, $message);
    //}
}

// Open file and demolish contents
$fp = fopen("messages.json", "w");

// Lock the file, hopefully
if (flock($fp, LOCK_EX)) {
    // do file writes
    fwrite($fp, json_encode($messages));

    // unlock the file
    flock($fp, LOCK_UN);
} else {
    // flock returned false, so we didn't lock it, we should try again until it works
}

echo true;