<?php
/**
 * Template Name: Only Video
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

    <div id="main-content" class="main-content">

        <div id="primary" class="content-area">
            <div id="content" class="site-content" role="main">
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php
                    // Include the page content template.
                    get_template_part( 'content', 'home-video-only' );
                    ?>

                <?php endwhile; ?>

            </div><!-- #content -->
        </div><!-- #primary -->
    </div><!-- #main-content -->

<?php
get_footer();

