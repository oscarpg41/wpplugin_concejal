<?php
/**
 * Shortcode y renderizado público del listado de concejales.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'corporacion_municipal', 'cm_render_shortcode' );

/**
 * [corporacion_municipal columnas="3"]
 */
function cm_render_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'columnas' => 3,
		),
		$atts,
		'corporacion_municipal'
	);

	$columnas   = max( 1, min( 4, absint( $atts['columnas'] ) ) );
	$concejales = cm_get_concejales();

	if ( empty( $concejales ) ) {
		return '<p class="cm-empty">' . esc_html__( 'Todavía no se ha publicado la corporación municipal.', 'corporacion-municipal' ) . '</p>';
	}

	cm_enqueue_public_assets();
	add_action( 'wp_footer', 'cm_print_modal_markup' );

	ob_start();
	include CM_PLUGIN_DIR . 'includes/views/public-list.php';
	return ob_get_clean();
}

/**
 * Carga los estilos/scripts públicos solo cuando se usa el shortcode.
 */
function cm_enqueue_public_assets() {
	wp_enqueue_style( 'cm-public', CM_PLUGIN_URL . 'assets/css/public.css', array(), CM_VERSION );
	wp_enqueue_script( 'cm-public', CM_PLUGIN_URL . 'assets/js/public.js', array(), CM_VERSION, true );
}

/**
 * Pinta la estructura del modal de biografía una sola vez, en el footer.
 */
function cm_print_modal_markup() {
	include CM_PLUGIN_DIR . 'includes/views/public-modal.php';
}

/**
 * Iniciales de un nombre, usadas como marcador de posición cuando no hay foto.
 */
function cm_get_initials( $name ) {
	$words    = preg_split( '/\s+/', trim( (string) $name ) );
	$initials = '';

	foreach ( array_slice( $words, 0, 2 ) as $word ) {
		$initials .= mb_strtoupper( mb_substr( $word, 0, 1 ) );
	}

	return '' !== $initials ? $initials : '?';
}
