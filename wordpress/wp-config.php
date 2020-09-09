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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'prueba' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'nuh18D+uv4Ya=q 37@31m.4wf^C<TOIfv&yKj|:U4oF:OtJCpav1Ai0* @_R/#l8' );
define( 'SECURE_AUTH_KEY',  'GZkx*28SUO[+G(xuar$LfTB>{n3: ~Q?f/u(kO-gf~FXZDb@Q*?!WsV%(JqA92[g' );
define( 'LOGGED_IN_KEY',    '^}b@k8WS^fK{pd/F=zG$ccBMyP/Z&=}&0#)Vpk>~qt]Hh>foKYvlhhD(}xTC5lYI' );
define( 'NONCE_KEY',        'Ji<rhFmIL?{ihk6>(,ausH|5,//iR,9%}f%XBS[@0=0;,XB}%BU:[Cbmfk^N4Z%,' );
define( 'AUTH_SALT',        '1;a_^N]r2q.rO|[~>`a;.RSK|HJ8_!wLR0I}c`_op{T_n;}V^2|,!9osVQ{HptS2' );
define( 'SECURE_AUTH_SALT', 'JYcLi6n/m553iHrr<b)cYhTam~B^ DSBMH@nh;[T$MRYw?9DiGx=>J{_in qbPs,' );
define( 'LOGGED_IN_SALT',   'VRSH!PLLB?[307^wI~tc*iBy$?~FPLr]=X:SW}<1?|-u6[0sky]_q8Y/iCJ:yY8L' );
define( 'NONCE_SALT',       'HH9;sLcm6v6BPTbs~huU^J{m^i}`?~,svwb+Z9$%(Mg[&=!DNFQ=w{7f{08M{ C7' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
