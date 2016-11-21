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
define('DB_NAME', 'wordpress_2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '#!3t,R)~ qAKiv>uQw1TTge9y|R:hj+1{cy<K)&z_^UNki|wxHq&I0E%B]93LqGl');
define('SECURE_AUTH_KEY',  'djX}i]y4Q1O-0i]<yj)(LwNlpZ^0>P0O]sFVHv=%&-I0YcI]H[L7i^CUfX>c]Wls');
define('LOGGED_IN_KEY',    '(K.Lv|KMbM8_<[B96zpmop@2X[oPVESEKuPuxv|Ke!8vH c/yd9C LK1{l!{?>+5');
define('NONCE_KEY',        'oc7bC@i<$uctZ5_]2GXJ-1B^JALF)WN3>2E@a6TR<TO$}(R*NY}L+AVw{ =N%cj0');
define('AUTH_SALT',        ',Fe:@91=X;E;tQ0/q%TFbt^UMy8$X#uM&Ea^QdI$Bis2Gq caK1)Q^0bJ2GJPz4#');
define('SECURE_AUTH_SALT', ']PC,oUdFzpi@K7{y/+D(&#W-9yWr^EhY}KX r;(eAZ4{|/Mxpy;.K[@m~c#Aaoe ');
define('LOGGED_IN_SALT',   'T>jnyI3>NJ#cb3IkWg6 %n-:WoKU5tAA*vJ)5w<^pF}1@}lz}!]z(m9`X,CpxS$#');
define('NONCE_SALT',       'u{9$Rx6{I]_1pyQBCA#$Y`f)jeB8u4U O>w#+B&;Yb(7z6GW_VaX4~-z@T.&m6`_');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
