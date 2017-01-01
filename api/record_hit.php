<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 19/03/14
 * Time: 11:54 AM
 */

if($_POST['instance_id'] == "" || $_POST['minutes'] == "") {
    echo "Error, data not supplied";
    return 0;
}

//include_once("../ajaxchat/database.php");

//$date = date("Y-m-d");
//
//$query = "INSERT INTO `views` (`date`, `unique_id`, `interval`) VALUES ('" . $date . "', " . $_POST['instance_id'] . ", '" . $_POST['minutes'] . "');";
//
//db_query($query);
//
//echo "Instance ID: " . $_POST['instance_id'] . " Minutes:" . $_POST['minutes'];
include_once('../wp-load.php');

$instance_id = $_POST['instance_id'];
$minutes = $_POST['minutes'];

if($minutes > 70) {
    echo "Beyond one hour, no longer tracking.";
    die();
}

// Need to get post for this user if it exists
$hit_catchers = get_posts(array(
    'posts_per_page' => 1,
    'post_type' => 'detected_hit',
    'meta_query' => array(
        array(
            'key'       => 'instance_id',
            'value'     => $instance_id,
            'compare'   => '=='
        )
    )
));
if($hit_catchers != null && count($hit_catchers) > 0) {
    // We already have a hit catcher for this user, update it
    $hit_catcher = $hit_catchers[0]; // Get the first entry, there should only be one anyway.

    update_post_meta($hit_catcher->ID, "minutes", $minutes);
} else {
    // We don't have a hit catcher for this user, so create one
    $post = array(
        'post_title'    => date('d/m/Y-G:i:s') . " | " . $_POST['instance_id'],
        'post_type'     => 'detected_hit',
        'post_status'   => 'publish'
    );

    $id = wp_insert_post( $post );

    add_post_meta($id, "instance_id", $instance_id);
    add_post_meta($id, "minutes", $minutes);
    add_post_meta($id, "date", date("Y-m-d"));
}