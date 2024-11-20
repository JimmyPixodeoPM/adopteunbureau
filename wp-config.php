<?php

define( 'ITSEC_ENCRYPTION_KEY', 'NiAgOzNBJV9vRHU4fDpgSXgyfUcwWDZNOU03RiBpREp2P2g4UHRGXU9UW3lBN3JWSzx9OC94ZC1OQiVPLFhzPw==' );
define( 'WP_CACHE', false ); // Added by WP Rocket

 // Added by WP Rocket

/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', "i08ay_adopteUB_preprod" );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', "i08ay_adopteUB" );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', "PJddEx5-jB5" );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', "i08ay.myd.infomaniak.com" );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`r/vWVSNGTTm8i>m){%6x,nob,YX]nCq,;rzWPxG_kn>R7^E.|L/rp9r2NU1!ICm' );
define( 'SECURE_AUTH_KEY',  'xBl(KsV`,Hpyc~[u?HOnQFj`dJ~V`Km+o(0yV(YoG{!eY(Yxsh1F,}xgc:UG{syp' );
define( 'LOGGED_IN_KEY',    '7G ]cy~6rPI,64,mL@Ql`,^i><VJ$5qIpemLa_wE-rMWG#UC{$4Xpeq8eQC(pS +' );
define( 'NONCE_KEY',        '^c*(WFm .wy^%<_737G_]L?JD{bfWlFAl?Z,tlV)vQX!/.Na]I~a^/iwrTr=*6?M' );
define( 'AUTH_SALT',        '?6r$.b_=Ym$LL3*5kzKts#ns3xy1V vaV5DmQwf}wmf^yh>iz-myX 6]Fc1l[@]2' );
define( 'SECURE_AUTH_SALT', 'Z^c>^tAe{*mE0N{,vP_g^5L)s1/DzqA^BW^{75NARY~<l$i0]?&!Y80p&u3^Z%i+' );
define( 'LOGGED_IN_SALT',   '^k*btHw!4CX6EtUylmC!kans|.Y-%7Zv:iO<03&xj.~c~-vf/p 45_M~:oAef{O|' );
define( 'NONCE_SALT',       ':.pb*(M271?7Mf0@x^[yDXS}@?e%-:O:cT$}H*i8tVY1JUUa2MI^<NOWI/ }PVK<' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
define( 'DUPLICATOR_AUTH_KEY', '>xpv#cv<{xF*0W}Yv!U/H<sa{Is{- PHeZ^_w91+@p5]uSD+4oTNPT=_r]L@ff`=' );
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname(__FILE__) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
