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

    // Loop through array and remove anything before the last ID
    foreach($messages as $key => $message) {
        // Get only messages with an ID greater than the last received message
        // and are also from the same day
        if($message->message_id > $last_id && $message->date == date('d/m/Y')) {
    //        array_splice($messages, $key, 1);
//            unset($messages[$key]);
            array_push($messages_to_send, $message);
        }
    }
}

// Append messages and commands together
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
        if($command->message_id > $last_command_id) {

//            unset($command[$key]);
            array_push($messages_to_send, $command);
        }
    }
}

// echo the remains
echo json_encode($messages_to_send);

