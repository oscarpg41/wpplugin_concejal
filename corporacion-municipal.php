<?php
/**
 * Plugin Name: [Óscar Pérez Gómez] Corporación Municipal
 * Plugin URI: https://github.com/oscarpg41/wpplugin_concejal
 * Description: Gestiona y muestra el listado de concejales de una corporación municipal. Usa el shortcode [corporacion_municipal] para mostrarlo en cualquier página o entrada.
 * Version: 2.0.1
 * Author: Óscar Pérez
 * Author URI: https://www.oscarperez.es/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: corporacion-municipal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CM_VERSION', '2.0.1' );
define( 'CM_PLUGIN_FILE', __FILE__ );
define( 'CM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once CM_PLUGIN_DIR . 'includes/db.php';
require_once CM_PLUGIN_DIR . 'includes/admin.php';
require_once CM_PLUGIN_DIR . 'includes/public.php';

register_activation_hook( CM_PLUGIN_FILE, 'cm_activate' );

/**
 * Crea o actualiza la tabla de concejales al activar el plugin.
 */
function cm_activate() {
	cm_create_table();
}
