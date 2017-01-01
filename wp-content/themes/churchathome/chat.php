<?php ?>

<div id="chat_container" class="hide">
    <div id="host_line">
        <div id="chat_host_container">
            <h2>
                Your chat host: <span class="h2_subject"><?php echo get_field('host_name', 'option'); ?></span>
            </h2>
        </div>
        <div id="welcome_container">
            <h2></h2>
        </div>
        <div class="clear_float"></div>
    </div>
    <div id="chat_interior">
<!--        <img id="profile_pic" src="" />-->
        <div id="chat_login">
            <fb:login-button scope="public_profile,email" data-size="xlarge" onlogin="checkLoginState();">
            </fb:login-button>
            <h2>OR</h2>
            <div id="form_container">
                <h3>Enter your name</h3>

                <form id="login_form" action="#">
                    <input id="name_input" type="text"/>
                    <input id="submit_button" type="submit" value="Submit" />
                </form>
                <h3 id="login_feedback"></h3>
            </div>
        </div>

        <div id="chat_list" class="hide">
            <div class="message_for_user_overlay">
                <div class="message_for_user_wrapper">
                    <div class="message_for_user_contents">

                    </div>
                </div>
            </div>
            <div id="messages_list_container">
                <ul id="all_messages_list">

                </ul>
            </div>
            <div id="compose_message_box">
                <form id="send_message_form" action="#">
                    <textarea name="message" id="message_box" cols="30" rows="10"></textarea>
                    <div id="send_message_right">
                        <input id="send_message" type="image" value="Send" src="<?php bloginfo('stylesheet_directory'); ?>/images/send_message.png"/>
                        <img id="send_message_loader" src="<?php bloginfo('stylesheet_directory'); ?>/images/ajax-loader.gif" alt=""/>
                    </div>
                    <div class="clear_float"></div>
                </form>
            </div>
        </div>

    </div>
</div>