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

define('DB_NAME', 'woocommerce');

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
define('AUTH_KEY',         ')XFJ%(#[53DZctm&NLd;z]A>`r?du(4$#Jh@@5iuss0C.zn=P}WL+F_f+(98FqA<');
define('SECURE_AUTH_KEY',  '=>Wm#|2:Vr7`;+^`]G<m*-jn1E>$SO#KrUV7%ahHznK$o uM34 _fE{S#4oz2s6l');
define('LOGGED_IN_KEY',    ']P*E!>X)Oo~Gw4!Uva`z}E/NypA9S.e$Rr`U|;!@QpSzbY}Bj.e-USK^[cl$09*]');
define('NONCE_KEY',        '7*hYfTm^gC.Mv$}TbJsF%{et#HX`:]/ 2wTua68IAAeY6]N)1v]}BoT7e~$TF0M_');
define('AUTH_SALT',        '3X2HS7ba6{V``U=(,xBU{:Za2!iVuTxXM$*aycLe.4Z?/:Tdmcv4c4~bn hc{J5T');
define('SECURE_AUTH_SALT', 'DUb?Qmlpd/Lrk,0]Px}A+Al>@ZewlM $@?Y%R<_=5wR|cuo>%b_)d]hwd6%R c-+');
define('LOGGED_IN_SALT',   'KDJ(aDm2:9E60+jfQB1sjhK%9B-OT6JOL-lJFLdW.GX)2$+7lhZ,dRUk1+2n;Q]T');
define('NONCE_SALT',       'U|q90H_]VCT979$kgax)T`tYlK2M[_6qOsKHFDB[MEe<0rupPW7pu.m 3JFDi3s;');

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
