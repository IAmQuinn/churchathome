$j = jQuery.noConflict();

$j(document).ready(function() {

    $j('a').on('click', function(e) {
        if($j(this).attr('href') == "#") {
            e.preventDefault();

            var title = $j(this).attr('title');

            if($j('#'+title).length < 1) { return 0; }

            $j('.content_box').each(function() {
               $j(this).removeClass('active');
            });

            $j('#'+title).addClass('active');

            /** Check to see if the main nav is open for mobile, and close it **/
            if($j('#mobile_menu').hasClass('open')) {
                $j('#mobile_menu').removeClass('open');
                $j('#page').removeClass('move_over');
                $j('#mobile_nav_container').removeClass('move_over');
            }

        }
    });

    $j('#watch_last_service').on('click', function() {
        flipVideoBox_ShowLastWeek();
    });

    // Check to see if there is a chat ID in a cookie and if so, log them in
    if($j.cookie('chat_user_id') && !$j.cookie('chat_user_fb_login')) {

        chatObject.chat_user_id = $j.cookie('chat_user_id');
        chatObject.get_user();

        // Flip over to the chat box
        flipChatBox_ShowList();

        // Mark the chat container as logged in
        $j('#chat_container').addClass('loggedin');
    }

    // Set Countdown. Makes an ajax call to the server and sets the countdown to start and what to do when it's done.
    setCountdown();

    // Start looking for messages
    loopForMessages();

    var message = "<div id='social_logos'>" +
            "<span>" +
                "<a href='https://www.facebook.com/sharer.php?app_id=661827003839768&sdk=joey&u=http%3A%2F%2Fchurchathome.ca&display=popup&ref=plugin' target='_blank'>" +
                    "<img src='/wp-content/themes/churchathome/images/social/facebook_logo.png' />" +
                "</a>" +
            "</span>" +
            "<span>" +
                "<a href='https://twitter.com/share?url=https%3A%2F%2Fchurchathome.ca' target='_blank'>" +
                    "<img src='/wp-content/themes/churchathome/images/social/twitter_logo_blue.png' />" +
                "</a>" +
            "</span>" +
            "<span>" +
                "<a href='http://www.tumblr.com/share/link?url=http%3A%2F%2Fchurchathome.ca&name=Church%20at%20Home%20&description=Watch%20church%20at%20home!%20Every%20Sunday%20morning%20at%2010:30am%20EDT%20Forward%20Church%20streams%20their%20services%20online.' target='_blank'>" +
                    "<img src='/wp-content/themes/churchathome/images/social/tumblr_logo.png' />" +
                "</a>" +

            "</span>" +
            "<span>" +
                "<a href='https://plus.google.com/share?url=http%3A%2F%2Fchurchathome.ca' target='_blank'>" +
                    "<img src='/wp-content/themes/churchathome/images/social/google_plus_logo.png' />" +
                "</a>" +
            "</span>" +
            "<div class='clear_float'></div>" +
        "</div>";

    // create the notification
    var notification = new NotificationFx({
        message : message,
        layout : 'attached',
        effect : 'flip',
        type : 'notice', // notice, warning or error
        ttl : 15000,
        wrapper : $j('#masthead'),
        onClose : function() {
//                bttn.disabled = false;
        }
    });

    $j('#share_button').on('click', function() {
        // show the notification
        if($j('.ns-box').hasClass('ns-hidden')) {
            notification.show();
        } else {
            notification.dismiss();
        }
    });

    $j('#login_form').submit(function(event) {
        event.preventDefault();

        var name = $j('#name_input').val();
        if(name != "") {
            // name is valid, log them in
            manualLogin(name);
        } else {
            $j('#login_feedback').html('What is your name? Please enter it to begin chatting.')
        }

    });

    //send_message_form
    $j('#send_message_form').submit(function(event) {
        event.preventDefault();

        var message = $j('#message_box').val();
        if(message != "") {
            // message is valid, send it
            chatObject.submit_message(message, $j('#send_message_loader'), $j('#message_box'));
        } else {
//            $j('#login_feedback').html('What is your name? Please enter it to begin chatting.')
        }
    });

    $j('#message_box').on('keypress', function() {
//       alert('keypress');
        var key = window.event.keyCode;

        if(key == 13) {
//            // they pressed the enter key
            if(!window.event.shiftKey) {
//                alert(key);
                $j('#send_message_form').submit();
                return false;
            }
        }
    });

    // Controlling the main nav jigger
    /** Both opening and closing the nav could be moved to there own functions.. **/
    $j('#mobile_menu').on('click', function() {
        if($j(this).hasClass('open')) {

            /** Close Menu **/
            $j(this).removeClass('open');
            $j('#page').removeClass('move_over');
            $j('#mobile_nav_container').removeClass('move_over');
        } else {
            $j(this).addClass('open');
            $j('#page').addClass('move_over');
            $j('#mobile_nav_container').addClass('move_over');
        }
    });

    // Everything has loaded. Send a request back to the server to clear the messages.JSON file if there is no messages for today.
    chatObject.clearFile();

    $j('#wp-admin-bar-wp-admin-bar-block-chat-user').on('click', function(e) {
        e.preventDefault();

        if($j('#users_list').hasClass('active')) {
            $j('#users_list').removeClass('active');
        } else {
            $j('#users_list').addClass('active');
        }

        // Need to get a list of all users
        $j.ajax({
            type: "GET",
            url: "api/get_chat_users.php",
            dataType: "json",
            success: function( data ) {
//                alert(data[0].user_blocked);

                var html = '<form action="/api/block_users.php" method="post">';
                html += '<h2>Users</h2>';
                html += '<p>Select or deselect users and click Update at the bottom to block or unblock chat users.</p>';
                html += '<ul>';
                for(var i = 0; i < data.length; i++) {
                    if(data[i].user_blocked == "1") {
                        html += '<li><input type="checkbox" name="' + data[i].id + '" checked="true" />';
                    } else {
                        html += '<li><input type="checkbox" name="' + data[i].id + '" />';
                    }
                    // We need to post back the ID in a hidden element so if the check box is unchecked, then the ID still get's sent to the server to be updated
                    html += '<input type="hidden" name="unchecked[]" value="' + data[i].id + '" />' + data[i].name + '</li>';
                }
                html += '</ul>';
                html += '<input type="submit" value="Update" /><input type="button" value="Cancel" onclick="closeUserList()" /></form>';
                $j('#users_container').html(html);
            }
        });

    });
});

