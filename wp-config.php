<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_test' );

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
define( 'AUTH_KEY',         'cn%R**82OHu(igU=Rg2Q5S``?h3ga-j+KZe5o@[wLJGRyX,_>kl{8-c8z;:EUa6h' );
define( 'SECURE_AUTH_KEY',  'BjR+2 NwUK-L)$dE}o-B}}}&?O,Ro,X%bzB]KS6l1!w9PEn;quX=Gv;b^i9~!9pI' );
define( 'LOGGED_IN_KEY',    'K>j}|s`@DKFAL*)0263~5Wdz}EJ<sl~QK60MM0GTqr NH(wfQX0|$%.C9o=Db8=>' );
define( 'NONCE_KEY',        '{?<33d9AslO9&hNw_]unU%IGfeA?4kuQ0_%nkE<%vN?cZZ*.DD>[m4t[GIko-4%^' );
define( 'AUTH_SALT',        'D`g)KA1SH[ByY<Wc:eY+L sDT)PId97bz#AgQVFeUl`I#3~O+Dep2hp;u8!7Qx3m' );
define( 'SECURE_AUTH_SALT', 'R~TM%mry.<bRc%aUFG]$UCRe|*|oW:jSf4vrr)b8,_DK.%q8Dv-fr*=$OgtLm*0-' );
define( 'LOGGED_IN_SALT',   'P1 `.iE`FM#{;wJT@4IzN8=R`LFJz+f}mdk_WD3>th;6heUPZ,?(G/P_@[TRk5r]' );
define( 'NONCE_SALT',       'oVm~Sp&dt=Sh[3AFujHUa2]}QBtHBREU+{0Sbe*Z G~d32lf4iaNbwLMBy4sS>5f' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
