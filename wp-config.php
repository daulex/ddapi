<?php

define( 'DB_NAME', 'ddapi' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define('JWT_AUTH_CORS_ENABLE', true);
define('JWT_AUTH_SECRET_KEY', '-NJGrHG&YUYmE6Y,8<JPhpV]zO+rY1CBFnI#v$fiHhou');

define('AUTH_KEY',         '_-s8Z)-NJGrHG&YUYmE6Y,8<JPhpV]zO+rY1CBFnI#v$fiHhouoE-t(}_>De?B)Y');
define('SECURE_AUTH_KEY',  '82Y-Ma-=Tf%ri-,,bxa~jggo=c0WR!KiIzs^0EwD|lfc@.<2]vy_P;V7+|v5fIUH');
define('LOGGED_IN_KEY',    '_xBx2-trK`sDS$nlb3>-X?h]M7id_JUw%Gi@H-Cg=9kjAVYAEBzRdj+k-*si4L+D');
define('NONCE_KEY',        '&9ktJ6BTXpp$<#Otxn/rR-SKUT n7ZOzCx<MFr$9-83CjszhgiYIy[Q0Z@L,Emv<');
define('AUTH_SALT',        'O>B.EMHXyjy<+Yl&RWxviTzQmwj{diOAJ-poI~4r^F8?,HWq@-<_r`Wr?G^?2>0y');
define('SECURE_AUTH_SALT', '$3&|sUQp}pUe3 Op6JWYApw|iyT-k*eCvG$slT]6x&il;J->wOo_u`tF3,{p$$+ ');
define('LOGGED_IN_SALT',   'r4MOBYR>BAf)!Z++=f-G6e|4vl 6$,-$?6yP:%O@+8]zbvp6jH@|Zb/a`sTYOE}d');
define('NONCE_SALT',       '}Pel+E:t_9J?^q-q(OeD=yqOVui[:e}901sKn--h*(rO yucGI<>$o8w}7T$#rZ}');

$table_prefix = 'wp_';


define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
