<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'video_org');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'Dv2nV+0y5?^kD#t3^K?*oK;|[ywr%h(1/+Z T&cqb?`x7@gpvbrN%NS2t9kWUOXv');
define('SECURE_AUTH_KEY',  'lpUk, Qw]X!!y!*`V~|X$]-,@f,iIA/dH3|!mxk>1?F^EM&kJk+iZrv2<J<C0+M ');
define('LOGGED_IN_KEY',    'H~,|%*MR#(R{<1%Vi6IS]O0:GTN]I8a!ruGhod/> SjNdz|o Zg!%naS:eWC^1Nt');
define('NONCE_KEY',        '{Y~-0= Gf-[K8s9w2vpn>IZFdkkQeqznW-VG9,bT`%WWcO>8}>)z!_W-5hfz`Q3b');
define('AUTH_SALT',        '[@$w-mYNsf0n5rR+lQC+<aKVIrDUZ87RKSgA5LM,@4$2#yM6O-?&//Wo&Texh+h1');
define('SECURE_AUTH_SALT', '#Pn^H.4gK Tul1c%[ZD8r;mX,-.S+;X2TbtrQ9k{FNx#|m:JPXZ%frS|sNnPQdHY');
define('LOGGED_IN_SALT',   '6iTgR6`L&[9hPj#~L,lIoe$)|-GaU7[$eS_QKi>dH~pWlT9-+=v^b>^deNs$l{[|');
define('NONCE_SALT',       'NyW%_c|bse_g1DQ+N@P.8m+)ZXN&.naZ-tQT4,WMg`S+PO9JeoB<*=zTU}qg[xm{');

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
