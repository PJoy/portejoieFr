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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         ':ZXVG$52yI7QWPn0CmK/wQ*|&B=]#+aFbDwW877%T=(x;%|)b}z!BJ}OUx^m4h`N');
define('SECURE_AUTH_KEY',  'hK5@kGO:+S;/BNIhX3^Ob3hgdLma&UzaJT*AU#t${vmtchdW5khKYY`QA?6-TR-7');
define('LOGGED_IN_KEY',    '+zWSS0jjXoAh[7KWT6@w8vmoOB/EH%Ep3,q9?+-^REg*<,dLx9)]+qX-C_ebdVs&');
define('NONCE_KEY',        '3WZZ;#5rNtPvD[|aVKZW6OXL;q|F.OmBaq 4^aoHn!Q25xWTqhT=g@?4DO]ExHw;');
define('AUTH_SALT',        'A&!|N6xo9B!GM_XGEzG(}:}sXv%hNxb U^)f6;[TRJ&i.}A$]-U38eEd3Gz<Fr|F');
define('SECURE_AUTH_SALT', '2)|~.8hijf,F.:W+qC[GnmeGZq./4c(ZF+.Q<N(6CQW=pHyfm L;,OtqAdtzX+f&');
define('LOGGED_IN_SALT',   '+&=j<m4?~%eIMaykB+{j*{l;&JFt]6Lyc*]tq#_PH+C:kZrF6,hk%^@Mn13UU7JW');
define('NONCE_SALT',       ' =M#jymB#@[Wt|k:OVii+GEa%/OCAr)`O3=H&HP)-a|S!L:2f>9NP?Bf]nSm?N<M');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_pp_';

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
