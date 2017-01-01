<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 01/08/14
 * Time: 11:23 AM
 */

include_once('../wp-load.php');
include_once('chat_user.php');

error_reporting(E_ERROR | E_PARSE);

$chat_user_id = $_POST['id'];

$user = get_post( $chat_user_id, OBJECT );

$chatUser = new chatUser();
$chatUser->name = get_post_meta($user->ID, "chat_name")[0];
$chatUser->user_blocked = get_post_meta($user->ID, "blocked")[0];
if($chatUser->user_blocked == null)
    $chatUser->user_blocked = "0";

$chatUser->id = $user->ID;

// Echo the ID for the client to have
echo json_encode($chatUser);