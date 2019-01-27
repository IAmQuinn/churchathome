<?php
/**
 * Twenty Fourteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

    /** Include Mobile Detect Library **/
    include_once('mobile_detect.php');

    /** Custom Admin Page **/
    //function custom_admin_page() {
    //    $parent_slug = "";
    //    $page_title = "Manual Stream Control";
    //    $menu_title = "Manual Stream Control";
    //    $capability = "manage_options";
    //    $menu_slug = "stream-control";
    //    $function = "manual_stream_control_page";
    //    $icon_url = "";
    //    $position = "";
    //
    //    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url );
    //    //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    //}
    //add_action( 'admin_menu', 'custom_admin_page' );

    //function manual_stream_control_page() {
    //
    //    echo "<div class='wrap no_move'>";
    //    echo "<h2>Manual Stream Control</h2>";
    //
    //    echo "<div class='metabox-holder has-right-sidebar' id='poststuff'>";
    //    echo "<div id='post-body'>";
    //    echo "<div id='post-body-content'>";
    //
    //    echo "<div id='normal-sortables' class='meta-box-sortables'>";
    //
    //    echo "<div id='' class='postbox  acf_postbox default'>";
    //
    //    echo "<div class='handlediv' title='Click to toggle'><br></div>";
    //    echo "<h3 class='hndle'><span>End the Stream</span></h3>";
    //
    //    echo "<div class='inside'>";
    //
    //    echo "<div class='field'>";
    //
    //    echo "<p>Click this button to turn off the stream.</p>";
    //    echo "<p>It will tell all clients to hide the video box and request the next time to countdown to.</p>";
    //    echo "<p>The server will have a record of the command and serve up the next appropriate time.</p>";
    //    echo "<p>If you click this right after the video goes live then the stream isn't going play!</p>";
    //
    //    echo "<form action='' method='post'>";
    //
    //    echo "<input type='button' class='button' value='End Stream'>";
    //
    //    echo "</form>";
    //
    //    echo "</div>"; // Close .field
    //    echo "</div>"; // Close .inside
    //    echo "</div>"; // Close .postbox
    //    echo "</div>"; // Close #normal-sortables
    //    echo "</div>"; // Close #post-body-content
    //    echo "</div>"; // Close #post-body
    //    echo "</div>"; // Close #poststuff
    //
    //    echo "</div>"; // Close .wrap .no_move
    //}

    // remove unwanted dashboard widgets for relevant users
    function churchathome_remove_dashboard_widgets() {
        $user = wp_get_current_user();
        //if ( ! $user->has_cap( 'manage_options' ) ) {
            remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
            remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
            remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
            remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
            remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
        //}
    }
    add_action( 'wp_dashboard_setup', 'churchathome_remove_dashboard_widgets' );

    add_action( 'admin_bar_menu', 'add_to_toolbar', 999);

    function add_to_toolbar( $wp_admin_bar ) {

        $args = array(
            'id' => 'wp-admin-bar-end-stream',
            'title' => 'End Stream',
            'href' => '/api/post_command.php?name=end_stream'
        );
        $wp_admin_bar->add_node( $args );

        $args = array(
            'id' => 'wp-admin-bar-restart-stream',
            'title' => 'Restart Stream',
            'href' => '/api/post_command.php?name=start_stream'
        );
        $wp_admin_bar->add_node( $args );

        $args = array(
            'id' => 'wp-admin-bar-block-chat-user',
            'title' => 'Block Chat User',
            'href' => '#'
        );
        $wp_admin_bar->add_node( $args );
    }

    // add new dashboard widgets
    function wptutsplus_add_dashboard_widgets() {
        wp_add_dashboard_widget( 'churchathome_dashboard_links', 'Config', 'churchathome_add_configure_widget' );
    }

    function churchathome_add_configure_widget() { ?>

        <h2>Configure Church at Home for today</h2>
        <ul>
            <li><a href="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=acf-options-downloads-host-media">Set Downloads, Host, Media</a></li>
            <li><a href="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=acf-options-timer-config">Timer Config</a></li>
            <li><a href="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=view-hits">View Hits</a></li>
        </ul>
    <?php }
    add_action( 'wp_dashboard_setup', 'wptutsplus_add_dashboard_widgets' );

    /** Register Options Pages for Custom Fields  **/
    function add_options_pages( $settings )
    {
        $settings['title'] = 'Church at Home Config';
        $settings['pages'] = array('Downloads, Host, Media', 'Timer Config');

        return $settings;
    }
    add_filter('acf/options_page/settings', 'add_options_pages');

    /**
     * Set up the content width value based on the theme's design.
     *
     * @see twentyfourteen_content_width()
     *
     * @since Twenty Fourteen 1.0
     */
    if ( ! isset( $content_width ) ) {
        $content_width = 474;
    }

    /**
     * Twenty Fourteen only works in WordPress 3.6 or later.
     */
    if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
        require get_template_directory() . '/inc/back-compat.php';
    }

    if ( ! function_exists( 'twentyfourteen_setup' ) ) :
    /**
     * Twenty Fourteen setup.
     *
     * Set up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support post thumbnails.
     *
     * @since Twenty Fourteen 1.0
     */
    function twentyfourteen_setup() {

        /*
         * Make Twenty Fourteen available for translation.
         *
         * Translations can be added to the /languages/ directory.
         * If you're building a theme based on Twenty Fourteen, use a find and
         * replace to change 'twentyfourteen' to the name of your theme in all
         * template files.
         */
        load_theme_textdomain( 'twentyfourteen', get_template_directory() . '/languages' );

        // This theme styles the visual editor to resemble the theme style.
        add_editor_style( array( 'css/editor-style.css', twentyfourteen_font_url() ) );

        // Add RSS feed links to <head> for posts and comments.
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails, and declare two sizes.
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 672, 372, true );
        add_image_size( 'twentyfourteen-full-width', 1038, 576, true );

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary'   => __( 'Top primary menu', 'twentyfourteen' ),
            'secondary' => __( 'Secondary menu in left sidebar', 'twentyfourteen' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
        ) );

        // This theme allows users to set a custom background.
        add_theme_support( 'custom-background', apply_filters( 'twentyfourteen_custom_background_args', array(
            'default-color' => 'f5f5f5',
        ) ) );

        // Add support for featured content.
        add_theme_support( 'featured-content', array(
            'featured_content_filter' => 'twentyfourteen_get_featured_posts',
            'max_posts' => 6,
        ) );

        // This theme uses its own gallery styles.
        add_filter( 'use_default_gallery_style', '__return_false' );


        /** Custom Add Post Type **/
        $labels = array(
            'name'               => _x( 'Chat Message', 'post type general name', 'your-plugin-textdomain' ),
            'singular_name'      => _x( 'Chat Message', 'post type singular name', 'your-plugin-textdomain' ),
            'menu_name'          => _x( 'Chat Messages', 'admin menu', 'your-plugin-textdomain' ),
            'name_admin_bar'     => _x( 'Chat Message', 'add new on admin bar', 'your-plugin-textdomain' ),
            'add_new'            => _x( 'Add New', 'message', 'your-plugin-textdomain' ),
            'add_new_item'       => __( 'Add New Chat Message', 'your-plugin-textdomain' ),
            'new_item'           => __( 'New Chat Message', 'your-plugin-textdomain' ),
            'edit_item'          => __( 'Edit Chat Message', 'your-plugin-textdomain' ),
            'view_item'          => __( 'View Chat Message', 'your-plugin-textdomain' ),
            'all_items'          => __( 'All Chat Messages', 'your-plugin-textdomain' ),
            'search_items'       => __( 'Search Chat Messages', 'your-plugin-textdomain' ),
            'parent_item_colon'  => __( 'Parent Chat Messages:', 'your-plugin-textdomain' ),
            'not_found'          => __( 'No Chat Messages found.', 'your-plugin-textdomain' ),
            'not_found_in_trash' => __( 'No Chat Messages found in Trash.', 'your-plugin-textdomain' )
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true, // Needs to be true to see in back end
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'show_ui'               => true, // Needs to be true to see in back end
            'show_in_nav_menus'     => false,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => false,
            'capability_type'       => 'post',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'chat-message' ),

            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => null,
            'supports'              => array( 'title' )
        );

        register_post_type( 'cah-chat-message', $args );

        $labels = array(
            'name'               => _x( 'Hits', 'post type general name', 'your-plugin-textdomain' ),
            'singular_name'      => _x( 'Hit', 'post type singular name', 'your-plugin-textdomain' ),
            'menu_name'          => _x( 'Hits', 'admin menu', 'your-plugin-textdomain' ),
            'name_admin_bar'     => _x( 'Hit', 'add new on admin bar', 'your-plugin-textdomain' ),
            'add_new'            => _x( 'Add New', 'message', 'your-plugin-textdomain' ),
            'add_new_item'       => __( 'Add New Hit', 'your-plugin-textdomain' ),
            'new_item'           => __( 'New Hit', 'your-plugin-textdomain' ),
            'edit_item'          => __( 'Edit Hit', 'your-plugin-textdomain' ),
            'view_item'          => __( 'View Hit', 'your-plugin-textdomain' ),
            'all_items'          => __( 'All Hits', 'your-plugin-textdomain' ),
            'search_items'       => __( 'Search Hits', 'your-plugin-textdomain' ),
            'parent_item_colon'  => __( 'Parent Hits:', 'your-plugin-textdomain' ),
            'not_found'          => __( 'No Hits found.', 'your-plugin-textdomain' ),
            'not_found_in_trash' => __( 'No Hits found in Trash.', 'your-plugin-textdomain' )
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true, // Needs to be true to see in back end
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'show_ui'               => true, // Needs to be true to see in back end
            'show_in_nav_menus'     => false,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => false,
            'capability_type'       => 'post',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'hit' ),
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => null,
            'supports'              => array( 'title' )
        );

        register_post_type( 'detected_hit', $args );

        $labels = array(
            'name'               => _x( 'Chat User', 'post type general name', 'your-plugin-textdomain' ),
            'singular_name'      => _x( 'Chat User', 'post type singular name', 'your-plugin-textdomain' ),
            'menu_name'          => _x( 'Chat User', 'admin menu', 'your-plugin-textdomain' ),
            'name_admin_bar'     => _x( 'Chat User', 'add new on admin bar', 'your-plugin-textdomain' ),
            'add_new'            => _x( 'Add New', 'message', 'your-plugin-textdomain' ),
            'add_new_item'       => __( 'Add New Chat User', 'your-plugin-textdomain' ),
            'new_item'           => __( 'New Chat User', 'your-plugin-textdomain' ),
            'edit_item'          => __( 'Edit Chat User', 'your-plugin-textdomain' ),
            'view_item'          => __( 'View Chat User', 'your-plugin-textdomain' ),
            'all_items'          => __( 'All Chat Users', 'your-plugin-textdomain' ),
            'search_items'       => __( 'Search Chat Users', 'your-plugin-textdomain' ),
            'parent_item_colon'  => __( 'Parent Chat Users:', 'your-plugin-textdomain' ),
            'not_found'          => __( 'No Chat Users found.', 'your-plugin-textdomain' ),
            'not_found_in_trash' => __( 'No Chat Users found in Trash.', 'your-plugin-textdomain' )
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true, // Needs to be true to see in back end
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'show_ui'               => true, // Needs to be true to see in back end
            'show_in_nav_menus'     => false,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => false,
            'capability_type'       => 'post',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'Chat User' ),
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => null,
            'supports'              => array( 'title' )
        );

        register_post_type( 'chat_user', $args );
    }

    add_action( 'admin_head', 'admin_css' );
    function admin_css()
    {
        ?><link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/admin_style.css" /><?php
    }

    add_action( 'admin_menu', 'register_custom_menu_page' );

    function register_custom_menu_page() {
        add_menu_page( "Hits", "View Hits", "manage_options", "view-hits", "view_hits", null, null );
    }
    function view_hits() {
        echo "<h1>View Hits</h1>";
        $dates = array();

        $hits_dates = get_posts(array('post_type' => 'detected_hit', 'posts_per_page' => -1));
        foreach($hits_dates as $hit_date) {
            $date = get_post_meta($hit_date->ID, "date");
            if(in_array($date, $dates) == false)
                array_push($dates, $date);
        }
        ?>

        <div id="stats_container">
            <div class="head_row">
                <div class="cell"><h3>Date</h3></div>
                <div class="cell"><h3>5 Minutes</h3></div>
                <div class="cell"><h3>15 Minutes</h3></div>
                <div class="cell"><h3>30 Minutes</h3></div>
                <div class="cell"><h3>45 Minutes</h3></div>
                <div class="cell"><h3>60+ Minutes</h3></div>
                <div class="cell"><h3>Total People</h3></div>
                <div class="clear_float"></div>
            </div>
            <?php
            foreach($dates as $date) {
                $hits = get_posts(
                    array(
                        'post_type' => 'detected_hit',
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            // meta query takes an array of arrays, watch out for this!
                            'relation' => 'AND',
                            array(
                                'key'     => 'date',
                                'value'   => $date[0],
                                'compare' => '=='
                            )
                        )
                    )
                );
                $unique_instances = array();
                foreach($hits as $hit) {
                    $instance_id = get_post_meta($hit->ID, 'instance_id');
                    if(in_array($instance_id, $unique_instances) == false) {
                        array_push($unique_instances, $instance_id);
                    }
                }
                $total = count($unique_instances);

                $five_minute = get_total_at_interval("5", $date[0]);
                $ten_minute = get_total_at_interval("10", $date[0]);
                $fifteen_minute = get_total_at_interval("15", $date[0]);
                $twenty_minute = get_total_at_interval("20", $date[0]);
                $twenty_five_minute = get_total_at_interval("25", $date[0]);
                $thirty_minute = get_total_at_interval("30", $date[0]);
                $thirty_five_minute = get_total_at_interval("35", $date[0]);
                $forty_minute = get_total_at_interval("40", $date[0]);
                $forty_five_minute = get_total_at_interval("45", $date[0]);
                $fifty_minute = get_total_at_interval("50", $date[0]);
                $fifty_five_minute = get_total_at_interval("55", $date[0]);
                $sixty_minute = get_total_at_interval("60", $date[0]);
                $sixty_five_minute = get_total_at_interval("65", $date[0]);
                $seventy_minute = get_total_at_interval("70", $date[0]);
                $seventy_five_minute = get_total_at_interval("75", $date[0]);
                $eighty_minute = get_total_at_interval("80", $date[0]);
                ?>
                <div class="body_row">
                    <div class="cell"><h4><?php echo $date[0]; ?></h4></div>
                    <div class="cell"><?php echo $five_minute + $ten_minute; ?></div>
                    <div class="cell"><?php echo $fifteen_minute + $twenty_minute + $twenty_five_minute; ?></div>
                    <div class="cell"><?php echo $thirty_minute + $thirty_five_minute + $forty_minute; ?></div>
                    <div class="cell"><?php echo $forty_five_minute + $fifty_minute + $fifty_five_minute; ?></div>
                    <div class="cell"><?php echo $sixty_minute + $sixty_five_minute + $seventy_minute + $seventy_five_minute + $eighty_minute; ?></div>
                    <div class="cell"><?php echo $total; ?></div>
                    <div class="clear_float"></div>
                </div>
            <?php
            }
            ?>
        </div>
        <?php
    }

