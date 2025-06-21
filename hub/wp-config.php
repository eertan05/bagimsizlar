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
define( 'DB_NAME', 'amberpla_bgmszlreewp' );

/** Database username */
define( 'DB_USER', 'amberpla_eertan' );

/** Database password */
define( 'DB_PASSWORD', '4mb3rPl4tf0rm' );

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
define( 'AUTH_KEY',         'vxa/7?L@Lk1T(X|FaQN Mg+rR9a$Mq<6]VN1_9;22W]e$`>$p&Z1_;hJ,r!{`:7_' );
define( 'SECURE_AUTH_KEY',  'R~Y?j?f`IQ?y8LF%z{]0)+BT%>teXxDQY  I1!L]9O54?K.Ls[EBcby>@yad)GI^' );
define( 'LOGGED_IN_KEY',    '>dS;2k(h;d#Bd5hgDBazZjSu0vl?z`yn(3itT=BCK-6nFiI8:rmV@VQ]+?px@]lT' );
define( 'NONCE_KEY',        'HJ/Oa4qo81u;2:221vUJswFq7irsgCY!od:j%UCXu]c7W+#(G;2om-|tF|)hzE-s' );
define( 'AUTH_SALT',        'Vjj}}:1C |h{}*:X{1Cx>pQ*s2U^Fwj LLdRe! /#`z3Gx6u3<-ZvL5Cn$=DP=Q;' );
define( 'SECURE_AUTH_SALT', 'CG9q4.D.9y^$NU$0KZ>OiC*P,n3=ezxn6|tnX{)V=rkX`K:p)83x)>k/pIH?2DQx' );
define( 'LOGGED_IN_SALT',   'Ox1[_ @T6<^~*2*Zo&j4(C[kU,[La{5J=XJ4A KMXUL*TpM)(OO^EYvy}<w;5PZT' );
define( 'NONCE_SALT',       'YYU89I%aY{2ikzFUW]iW]y7xjgVCLBI4J#^2C<B19G]<iL-fQK1m&uKoC?^15sEN' );

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
