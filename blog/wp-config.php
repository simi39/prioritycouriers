<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pcouriers_blog');

/** MySQL database username */
define('DB_USER', 'pcbloger');

/** MySQL database password */
define('DB_PASSWORD', '3quunCzMZaKz2bSF');

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
define('AUTH_KEY',         ')-1F>5=!+Xoc- h_}ekQ*+Lvx8Q@7&c/%d5_|H=afY3O@q7l5$Na23-Ox4Tw[g{p');
define('SECURE_AUTH_KEY',  '-@EPFF::+x1Qa2 CgmZPNPLC/+m5v2j(da|B}Z_w6}_XKgwM{E:h?DqY/ydVuu${');
define('LOGGED_IN_KEY',    'o<PLy&do>J#ma+CBkIN7kpSKt ;1;|&A=Bj>^3!9;avMCmBqC(k/0#neoTiozy1A');
define('NONCE_KEY',        'XK{BD8!p6Jx-dm.]:(Dw;TbQ}%C<{&JOR^G,+p@]bSvO4AMugQ<-Joc| Bn|GHID');
define('AUTH_SALT',        'I7Lg+/BnK-7KWy6^r`aGdwpeBs!IJ.U}Sw.bP%5(tn|.Zs+;r[Bq17BD(IwL8M-A');
define('SECURE_AUTH_SALT', 'mU4(}`<^XU~Bti`56yTl:#N%q=:PHpX@a|-:4jRT[[[(*g~|,>o%c wkFl.HsO~7');
define('LOGGED_IN_SALT',   '.%a_.iotK=FG(OQj4$Q_W?LafUb]KG74s@KrPsY>lhNOi^-zSX|>1]J)!Lu.wTV)');
define('NONCE_SALT',       '|rKH]w!mC+u4*h`s97~nP-g+|Mu%~uA^;CV|(|KgGN(Y$E;MvBWZbcpN-#`tiV.)');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
