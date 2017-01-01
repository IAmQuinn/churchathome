<?php

if( strstr( $_SERVER['SERVER_NAME'] , '192.168' ) || strstr( $_SERVER['SERVER_NAME'] , 'local.ldm.ca' ) )
    define( 'DEPLOYMENT_ENVIRONMENT' , 'local' );
if( strstr( $_SERVER['SERVER_NAME'] , 'client.ldm.ca' ) || strstr( $_SERVER['SERVER_NAME'] , 'preview.ldm.ca' ) )
    define( 'DEPLOYMENT_ENVIRONMENT' , 'staging' );
else
    define( 'DEPLOYMENT_ENVIRONMENT' , 'production' );


switch( DEPLOYMENT_ENVIRONMENT ) {
    case 'local':
        
        define('DB_NAME', 'churchathome');
        define('DB_USER', 'cah_user');
        define('DB_PASSWORD', 'cah_data');
        define('DB_HOST', 'localhost');
        break;

    case 'staging':
        define('DB_NAME', 'churchathome');
        define('DB_USER', 'Q3Pdg2V5J7JPT');
        define('DB_PASSWORD', 'ZV2KSVFLvE2EZL8oi');
        define('DB_HOST', 'localhost');
        break;

    default:
        define('DB_NAME', 'forward_churchathome'); // forward_churchathome churchathome_live
        define('DB_USER', 'churchathome'); // 0e99b80257fa
        define('DB_PASSWORD', 'Church@h0me_db'); // e62d905852c92fa0
        define('DB_HOST', 'localhost'); // localhost
        break;
}


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
