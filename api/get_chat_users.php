<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 01/08/14
 * Time: 11:23 AM
 */

include_once('../wp-load.php');
include_once('chat_user.php');

//$post = array(
//    'post_title'    => date('d/m/Y-G:i:s') . " | " . $name,
//    'post_type'     => 'chat_user',
//    'post_status'   => 'publish'
//);
//
//$id = wp_insert_post( $post );
//
//add_post_meta($id, "chat_name", $name);
//add_post_meta($id, "date", date("Y m d"));
//add_post_meta($id, "blocked", "0");

//$users = get_post(array(
//   "posts_per_page" => -1,
//    "post_type" => "chat_user"
//));
$users = get_posts(array(
    'posts_per_page' => -1,
    'post_type' => 'chat_user',
    'meta_query' => array(
        // meta query takes an array of arrays, watch out for this!
        'relation' => 'AND',
        array(
            'key'     => 'date',
            'value'   => date("Y m d"),
            'compare' => '=='
        )
    )
));

$chatUsers = array();
if(count($users) > 0) {
    foreach($users as $user) {
        $chatUser = new chatUser();
        $chatUser->name = get_post_meta($user->ID, "chat_name")[0];
        $chatUser->user_blocked = get_post_meta($user->ID, "blocked")[0];
        if($chatUser->user_blocked == null)
            $chatUser->user_blocked = "0";

        $chatUser->id = $user->ID;

        array_push($chatUsers, $chatUser);
    }
}

error_reporting(E_ERROR | E_PARSE);

// Open file and demolish contents
//$fp = fopen("users.json", "w");
// do file writes
//fwrite($fp, json_encode($users));


// Echo the ID for the client to have
echo json_encode($chatUsers);