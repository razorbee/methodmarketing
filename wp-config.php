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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'methodmarketing' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'o)Z2q)m.ApN8 LGcl:Yk_)Ii,@1qN[Z:[h0:pfc3tt(s*=w9ktx6?3{{AxkpiV&3' );
define( 'SECURE_AUTH_KEY',  '&GjrA.;v{J[62];~ulW>aoTLvl?V+HD*Z45F1IkvG,!G}gh2i:im=]a5qoFzb!UY' );
define( 'LOGGED_IN_KEY',    '&2mA(8Xnpq)tWpf%`a6H-TYqa%M?y))%(I|HG~?O6n9Hb[thlBL%Y89uWv}Z_5*y' );
define( 'NONCE_KEY',        'NH9r.YC9pm<9wc^M>6taK4@5;ti8Wx1>O|TNy[;PdATi|T6^3a:elVM8)aE5OQo+' );
define( 'AUTH_SALT',        'T6qZGgXoPZRm]hB%863UR5ylb*%+77nHsHT3*7iI^/&Y<LqAn4C70UfU!T^mn>wI' );
define( 'SECURE_AUTH_SALT', 'IF`uWPEzP}If6Q}3scD>sm~Sz$kHdzAEI}wCyHR[P-Mt$s`2}j;{bW.]6]ispR*L' );
define( 'LOGGED_IN_SALT',   'Y^N-2 O`wUPIF@,WB$d6zWf<>sxxJb`$Do w&|R}Eo9ejdi6Y=w`h`3>$NN=X=h3' );
define( 'NONCE_SALT',       'DF-~5In5t4*9q11fF]I/hkGqzw;>mS_;jx1/604`FL!*_Fr HA4f?kT@)D|ftyYQ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
