<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 01/08/14
 * Time: 11:23 AM
 */

include_once('../wp-load.php');

$name = $_POST['name'];

$post = array(
    'post_title'    => date('d/m/Y-G:i:s') . " | " . $name,
    'post_type'     => 'chat_user',
    'post_status'   => 'publish'
);

$id = wp_insert_post( $post );

add_post_meta($id, "chat_name", $name);
add_post_meta($id, "date", date("Y m d"));
add_post_meta($id, "blocked", "0");

error_reporting(E_ERROR | E_PARSE);

// Echo the ID for the client to have
echo $id;