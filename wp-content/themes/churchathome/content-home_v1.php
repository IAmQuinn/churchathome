<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div id="service_this_week">
    <div id="video_box" class="show_background">
        <div id="countdown_box">
            <h3>Next Service at 10:30 am EDT (GMT - 4:00)</h3>
            <h2 id="countdown"></h2>
            <h4>
                <a href="<?php ?>">Watch Our Last Service</a>
            </h4>
        </div>
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
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/temp/this_week_image.jpg" />
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
                    Donations to www.ChurchatHome.ca (a ministry of Forward Church, Cambridge, ON) can be made through CanadaHelps.org
                    <a id="canada_helps_link" href="http://www.canadahelps.org/CharityProfilePage.aspx?CharityID=d91917">
                        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/donate_canadahelps.gif" />
                    </a>
                </p>
            </div>
        </div>
        <div id="bible_box" class="content_box">
            <div id="" class="content_box_title">
                <h2>Bible</h2>
            </div>
            <div id="bible_container" class="content_container">
                <iframe id="bible_iframe" src="https://www.bible.com/bible/111/gen.1.niv"></iframe>
            </div>
        </div>
        <div id="contact_box" class="content_box">
            <div id="" class="content_box_title">
                <h2>Contact</h2>
            </div>
            <div id="contact_container" class="content_container">
                <p>
                    Phone: (519) 621-6566<br>
                    Email: info@churchathome.ca
                </p>
            </div>
        </div>
        <div id="about_box" class="content_box">
            <div id="" class="content_box_title">
                <h2>About</h2>
            </div>
            <div id="about_container" class="content_container">
                <p>
                    "And then He told them, 'Go into all the world and teach the Good News to everyone.'"
                    Mark 16:15 (NLT)
                    Church at Home is live stream of our Sunday morning services at Forward Church in Cambridge Ontario.<br>
                    Church at Home is designed for those who may not have a local church home, those who are not able to make it to their regular church and for those who may not feel comfortable attending a regular church service at this time. Through Church at Home, individuals can experience our Sunday morning worship music and teaching, and they may also participate in live discussion.<br>
                    A Pastor is always available online during the service to chat live and answer any questions. There is also an online Bible app built into the site, so you can follow along during the teaching time.<br>
                    Church at Home meets every Sunday at 10:30 am. We look forward to having you join us!
                </p>
            </div>
        </div>
    </div>
    <div class="clear_float"></div>
</div>

<div id="chat_box">
    <div id="place_holder">

        <div id="chat_bubbles">
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/bubbles.png" alt="Chat" />
        </div>

        <div id="placeholder_title">
            Join the conversation
        </div>
        <div id="placeholder_content">
            Join us here on Sunday during the live service and participate in the conversation! The chat will be active for log-in as the service begins.
        </div>

        <div class="clear_float"></div>

    </div>
    <?php
    get_template_part('chat');
    ?>
</div>
