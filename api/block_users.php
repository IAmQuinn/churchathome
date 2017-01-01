<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 11/08/14
 * Time: 9:47 AM
 */
include_once('../wp-load.php');

//var_dump($_POST);

if(count($_POST) > 0) {
    foreach($_POST as $key => $id) {
//        echo $id;
        // Remove this item from the array of all items
        if($id == "on") {
            $index = array_search($key, $_POST['unchecked']);
            //echo $index;
        //if($index != false) {
            unset($_POST['unchecked'][$index]);

            if( ! update_post_meta($key, "blocked", "1") ) {
                update_post_meta($key, "blocked", "1");
            }
        }
    }
    foreach($_POST['unchecked'] as $item) {
        if( ! update_post_meta($item, "blocked", "0") ) {
            update_post_meta($item, "blocked", "0");
        }
    }
}

$location = get_bloginfo('url');
header('Location: ' . $location);

//$name = $_GET['name'];
//$profile_id = "";
//$message = "end_stream";
//
//$post = array(
//    'post_title'    => date('d/m/Y-G:i:s') . " | " . $name,
//    'post_type'     => 'cah-chat-message',
//    'post_status'   => 'publish'
//);
//
//$id = wp_insert_post( $post );
//
//add_post_meta($id, "chat_name", $name);
//add_post_meta($id, "profile_id", $profile_id);
//add_post_meta($id, "chat_message", $message);
//add_post_meta($id, "message_date", date('d/m/Y'));
//add_post_meta($id, "message_id", $id);
//add_post_meta($id, "command", "1");
//
//// Create JSON file
//error_reporting(E_ERROR | E_PARSE);
//
//$posts = get_posts(array(
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
//            'value'     => '1',
//            'compare'   => '=='
//        )
//    )
//));
//
//$commands = array();
//
//if(file_exists('commands.json')) {
//    // Do nothing, we're good
//} else {
//    // need to create file, then close it. This should only ever happen once.
//    $fp = fopen("commands.json", "x");
//    fclose($fp);
//}
//
//foreach($posts as $post) {
//
//    $command = new messageObject();
//
//    $command->status = true;
//    $command->name = get_post_meta($post->ID, 'chat_name')[0];
//    $command->profile_id = get_post_meta($post->ID, 'profile_id')[0];
//    $command->chat_message = get_post_meta($post->ID, 'chat_message')[0];
//    $command->message_id = get_post_meta($post->ID, 'message_id')[0];
//    $command->command = get_post_meta($post->ID, 'command')[0];
//
//    array_push($commands, $command);
//}
//
//// Open file and demolish contents
//$fp = fopen("commands.json", "w");
//
//// Lock the file, hopefully
//if (flock($fp, LOCK_EX)) {
//    // do file writes. Only writes one command, the latest command.
//    fwrite($fp, json_encode($commands));
//
//    // unlock the file
//    flock($fp, LOCK_UN);
//} else {
//    // flock returned false, so we didn't lock it, we should try again until it works
//}
//
//$location = get_bloginfo('url');
//header('Location: ' . $location);