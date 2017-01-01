<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">
            <div id="footer_interior">
                <a id="forward_logo" href="http://forwardchurch.ca" target="_blank">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/forward_footer_logo.png" alt="Forward Church" />
                </a>
                <div id="information">
                    <div id="top_line">
                        <span class="address">455 Myers Road, Cambridge ON, N1R 5S2</span>
                        <span class="phone_number">519.621.6566</span>
                        <div class="clear_float"></div>
                    </div>
                    <div id="bottom_line">
                        <span class="website">
                            <a href="http://forwardchurch.ca" target="_blank">
                                <img class="icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/open_link_icon.png" alt="ForwardChurch.ca"/>
                                www.forwardchurch.ca
                            </a>
                        </span>
                    </div>
                </div>

                <div id="social_buttons">
                    <div class="fb-like" data-href="http://churchathome.ca/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>

                    <!-- Place this tag where you want the +1 button to render. -->
                    <div id="g-plusone_container">
                        <div class="g-plusone" data-size="medium" data-href="http://churchathome.ca"></div>
                    </div>

                    <div class="clear_float"></div>
<!--                    <img src="--><?php //bloginfo('stylesheet_directory'); ?><!--/images/social_icons.png" />-->
                </div>

                <div class="clear_float"></div>
            </div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-58507277-1', 'auto');
    ga('send', 'pageview');

</script>

<!--    <script type="text/javascript">-->
<!--var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");-->
<!--document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));-->
<!--</script>-->
<!--<script type="text/javascript">-->
<!--try {-->
<!--var pageTracker = _gat._getTracker("UA-36599586-1");//UA-6630181-1-->
<!--pageTracker._trackPageview();-->
<!--} catch(err) {}</script>-->
<!---->
<!--<script>-->

</body>
</html>