<?php
if(date('I', time()) > 0)
    $offset_hour = "4:00";
else
    $offset_hour = "5:00";

$hour = get_field('reg-hour', 'option');
$minutes = get_field('reg-minute', 'option');
if ($minutes == 60) {
    $minutes = "00";
    $hour += 1;
}
$override = get_field('over-ride', 'option');
?>
<div id="service_this_week">
    <div id="video_box" class="show_background">
        <a id="watch_last_service" href="#">
            <div id="countdown_box">
                <h3>
                    <?php
                    // Try not to judge me too harshly for how disgusting this is.
                    if ($override != "yes") { ?>
                        Next Service at <?php echo $hour; ?>:<?php echo $minutes ?> am EDT (GMT - <?php echo $offset_hour; ?>)
                    <?php } else { ?>
                    &nbsp;
                    <?php } ?>
                </h3>
                <h2 id="countdown"></h2>
            </div>
        </a>
        <div id="show_video" class="hide">
            <?php
            get_template_part('video');
            ?>
        </div>
<!--        <img src="--><?php //bloginfo('stylesheet_directory'); ?><!--/images/temp/video.jpg" />-->
    </div>
    <div id="right_content_box">

        <div id="this_week_box" class="content_box active">
            <div id="" class="content_box_title">
                <h2>THIS WEEK <span class="h2_subject this_week_date">
                        <?php
                        get_template_part('previous_sunday_date');
                        ?>
                </span></h2>
            </div>
            <?php
            $series_image = get_field('series_image', 'option');
            if($series_image != null) {
            ?>
            <img src="<?php echo $series_image['url']; ?>" />
            <?php } ?>
            <div id="resources_container" class="content_container">
                <?php
                $sermon_notes = get_field('sermon_notes', 'option');
                $group_questions = get_field('group_questions', 'option');
                $media_ulr = get_field('media', 'option');

                if($sermon_notes != null) :
                    ?>
                    <div id="sermon_notes" class="resource_link">
                        <a href="<?php echo $sermon_notes['url']; ?>" target="_blank">
                            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/pdf_icon.png" />
                            <span>Sermon Notes</span>
                        </a>
                    </div>
                <?php
                endif;
                if($group_questions != null) :
                    ?>
                    <div id="group_questions" class="resource_link">
                        <a href="<?php echo $group_questions['url']; ?>" target="_blank">
                            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/pdf_icon.png" />
                            <span>Group Questions</span>
                        </a>
                    </div>
                <?php
                endif;
                if($media_ulr != "") :
                    ?>
                    <div id="media" class="resource_link">
                        <a href="<?php echo $media_ulr; ?>" target="_blank">
                            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/pdf_icon.png" />
                            <span>Media</span>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="clear_float"></div>
            </div>
        </div>


        <div id="giving_box" class="content_box">
            <div id="" class="content_box_title">
                <h2>Giving</h2>
            </div>
            <div id="giving_container" class="content_container">
                <p>
		    To contribute to ChurchatHome and Forward Church in Cambridge, Ontario, Canada.  You can safely <a href="http://forwardchurch.ca/give/" target="_blank">Donate Now</a>.
                </p>
            </div>
        </div>
        <div id="bible_box" class="content_box">
            <div id="" class="content_box_title">
                <h2>Bible</h2>
            </div>
            <div id="bible_container" class="content_container">
                <iframe id="bible_iframe" src="https://www.bible.com/bible/59/gen.1.esv"></iframe>
            </div>
        </div>
        <div id="contact_box" class="content_box">
            <div id="" class="content_box_title">
                <h2>Contact</h2>
            </div>
            <div id="contact_container" class="content_container">
                <p>
                    Phone: (519) 621-6566<br>
                    Email: <a href="mailto:kevinp@forwardchurch.ca">kevinp@forwardchurch.ca</a>
                </p>
            </div>
        </div>
        <div id="about_box" class="content_box">
            <div id="" class="content_box_title">
                <h2>About</h2>
            </div>
            <div id="about_container" class="content_container">
                <p>
                    Welcome!  Church at Home is live stream of our Sunday morning services at Forward Church in Cambridge, Ontario, Canada.  We normally stream live at 10:55am EDT (GMT - 5:00).  For July and August, our time changes to 10:00 EDT.

If you don’t have a local church home, or are not able to make it to a physical church building, Church at Home is here for you!  To get the most out of the teaching you’ll need a Bible - there is one on this site for you.   We’d love it if you participated in our discussion chat during the teaching, even if you just introduce yourself.  Or, you can get in touch with us at any time by emailing Pastor Kevin at <a href="mailto:kevinp@forwardchurch.ca" target="_blank">kevinp@forwardchurch.ca</a>.  By connecting with us today, you are part of our family, and we are here to serve you. If you’d like to learn more about Forward Church, check us out at <a href="http://forwardchurch.ca" target="_blank">forwardchurch.ca</a>.  We are glad to have you with us!
                </p>
            </div>
        </div>
    </div>
    <div class="clear_float"></div>
</div>

<div id="chat_box" class="content_box active">
    <div id="place_holder">

        <div id="placeholder_text">
            <div id="placeholder_title">
                Join the conversation
            </div>
            <div id="placeholder_content">
                Join us here on Sunday during the live service and participate in the conversation! The chat will be active for log-in as the service begins.
            </div>
        </div>

        <div id="chat_bubbles">
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/bubbles.png" alt="Chat" />
        </div>

        <div class="clear_float"></div>

    </div>
    <?php
    get_template_part('chat');
    ?>
</div>