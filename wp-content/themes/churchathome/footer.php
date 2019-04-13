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
                <div class="footer_section logo">
                    <a id="forward_logo" href="http://forwardchurch.ca" target="_blank">
                        <img src="<?php bloginfo('stylesheet_directory'); ?>/images/forward_footer_logo_v2.png" alt="Forward Church" />
                    </a>
                </div>
                <div class="footer_section section-1">
                    <h6 class="church_name">Forward Church Cambridge</h6>
                    <span>55 Franklin Boulevard, Cambridge ON, N1R 5S2</span>
                    <span>519.621.6566</span>
                </div>
                <div class="footer_section section-2">
                    <h6 class="church_name">Forward Church Kitchener</h6>
                    <span>600 Doon Village Rd, Kitchener, ON N2P 1G6</span>
                    <span>519.621.6566</span>
                </div>
                <div class="footer_section section-3">
                    <span>
                        <a href="http://forwardchurch.ca" target="_blank">
                            <img class="icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/open_link_icon.png" alt="ForwardChurch.ca"/>
                            www.forwardchurch.ca
                        </a>
                    </span>
                    <span>
                        <a href="http://forwardchurch.ca/messages-media/" target="_blank">
                            <img class="icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/open_link_icon.png" alt="ForwardChurch.ca"/>
                            Check out our archive of all past teaching.
                        </a>
                    </span>
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

</body>
</html>