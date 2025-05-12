<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'car' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '_2LknC2YBr,{FO%nwa%(}rzx#f$oNN6R]jc,yM(&7AA<_kh_a=Z:/ErJY|&pCP0`' );
define( 'SECURE_AUTH_KEY',  '7!+rRYLH{zi01/5IAn=B?(]1W^h^FySwLe#Ca=bgbXjd,^K@_)Ck9pa}ubP2mKYG' );
define( 'LOGGED_IN_KEY',    '+mP<Q]%.J%$ULa/z}$ >`B/ww)i_[WKLeTT{z=|gAj`:Fb9g(51!)d5^H#%%;D<Z' );
define( 'NONCE_KEY',        '=Q=/KO/tc[XMVFU*`}UYD:pww=`=pvOUKg}_;^*wUhy=_k,c3l8ec@23PcO0I[1,' );
define( 'AUTH_SALT',        '[u8~}SYm`^pUu6szcSJ4u*L.5D?i8b? .E4XYLGuWb.=TD[19JV%L*U`C1CNlb90' );
define( 'SECURE_AUTH_SALT', '8=SOufV,F)!b<g1>x*TI;Z9=):n8YKjN9xu]TWzV9%ujV2#V3Z``RgGGN8:Zl2q6' );
define( 'LOGGED_IN_SALT',   'BCj;cm0|^gJUT]kr*Cd)jKbI2F7NZ=nzEOJ,8-q%WVJ:xCs;M@<G{u8B4HWF`SIC' );
define( 'NONCE_SALT',       '`fBqe;~Kj8_;qi0Bpn;X8Aq>xB35^x&daPG3_K;shvk?zgQs&M@i^U*!/POo#Gt!' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
