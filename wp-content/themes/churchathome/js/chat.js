// Chat Object. Handles Chat stuff
var chatObject = {
    chat_user_id: "",
    chat_name : "",
    profile_id : "",
    last_id: 0,
    last_command_id: 0,
    all_ids: [],
    blocked: false,
    submit_message : submitMessage,
    get_messages : getMessages,
    get_commands : getCommands,
    clearFile: clear_file,
    join: join,
    get_user: get_chat_user,
    sending_message: false
    };

function join(fb_login) {
    if($j.cookie('chat_user_id')) {
        chatObject.chat_user_id = $j.cookie('chat_user_id');

        // Flip over to the chat box
        flipChatBox_ShowList();

        // Mark the chat container as logged in
        $j('#chat_container').addClass('loggedin');
    } else {
        // We need to get a unique user ID
        $j.ajax({
            type: "POST",
            url: "api/create_unique_user.php",
            data: { name: this.chat_name },
            success: function( data ) {
//                alert(data);
                chatObject.chat_user_id = data;

                // Create cookie
                $j.cookie('chat_user_id', chatObject.chat_user_id, { expires: 1 });
                $j.cookie('chat_user_fb_login', fb_login, { expires: 1 });

                // Flip over to the chat box
                flipChatBox_ShowList();

                // Mark the chat container as logged in
                $j('#chat_container').addClass('loggedin');
            }
        });
    }
}

function get_chat_user() {
    // Need to get a list of all users
    $j.ajax({
        type: "POST",
        url: "api/get_chat_user.php",
        data: {id : chatObject.chat_user_id },
        dataType: "json",
        success: function( data ) {

            chatObject.chat_name = data.name;
            chatObject.profile_id = -1;
            $j('#welcome_container h2').html('Welcome <span class="h2_subject">' + data.name + '</span>');

//            var html = '<form action="/api/block_users.php" method="post">';
//            html += '<h2>Users</h2>';
//            html += '<p>Select or deselect users and click Update at the bottom to block or unblock chat users.</p>';
//            html += '<ul>';
//            for(var i = 0; i < data.length; i++) {
//                if(data[i].user_blocked == "1") {
//                    html += '<li><input type="checkbox" name="' + data[i].id + '" checked="true" />';
//                } else {
//                    html += '<li><input type="checkbox" name="' + data[i].id + '" />';
//                }
//                // We need to post back the ID in a hidden element so if the check box is unchecked, then the ID still get's sent to the server to be updated
//                html += '<input type="hidden" name="unchecked[]" value="' + data[i].id + '" />' + data[i].name + '</li>';
//            }
//            html += '</ul>';
//            html += '<input type="submit" value="Update" /><input type="button" value="Cancel" onclick="closeUserList()" /></form>';
//            $j('#users_container').html(html);
        }
    });
}

function submitMessage(message, loader, textfield) {
//    alert(this.chat_name + " " + this.profile_id + " " + message);
    // Need to post the message back to the server
    //var messageObject = { name : this.chat_name, profile_id : this.profile_id, message : message };
//    alert($j.toJSON(messageObject));

    if(this.sending_message == false) {

        this.sending_message = true;
        var thisObject = this;

        $j('.message_for_user_overlay').removeClass('active');
        $j('.message_for_user_contents').html("");

        loader.addClass('active');
        $j.ajax({
            type: "POST",
            url: "api/post_message.php",
            data: { name: this.chat_name, profile_id: this.profile_id, message: message, chat_user_id: chatObject.chat_user_id },
            success: function( data ) {
    //            alert(data);
                thisObject.sending_message = false;
                if(data == "blocked") {
                    $j('.message_for_user_overlay').addClass('active');
                    var message_for_user = "<span>Sorry, you have been blocked from using the chat feature on ChurchatHome.ca<br>If you would like to contact us you can email us <a href='mailto:kevinp@forwardchurch.ca'>here.</a></span>";
                    $j('.message_for_user_contents').html(message_for_user);
                    loader.removeClass('active'); // Make loader invisible
                    textfield.val(""); // Empty text field
                } else {
                    loader.removeClass('active'); // Make loader invisible
                    textfield.val(""); // Empty text field
                }
            },
            error: function( jqXHR, status, error) {
                console.log(status);
                console.log(error);

                thisObject.sending_message = false;
                // There was an error, lets tell the user and ask them to try again
                $j('.message_for_user_overlay').addClass('active');
                var message_for_user = "<span>Sorry, your message failed to send. Please try sending your message again.</span>";
                $j('.message_for_user_contents').html(message_for_user);
            }
        });
    }
}

