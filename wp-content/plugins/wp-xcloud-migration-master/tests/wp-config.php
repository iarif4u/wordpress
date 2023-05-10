<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
define('ABSPATH', dirname(dirname(__FILE__)).'/wordpress/');

/*
 * Path to the theme to test with.
 *
 * The 'default' theme is symlinked from test/phpunit/data/themedir1/default into
 * the themes directory of the WordPress installation defined above.
 */
define('WP_DEFAULT_THEME', 'default');

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );

// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );

// Test with WordPress debug mode (default).
define('WP_DEBUG', true);

// ** MySQL settings ** //

// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.

// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.

define('DB_NAME', getenv('WP_DB_NAME') ?: 'wp_phpunit_tests');
define('DB_USER', getenv('WP_DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('WP_DB_PASS') ?: '');
define('DB_HOST', getenv('WP_DB_HOST') ?: '127.0.0.1');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define('AUTH_KEY', 'z6cYu]1$?3-j9I?w>L4P_R{qQtE!8sUIB#aQWRRk-t7-~n)zw#>(1!S;~2-p//Se');
define('SECURE_AUTH_KEY', 'lOb1qnZ}K(k- WcP_/=H8|AYsz<OB#QXv(&3f_D@VGEvdNRgcAGz-,&^djx~+)_V');
define('LOGGED_IN_KEY', 'Q$lDZadVT`Rb|](+A,KyH-d%9h53cf-nxW&hy~l[-sP55!ojh%a|QcWzOH]H_oY8');
define('NONCE_KEY', 'n]t&2r{J*CBr~Gk~wbF|J3Ww&t.$ <:n05f0jR~ip^4W%dPA-NIjdQu*4=^22cU5');
define('AUTH_SALT', 'i6,[ukoa{;W83j{qCyd+:+v^oyO=cd8pkqd-m?>J}n=L/0[5TU~%prW<qF,mutJm');
define('SECURE_AUTH_SALT', 'Ivapwa|O8?uyox7hID{O`WoTFQhi}RV[m:;JRH4zEsx+w:zU-+MW#SFI#_kpKjdn');
define('LOGGED_IN_SALT', '6/@./)B~?Kg^k?[K0-W%RT+N,d2Y9SN<+]x-aS/mVi1+F;|-!x{wL0R-q4NNX{Qt');
define('NONCE_SALT', '>(`TbU.vbLFDU5</)-v[DUag@=%B4o|edIj0Q)HoG#Dt+wkDbn>k1%DpF5hec?I[');

$table_prefix = 'wpphpunittests_';   // Only numbers, letters, and underscores please!

define('WP_TESTS_DOMAIN', 'example.org');
define('WP_TESTS_EMAIL', 'admin@example.org');
define('WP_TESTS_TITLE', 'Test Blog');

define('WP_PHP_BINARY', 'php');

define('WPLANG', '');
