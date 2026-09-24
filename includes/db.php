<?php
/**
 * Acceso a base de datos para la tabla de concejales.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nombre completo (con prefijo) de la tabla de concejales.
 * Se mantiene el nombre histórico `opg_plugin_concejal` para no perder los datos
 * de instalaciones que ya usaban versiones anteriores del plugin.
 */
function cm_table_name() {
	global $wpdb;
	return $wpdb->prefix . 'opg_plugin_concejal';
}

/**
 * Crea o actualiza la tabla mediante dbDelta (no destruye datos existentes).
 */
function cm_create_table() {
	global $wpdb;

	$table_name      = cm_table_name();
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE {$table_name} (
		idConcejal INT(11) NOT NULL AUTO_INCREMENT,
		name VARCHAR(255) NOT NULL,
		email VARCHAR(100) NOT NULL DEFAULT '',
		description TEXT NOT NULL,
		biography TEXT NULL,
		orden INT(11) NOT NULL DEFAULT 0,
		image VARCHAR(255) NOT NULL DEFAULT '',
		PRIMARY KEY  (idConcejal),
		KEY orden (orden)
	) {$charset_collate};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}

/**
 * Inserta un nuevo concejal. $data debe venir ya saneado.
 */
function cm_save_concejal( $data ) {
	global $wpdb;

	return $wpdb->insert(
		cm_table_name(),
		array(
			'name'        => $data['name'],
			'email'       => $data['email'],
			'description' => $data['description'],
			'biography'   => $data['biography'],
			'image'       => $data['image'],
			'orden'       => $data['orden'],
		),
		array( '%s', '%s', '%s', '%s', '%s', '%d' )
	);
}

/**
 * Actualiza un concejal existente. Si no se ha subido una imagen nueva,
 * conserva la que ya tenía en base de datos.
 */
function cm_update_concejal( $id, $data ) {
	global $wpdb;

	$fields  = array(
		'name'        => $data['name'],
		'email'       => $data['email'],
		'description' => $data['description'],
		'biography'   => $data['biography'],
		'orden'       => $data['orden'],
	);
	$formats = array( '%s', '%s', '%s', '%s', '%d' );

	if ( ! empty( $data['image'] ) ) {
		$fields['image'] = $data['image'];
		$formats[]       = '%s';
	}

	return $wpdb->update(
		cm_table_name(),
		$fields,
		array( 'idConcejal' => absint( $id ) ),
		$formats,
		array( '%d' )
	);
}

/**
 * Elimina un concejal por id.
 */
function cm_delete_concejal( $id ) {
	global $wpdb;
	return $wpdb->delete( cm_table_name(), array( 'idConcejal' => absint( $id ) ), array( '%d' ) );
}

/**
 * Recupera un concejal por id.
 */
function cm_get_concejal( $id ) {
	global $wpdb;
	$table = cm_table_name();

	return $wpdb->get_row(
		$wpdb->prepare(
			"SELECT idConcejal, name, email, description, biography, orden, image FROM {$table} WHERE idConcejal = %d",
			absint( $id )
		)
	);
}

/**
 * Recupera todos los concejales, ordenados por el campo `orden`.
 */
function cm_get_concejales() {
	global $wpdb;
	$table = cm_table_name();

	return $wpdb->get_results(
		"SELECT idConcejal, name, email, description, biography, orden, image FROM {$table} ORDER BY orden ASC, name ASC"
	);
}
