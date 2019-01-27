<?php
$detect = new Mobile_Detect();
if($detect->isMobile() || $detect->isTablet()) { ?>

    <!--	<script type="text/javascript" src="js/flash_detect.js" ></script>-->
    <!--	<script type="text/javascript" src="mediaplayer/jwplayer.js"></script>-->
    <!--
    width='634'
    height='361'
    -->
    <video
        id="mobile_video"
        src="http://forwardchurchnew-lh.akamaihd.net/i/forwardchurch_1@431694/master.m3u8"
        controls="true">
        <div class="fallback">
            <p>You must have an HTML5 capable browser.</p>
        </div>
    </video>

<?php } else { ?>
    <script type="text/javascript" src="http://content.jwplatform.com/libraries/QULIX9eh.js"></script>
    <script>jwplayer.key="WycbF5T1qeWeVbu5fOmQy6jNEEdXaQ686RVLQ/XKw34=";</script>
    <div id='mediaspace'>Loading...</div>
    <script type="text/javascript">
        jwplayer("mediaspace").setup({
            file: "http://forwardchurchnew-lh.akamaihd.net/i/forwardchurch_1@431694/master.m3u8",
            width: 640,
            height: 360,
            mediaid:"EKdsjMN4"
        });
    </script>
<?php } ?>