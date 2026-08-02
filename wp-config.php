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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'j50M$f<w:3!Q<_{%=rX]Sg6XWtI=ciAL1^]B$hh{(z3;``f{u4dYwK!UTKOxP*w!' );
define( 'SECURE_AUTH_KEY',   'E[vgRzY5UoDdbZKV]l6?@ n9|d*,RFA731CK4e`tc?A}bVzX@6,dkW;TEktClxB<' );
define( 'LOGGED_IN_KEY',     '9UBuUU-&4z7*4<gpYjL1XO{6|&,x#g+viA6fl$yn_Nbfw]c)_~/ZRae|}dh+oR}l' );
define( 'NONCE_KEY',         '(@2bX>.GKp+S0N?EPT?rfG[9-.@wBBKm=^QrV;#YfN<{F}$1LG P @HBz7k..[J,' );
define( 'AUTH_SALT',         'g@^nPT[i`OmKMgAYFxIjmn]!B}-<!#v0/uDcMNm71bK?dE|}_Pbs?$Q=5$|:fj8E' );
define( 'SECURE_AUTH_SALT',  'bSe&:CbvIg`Xe0/wN/9us.@peI/eSXx.i4Q/:AXc(]Iz(Kv$cZk2Z+/SvP3`Uxib' );
define( 'LOGGED_IN_SALT',    'MDAVGUXV$vMjboLgg$~&`UxK-U!;p73D-D$^3 ^P3B2/X=lfJO>!]T>jWlI=nU3>' );
define( 'NONCE_SALT',        'up@/xEBh-Fj*,Jt.5`fi^2EI6YnuqA:Kf`R<oR#W&+Svd1HD)3`o-SfoWhb#I8SV' );
define( 'WP_CACHE_KEY_SALT', '.14ynQ~ll3bzBbI}vy}]s2@^gZm|oW/m`TGfJKM{SVk^czs^i7lCIcMy+vyc1I+V' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
