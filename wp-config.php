<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 's_scenic_dawn' );

/** Database username */
define( 'DB_USER', 'u_scenic_dawn' );

/** Database password */
define( 'DB_PASSWORD', 'Apc6vzWD3ZjTbE9' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'NnME7kz7IQU]$*@()nj6IH0#Xd{RMpftWFI$fK5AD$GQXg0{3<@6WMU5T}ZCD6 i' );
define( 'SECURE_AUTH_KEY',  'Fs#/t1Q 8>@nXS#W]`N0JK&`w#,9ba;O6kUY*9fmHwMpZE@tkgH<0[OmWL/Er+hg' );
define( 'LOGGED_IN_KEY',    'TH G!6 _B`yU?q?8o}%}`~mVu^Z:fEGsUMy7Pg;D(6E2yFG~LrAxk9!QAo_o+I+O' );
define( 'NONCE_KEY',        ';0 5S^95?2^J3 @!)5}39X~R aRk=12X4{cwh/6-2f*y/oYSf+PM.nU@5v6/BQ9,' );
define( 'AUTH_SALT',        'h/?7y}ODQ1CKFctCI[5G=?>EE<eT-{dE=^H[Uo*FQ)m]gtXpB%+#fI}!Lf/Kj0N9' );
define( 'SECURE_AUTH_SALT', '/2*a2h5{sB~{MuwL>JMlE8Ls 3Pnf<9k;!5Ee;W*KwT)HFDEx5~Hh~e<YA>s3m&^' );
define( 'LOGGED_IN_SALT',   'ED#F27:9~Ut#*Ern7V2o?SlqC#Fa74ClaNTT{EAr6$E^/OVE3su3pSJnMcUk_&[.' );
define( 'NONCE_SALT',       ' ]a:ZW Zj&w<Y jeS/1a<)%vCL^u!(y,%}?]q@1KSDC`pJt*xE>M)}~~|SMoWf]#' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
