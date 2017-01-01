<?php
/**
 * Created by PhpStorm.
 * User: Quinn
 * Date: 01/08/14
 * Time: 11:23 AM
 */
include_once('../wp-load.php');

// First we are going to get a single message. If this returns nothing, then we clear the .JSON file.
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
        )
    )
));
if(count($posts) < 1) {
    // Posts were not found, so
    // Open file and demolish contents. Then close the file
    if(file_exists("messages.json")) {
        $fp = fopen("messages.json", "w");
        fclose($fp);
        $fp = fopen("commands.json", "w");
        fclose($fp);
    }

    echo true;
} else {
    // Posts were found so we didn't clear the file, and we return false.
    echo false;
}