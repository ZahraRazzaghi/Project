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
define('DB_NAME', 'rss');

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
define('AUTH_KEY',         'e/V!]?+/s8|MYw5f=jL=86g@WesZT/c5z{o@5nSn(a^jWAyZ{J>E~yMzF4L5@|.a');
define('SECURE_AUTH_KEY',  'M=aVqdKe2)X^ot7tJkt#I|cb~v>VT-h3fIMdt+HiQ|B>R%)X!3JyNCzT}q3Y)m;h');
define('LOGGED_IN_KEY',    'wlAPQh%pj_rm3aJR%AMQAQv2v`+L^!ebKjAEW]Pi^:nItn<}yxwtDdd0&+ `>k0J');
define('NONCE_KEY',        'tD8=ZZ+9z_7d=U&2W*<9(^ d:b%Zk.z:-H%6DnbQ.G@uZY^,<h{2J9E{|>!B6N O');
define('AUTH_SALT',        'sWG#hm67 IDyjy$@KHVdP=xFxCxfZ)0WDDgIfZi;6ZGY1xWIJdJa}=K~~tm Y2oO');
define('SECURE_AUTH_SALT', 'H:wH9kIkozFvRoO4=d$eG<|;4Mb129)=CgD?cJDe&<R)q!YZfGu#-5h#/5L((Q/X');
define('LOGGED_IN_SALT',   'Y9?+[T(Pa/B|C54Zzb:vaM{A{Pc8L2,H, ITOhXFt%4:(@5|wdWkeYK4SV*wFS]t');
define('NONCE_SALT',       '1eN-1W* b}y-1-8D}(K5,gd(A4fTV]T%lE.3|y43WfZ7UfwNx_{!sWe)g+>vA@<l');

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