function closeUserList() {
    $j('#users_list').removeClass('active');
    $j('#users_container').html("");
}

function facebookLogin() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        console.log('Successful login for: ' + response.name);
        console.log('Successful login for: ' + response.id);
        /**
         * Displaying Profile Picture
         *
         * http://graph.facebook.com/" + response.id + "/picture?width=80&height=80
         */
        // Set the welcome message
        $j('#welcome_container h2').html('Welcome <span class="h2_subject">' + response.first_name + '</span><img id="profile_pic" src="http://graph.facebook.com/' + response.id + '/picture?width=40&height=40" />');

        chatObject.chat_name = response.name;
        chatObject.profile_id = response.id;

        chatObject.join(true);
    });
}
function manualLogin(name) {
    $j('#welcome_container h2').html('Welcome <span class="h2_subject">' + name + '</span>');

    chatObject.chat_name = name;
    chatObject.profile_id = -1;

    chatObject.join(false);
}

function setCountdown() {

    //alert(TimezoneDetect());
    // We want to send back the gmtHours (not sure what it is, but lets do it)
    var tempd = new Date();
    var gmtHours = (tempd.getTimezoneOffset() * (-1))/60;

    $j.ajax({
        url: 'api/get_countdown_time.php',
        type: 'GET',
        data: {gmt: gmtHours},
        success: function(result) {

            $j('#countdown').countdown(result)
                .on('update.countdown', function(event) {
                    var format = '%H hour%!H, %M minute%!M, %S second%!S';
                    if(event.offset.days > 0) {
                        format = '%-d day%!d, ' + format;
                    }
                    if(event.offset.weeks > 0) {
                        format = '%-w week%!w, ' + format;
                    }
                    $j(this).html(event.strftime(format));
                })
                .on('finish.countdown', function(event) {
                    flipVideoBox_ShowVideo();
                });

        }
    });
}

function flipChatBox_ShowList() {
    $j('#chat_login').addClass('hide');
    $j('#chat_list').removeClass('hide');

    //Auto-scroll
    var list_box = $j('#all_messages_list');
    var height = list_box.height();

    var container = $j('#messages_list_container');
    container.animate({scrollTop: height}, 0);
}
function flipChatBox_ShowLogin() {
    $j('#chat_login').removeClass('hide');
    $j('#chat_list').addClass('hide');
}
function flipVideoBox_ShowVideo() {
    $j('#countdown_box').addClass('hide');
    $j('#show_video').removeClass('hide');

    $j('#place_holder').addClass('hide');
    $j('#chat_container').removeClass('hide');

    $j('#video_box').removeClass('show_background');
}
function flipVideoBox_ShowCountdown() {
    $j('#countdown_box').removeClass('hide');
    $j('#show_video').addClass('hide');

    $j('#place_holder').removeClass('hide');
    $j('#chat_container').addClass('hide');

    $j('#video_box').addClass('show_background');
}
function flipVideoBox_ShowLastWeek() {
    var html = "<iframe id='last_week_iframe' " +
    "src='//player.vimeo.com/video/114676691?autoplay=1'" +
    //"width='640'" +
    //"height='360'" +
    "frameborder='0'" +
    "webkitallowfullscreen mozallowfullscreen allowfullscreen >" +
    "</iframe>";

    $j('#countdown_box').html(html);
}
function loopForMessages() {

    /** Every 1 second check for messages **/
    var poll_for_messages = function() {
        chatObject.get_messages();
        setTimeout(poll_for_messages, 2500);
    };
    setTimeout(poll_for_messages, 2500);

    var poll_for_commands = function() {
        chatObject.get_commands();
        setTimeout(poll_for_commands, 5000);
    };
    setTimeout(poll_for_commands, 5000);
//    setInterval(function() {
//
//        chatObject.get_messages();
//
//    }, 5000);

}