function getMessages() {
    //console.log("Checking for messages..");
    //console.log("Last ID.. " + this.last_id );
    $j.ajax({
        url: "api/get_messages.php",
        data: { 'last_id' : this.last_id },
        success: receivedMessages,
        error: failed,
        dataType: 'json',
        cache: false,
        contentType: "application/json; charset=utf-8"
    });
}
function getCommands() {
    //console.log("Checking for messages..");
    //console.log("Last Command ID.. " + this.last_command_id );
    $j.ajax({
        url: "api/get_commands.php",
        data: { 'last_command_id': this.last_command_id },
        success: receivedMessages,
        error: failed,
        dataType: 'json',
        cache: false,
        contentType: "application/json; charset=utf-8"
    });
}

function receivedMessages( messages ) {

//    $j('#footer_interior').html(messages);
//    console.log("Messages: " + messages );
//    var messages = $j.parseJSON(data);
    //console.log("Old Last ID.. " + chatObject.last_id );

    // If there are no messages, than just return. Otherwise loop and
    if(messages.length < 1) { return 0; }
    console.log("New messages found..");

    messages = messages.reverse();
    for(var i = 0; i < messages.length; i++) {
        var message = messages[i];

        console.log('Command: ' + message.command);

        if(message.command == "0") {
            console.log("Message ID: " + message.message_id);
            if(chatObject.all_ids.indexOf(message.message_id) == -1) {
                // We have a messages so we want to create a message for the list of messages
                chatObject.last_id = message.message_id;
                chatObject.all_ids.push(message.message_id);

                console.log("New Last ID.. " + chatObject.last_id );

                var html = "<li class='chat_message other' data-message-id='" + message.message_id + "'>" +
                                "<div class='sender_details'>";
                if(message.profile_id != -1) // If there is a profile ID, put the image in there
                    html +=         "<div class='profile_image'><img src='http://graph.facebook.com/" + message.profile_id + "/picture?width=75&height=75' /></div>";

                html +=             "<span>" + message.name + "</span>" +
                                "</div>" +
                                "<div class='sender_message'>" +
                                    message.chat_message +
                                "</div>" +
                                "<div class='clear_float'></div>" +
                            "</li>";

                $j(html).appendTo($j('#all_messages_list'));
            }
        } else {
            // We have a COMMAND so we treat it differently
            chatObject.last_command_id = message.message_id;

            if(message.name == "end_stream") {
                console.log("Command: " + message.name );

                // If we get this message, we're going to go back to the server and ask for the next time.
                // The server will be aware of the force end stream and send back a future time to set the timer to.
                // Then we can flip the video box out and put the timer back in. It's a beautiful thing.

                // First show the countdown
                flipVideoBox_ShowCountdown();
                // Second server call and start a new countdown which will also have the necessary code to flip it back on
                setCountdown();
                // Lastly, flip the login for chat back to.. login

                flipChatBox_ShowLogin();
            } else if(message.name == "start_stream") {
                // So someone clicked end stream, or wants to force the start of the stream

                // Show video
                flipVideoBox_ShowVideo();

                // Chat box is at login screen
                // Count down isn't shown. Next time it shows will be at end stream and it is reset then anyways.
            }
        }

    }

    //Auto-scroll
    var list_box = $j('#all_messages_list');
    var height = list_box.height();

    var container = $j('#messages_list_container');
    container.animate({scrollTop: height}, 'normal');

}

function failed(jqXHR, textStatus, errorThrown) {
    console.log( "Failed to receive new messages" );
    console.log( "Text Status: " + textStatus );
    console.log( "Error Thrown: " + errorThrown );
}

function clear_file() {
    $j.ajax({
        url: "api/clear_messages.php"
    });
}