function get_total_at_interval($interval, $date) {
    $hits = get_posts(
        array(
            'post_type' => 'detected_hit',
            'posts_per_page' => -1,
            'meta_query' => array(
                // meta query takes an array of arrays, watch out for this!
                'relation' => 'AND',
                array(
                    'key'     => 'minutes',
                    'value'   => $interval,
                    'compare' => '=='
                ),
                array(
                    'key'     => 'date',
                    'value'   => $date,
                    'compare' => '=='
                )
            )
        )
    );
    return count($hits);
}

endif; // twentyfourteen_setup
add_action( 'after_setup_theme', 'twentyfourteen_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'twentyfourteen_content_width' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return array An array of WP_Post objects.
 */
function twentyfourteen_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Twenty Fourteen.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'twentyfourteen_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return bool Whether there are featured posts.
 */
function twentyfourteen_has_featured_posts() {
	return ! is_paged() && (bool) twentyfourteen_get_featured_posts();
}

/**
 * Register three Twenty Fourteen widget areas.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'Twenty_Fourteen_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional sidebar that appears on the right.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'twentyfourteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'twentyfourteen_widgets_init' );

/**
 * Register Lato Google font for Twenty Fourteen.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return string
 */
function twentyfourteen_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'twentyfourteen' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_scripts() {
	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'twentyfourteen-lato', twentyfourteen_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfourteen-style', get_stylesheet_uri(), array( 'genericons' ) );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfourteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfourteen-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'twentyfourteen-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfourteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		wp_enqueue_script( 'twentyfourteen-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
		wp_localize_script( 'twentyfourteen-slider', 'featuredSliderDefaults', array(
			'prevText' => __( 'Previous', 'twentyfourteen' ),
			'nextText' => __( 'Next', 'twentyfourteen' )
		) );
	}

	wp_enqueue_script( 'twentyfourteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20140319', true );

    //notification
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'classie', get_template_directory_uri() . '/js/classie.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'notificationFx', get_template_directory_uri() . '/js/notificationFx.js', array( 'jquery', 'modernizr' ), '', true );
    wp_enqueue_style( 'ns-style-attached', get_template_directory_uri() . '/css/ns-style-attached.css', array( 'twentyfourteen-style', 'genericons' ), '20131205' );

    // jQuery JSON Helper
    wp_enqueue_script( 'json', get_template_directory_uri() . '/js/jquery.json.js', array( 'jquery' ), '', true );
    // Chat Object
    wp_enqueue_script( 'chat', get_template_directory_uri() . '/js/chat.js', array( 'jquery' ), '', true );

    wp_enqueue_script( 'churchathome', get_template_directory_uri() . '/js/churchathome.js', array( 'jquery' ), '', true );

    //jquery countdown plugin
    wp_enqueue_script( 'countdown', get_template_directory_uri() . '/js/jquery.countdown-2.0.4/jquery.countdown.min.js', array( 'jquery' ), '', true );

    //jquery cookie plugin for hit counter
    wp_enqueue_script( 'jquery.cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array( 'jquery' ), '', true );
    // hit counter code
    wp_enqueue_script( 'detect_hit', get_template_directory_uri() . '/js/detect_hit.js', array( 'jquery', 'churchathome' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'twentyfourteen_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_admin_fonts() {
	wp_enqueue_style( 'twentyfourteen-lato', twentyfourteen_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'twentyfourteen_admin_fonts' );

if ( ! function_exists( 'twentyfourteen_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Twenty Fourteen attachment size.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'twentyfourteen_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'twentyfourteen_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, 'twentyfourteen' ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function twentyfourteen_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} else {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-2' ) )
		|| is_page_template( 'page-templates/full-width.php' )
		|| is_page_template( 'page-templates/contributors.php' )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	return $classes;
}
add_filter( 'body_class', 'twentyfourteen_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function twentyfourteen_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'twentyfourteen_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function twentyfourteen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentyfourteen' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'twentyfourteen_wp_title', 10, 2 );

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}
