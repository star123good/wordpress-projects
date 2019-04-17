<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dbs29719' );

/** MySQL database username */
define( 'DB_USER', 'dbu65667' );

/** MySQL database password */
define( 'DB_PASSWORD', '6BDjuPz@hae^RqD?' );

/** MySQL hostname */
define( 'DB_HOST', 'db5000034651.hosting-data.io' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '4N66ty0@XT^J@fZ9Nz`p}t_R)zgCIh;=W5QpqTL.}r9)lms_VywaVW>IpQ=K+Gb@' );
define( 'SECURE_AUTH_KEY',  'XJ=_y@|zX+/=|a2[}#=Sk{pYJ`zGrs<<e%bA~CQJ<I`&:b.9Nr1[ED@hxr-7@y<k' );
define( 'LOGGED_IN_KEY',    '<l2U9Qfl%.B~`?_Ab@P>?Dpt~ugI@WqqAfzw<-@h*jCNL+hnHRs(}Qn%(P%0GU0d' );
define( 'NONCE_KEY',        '#ubyB03[ru^)O0*oUFLpw10:nZjAl)F+{x8bUZi* *xDo5NAc$M+[%> #mED-9Dh' );
define( 'AUTH_SALT',        '#&vDdhIE:m,v@]f2+nvSJw|hF(w:4#HKLiEY5Kh$S/-}/2@}ikp}=pE9Iew5R}id' );
define( 'SECURE_AUTH_SALT', 'eErns3Wdq(<AaX-.d8~JM&8? yrI#!_y|Cdia4xzt4p Dq9:kR{C<HW*{BXM+;aT' );
define( 'LOGGED_IN_SALT',   'D[yp5Om5@^34&L%%?CD:+G(jrGeCCD$uz+/{C?M4-q8J>1Afln=7MY4LQ9MsXLu3' );
define( 'NONCE_SALT',       'uvSE[BugE<0bU6U7AQgNA4NEsG,*_3g!]TrtF?@^7`GA=@:vY J2aK]o/.M=HCyN' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
