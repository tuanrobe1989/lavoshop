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
define( 'DB_NAME', 'shynh_house' );

/** MySQL database username */
define( 'DB_USER', 'shynh_housew' );

/** MySQL database password */
define( 'DB_PASSWORD', 'nKWgl2Wp@#$' );

/** MySQL hostname */
define( 'DB_HOST', '103.130.218.110' );

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
define( 'AUTH_KEY',         'n*V|aT1d*%)+c@So<!.@dG,/Hg0n#@e#&_-^nRan*%?Rkb7#qnDK%To==, ac3x]' );
define( 'SECURE_AUTH_KEY',  'PzfDIH{lJJz?~nb]I/jc9RZI}9e!M<c)GRZjcfBb3e#T(r:HHi=e/f 9[a>Yi* %' );
define( 'LOGGED_IN_KEY',    '?(ICU%hj4(U^}%P!DmlfjP)={y~E,rWDCe4`3-bfLx&Bm{8T+{A1?ofF|w||Phg0' );
define( 'NONCE_KEY',        '+jc/I6,|~zLv#AOO54H=&aY]o#/Zn)U8s[#A&^ ELp;F5aV1bd_:@KGDm4,W(y`O' );
define( 'AUTH_SALT',        '[w8boP0DL1:C2Pu5Ys=|x~cN)B:dZm.#^%@uBK+1v);cwN0-f-}~YM DEcH&jfUK' );
define( 'SECURE_AUTH_SALT', 'X*u G* yOHb}>l(I|AbOZQ/Q;VO&?)mGd@*G/WJ.*Pz)[}oj_@&rrvv)-Xq&(M,H' );
define( 'LOGGED_IN_SALT',   'C?hUI7[xos_Jwq3{m&IKG&O9,JKNh0/{=0=C8m*UOeCVyT~|Hk*)h)(Ck#3|9!i.' );
define( 'NONCE_SALT',       'U_Szsy]O=/@98VUMr^eZ-_mR9Eb_:Y|~lEQ@OE2%DOB#C@-m-538}lhgH/susTg.' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'lvsh_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
