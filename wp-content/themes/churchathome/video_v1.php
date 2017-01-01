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
        src="http://forwardchurch-lh.akamaihd.net/i/forwardchurch_1@178116/master.m3u8"
        autoplay="true"
        controls="true">
        <div class="fallback">
            <p>You must have an HTML5 capable browser.</p>
        </div>
    </video>

<?php } else { ?>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/mediaplayer/jwplayer.js"></script>

    <script src="http://jwpsrv.com/library/BjYHxuiXEeK+MyIACqoQEQ.js"></script>

    <div id='mediaspace'>Loading...</div>

    <script type="text/javascript">
        jwplayer("mediaspace").setup({
            'flashplayer': '<?php bloginfo('stylesheet_directory');  ?>/mediaplayer/player-full.swf',
            'file': 'http://forwardchurch-lh.akamaihd.net/z/forwardchurch_1@178116/manifest.f4m',
            'provider': 'http://players.edgesuite.net/flash/plugins/jw/v2.11.1/jw5/AkamaiAdvancedJWStreamProvider.swf',
            'controlbar.position': 'over',
            'autostart': 'true',
            'volume': '90',
            'display.showmute': 'true',
            'width': '640',
            'height': '360',
            'stretching': 'exactfit'
        });
    </script>
<?php } ?>