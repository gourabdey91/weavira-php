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
define( 'AUTH_KEY',          'dehCOI!pIGZ*X8H1A-vS kmAXE^sPJdB8vBu5sf3-MJ*tiv68-As+f0_kiu3}WvV' );
define( 'SECURE_AUTH_KEY',   'a[3BtJQ@<lG%?&dS)gJl~&<?emYi3a6&A1tiN=fl;9<UE4/NY4+Cbt|o he7VXQ^' );
define( 'LOGGED_IN_KEY',     'K[~C!$h$~[kf}9iw*<Q0)~@d&M2:[9=ig#KA}7*<; Ijc=&jD:{k)mR5ezqJIRVS' );
define( 'NONCE_KEY',         'd3c8D|mvp.L>@G2F]lJazw*^;]N+Nso[CT>dl3F[^cs$R}!G~3u(nQJTtl>*Oz_{' );
define( 'AUTH_SALT',         'm38KHb/vt-XA=C|YuC#%I*!H)+AW]>,H].*~ZxZ:iw&mghq4+F?j$zw%B=>vxN2<' );
define( 'SECURE_AUTH_SALT',  'vXRW^@hk*LkyLSKYX41v!nb!&q>VT]K+arpMI;IBNB*j:x$L%m/b/}t,.]-^O52&' );
define( 'LOGGED_IN_SALT',    'L4ixW@5*F4iRh*ExY?sk2wTT;P^Ons{$9rUI4(e)A3|i>QKt[S*:J[0f4|_RBk@I' );
define( 'NONCE_SALT',        'cu{=s:V2eruCK;~n:m1B*ibFLZ)b%_hGJ)L8;|S)^N}*2~YyG<-y$ZhmqJxrWmjm' );
define( 'WP_CACHE_KEY_SALT', '5=)zS$F6jM 1:nJ~phc2k+Y0(zcUt8)*Lpto@~[*^bGq&v3q>sws)WqrFI^fCm04' );


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
