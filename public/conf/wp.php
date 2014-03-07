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

define('APP_ROOT', dirname(__DIR__));
define('WP_HOME', 'http://dev.freiestheater.at');
define('WP_SITEURL', WP_HOME . '/site/');
define('WP_CONTENT_DIR', APP_ROOT . '/content/');
define('WP_CONTENT_URL',  WP_HOME. '/content');
define('WP_PLUGIN_DIR',  APP_ROOT. '/content/plugins');
define('WP_PLUGIN_URL',  WP_HOME. '/content/plugins');
define('PLUGINDIR',  APP_ROOT. '/content/plugins');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dev.freiestheater.at');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '<Fy$qin_q|F+q`Uz0M!!9|KV|;Y2^9=5mJJ+ ot+QP TujCS3={RNj-K`sDA5k`o');
define('SECURE_AUTH_KEY',  'Z*y8D>z%[l:]4X*Yyw |9D4D|{HqNHItFE8b[N.]!}ucSaS9uzE]]}};7EB.]M< ');
define('LOGGED_IN_KEY',    '.,;2t}9}9pF&+$4dBzG >7t~)+Z!kDChfKuan-v >wW+l  X[(rp{7`0[{#TyxY,');
define('NONCE_KEY',        'e`lmdQnGu3YF]OkC]~?:89/:31{xgzN_7|+FxQ7|$H*1+%|AZ1TdmbS<4e1fe $f');
define('AUTH_SALT',        '|~s^>J/gp3&:$I!o|Wb3tTLyN]9+#5k[C5$^WKG>*`DwPvB0t0(|lbS|KUT@IO *');
define('SECURE_AUTH_SALT', 'f9/U%#o-aP!^--oL{) x?)U>M!@#szvzuUJ}iaBgoVu#?0d yQ7 3oPWS+jS!Jey');
define('LOGGED_IN_SALT',   'k?Y 3t@FIBD9Rx<4TTOb9a%Ycj&3Pa5TE:M.}3o]x_0AX&)nOTDh.F{Be(#oG>&a');
define('NONCE_SALT',       '~*ZHK.4O%YgK)T2Zci8gYm=LuQu)q,UVs`J@ZKV3%Uga)<~#Io,Dc15(y)`l&6>P');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ftwp_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

