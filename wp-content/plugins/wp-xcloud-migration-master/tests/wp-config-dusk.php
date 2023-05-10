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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_phpunit_tests' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

// define('WP_TESTS_DOMAIN', 'example.org');
// define('WP_TESTS_EMAIL', 'admin@example.org');
// define('WP_TESTS_TITLE', 'Test Blog');
// define('WP_PHP_BINARY', 'php');
// define('WPLANG', '');


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
define( 'AUTH_KEY',         ')%n>Zx8C@8<nY01}zDd:poi#Y8fP-gWjM[tAjZ[c,2Iqb0sTT:(BYhMbyYu`@zq8' );
define( 'SECURE_AUTH_KEY',  'A@H~SFXL<lJ=91KIx]gGK]tOha>SfaD+riR[Jc ^KClDN)/c8q3h6A3fk n(1#+s' );
define( 'LOGGED_IN_KEY',    '&O&C*[x=#;W!w#$heivO950iE>U<$XIs:j6{?4(jLjw..b|R2Q/{T?,[G>4~Znax' );
define( 'NONCE_KEY',        '_Q(JVfjEww/T$A&CC)NGeGXZ`dWa7_OL!u%dY5Hrs~@Y4U]$c!1soWj}Qr-{.Vw6' );
define( 'AUTH_SALT',        '#kJ2U<o{;0lx2-Bx$J!YUM4T$un7m1J_3J*s_)M`|o%>SlW(8I}~pU~_b`WlbH|i' );
define( 'SECURE_AUTH_SALT', ')l6;4igB,cGBf&YImuC4/#x| :uau!O?yE]d |3i#0=fXxD{[vjCHq_~?QO:u^?n' );
define( 'LOGGED_IN_SALT',   'WnE7[GE|0zr5Uw?tF?N,bg=RWX9AP:ROY{v)v$4s+C~El&CRpLVfqGSO1QB}.K?|' );
define( 'NONCE_SALT',       'dlyzszZdrl&Z4YC@d|r,!>Z~@CO+[-EXA|X9#a*hKfKEen!A*BB&+<yb!3)4*-q3' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpphpunittests_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

/* Add any custom values between this line and the "stop editing" line. */


define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', '/tmp/wp-errors.log' );
define( 'WP_DEBUG_DISPLAY', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
