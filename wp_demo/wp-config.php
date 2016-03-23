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
define('DB_NAME', 'wp_demo');

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
define('AUTH_KEY',         'S|6 P+Dcc|csJ*z>[&M^hG.N.Vg)fY/z*V=U=9~EkNV=@7_ssO#<7g`!206=OFz)');
define('SECURE_AUTH_KEY',  'pjyBv63*;j>Ok/.gZA=s6{G/wG&}u/5}U{EZz1p=tAArtc3i)&}LhBayR&D0&|kp');
define('LOGGED_IN_KEY',    '91! FSxJndnv=N~0$iJ7<*@/uGr_<bIR@T)].M;y,eAN:{;!,N)L,}iIYi[O)ryW');
define('NONCE_KEY',        'TjR7>0`% Q~8g%{@sD?,z$};kvn`LK2h2cRR/Ir&p%:pC+%cF`PMbC^E,ZT/:#}p');
define('AUTH_SALT',        '&k1Vni/L%;~<)7Fm`Q>[b4|*~}SghJKTaEzR~i+:x93}]`s= #F997|D{pa7k^{9');
define('SECURE_AUTH_SALT', '6E)_}[P{%u* nPuv{q-4s}[.7Y<{.TFq@f7UZ[9&IJrbWVvHz+V{]s2rLV{x,CcZ');
define('LOGGED_IN_SALT',   ' 9kHPYcS}KTo3<-rWu#/l$-yq1-!$k=][Mz_`zy3QS#FvVRB,`/5#kuZ4^Tf?Ur^');
define('NONCE_SALT',       'jL)P._&#i|T^gCse)*_d:hp%+~5DDl#hI.;?n]VI!sU{MY#{m8xT@y^*DCNC?q*w');

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
