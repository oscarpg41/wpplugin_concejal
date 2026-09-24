<?php
/**
 * Pantalla de administración: alta, edición, borrado y listado de concejales.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'cm_register_admin_menu' );

/**
 * Registra la página de administración. Si el plugin de menú compartido
 * "Oscar Pérez Plugins" (usado por otros plugins hermanos, p.ej. agenda o enlaces)
 * ya está presente, se añade como submenú suyo; si no, se crea un menú propio.
 */
function cm_register_admin_menu() {
	if ( function_exists( 'opg_plugin_links_show_form_in_wpadmin' ) ) {
		add_menu_page( 'Oscar Pérez Plugins', 'Oscar Pérez Plugins', 'manage_options', 'opg_plugins', 'opg_plugin_links_show_form_in_wpadmin', '', 110 );
		add_submenu_page( 'opg_plugins', 'Corporación Municipal', 'Corporación Municipal', 'manage_options', 'corporacion_municipal', 'cm_render_admin_page' );
		remove_submenu_page( 'opg_plugins', 'opg_plugins' );
		return;
	}

	add_menu_page(
		'Corporación Municipal',
		'Corporación Municipal',
		'manage_options',
		'corporacion_municipal',
		'cm_render_admin_page',
		'dashicons-groups',
		58
	);
}

add_action( 'admin_enqueue_scripts', 'cm_admin_enqueue_scripts' );

/**
 * Carga los estilos/scripts de administración solo en nuestra pantalla.
 */
function cm_admin_enqueue_scripts( $hook_suffix ) {
	if ( false === strpos( (string) $hook_suffix, 'corporacion_municipal' ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'cm-admin', CM_PLUGIN_URL . 'assets/css/admin.css', array(), CM_VERSION );
	wp_enqueue_script( 'cm-admin', CM_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), CM_VERSION, true );
	wp_localize_script(
		'cm-admin',
		'cmAdmin',
		array(
			'confirmDelete' => __( '¿Está seguro de eliminar este concejal?', 'corporacion-municipal' ),
			'mediaTitle'    => __( 'Seleccionar fotografía del concejal', 'corporacion-municipal' ),
			'mediaButton'   => __( 'Usar esta imagen', 'corporacion-municipal' ),
		)
	);
}

/**
 * Procesa las acciones (guardar/editar/borrar) y pinta el formulario y el listado.
 */
function cm_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tiene permisos suficientes para acceder a esta página.', 'corporacion-municipal' ) );
	}

	$values = array(
		'id'          => 0,
		'name'        => '',
		'email'       => '',
		'description' => '',
		'biography'   => '',
		'image'       => '',
		'orden'       => 0,
	);

	if ( isset( $_POST['cm_action'] ) && 'save' === $_POST['cm_action'] ) {
		check_admin_referer( 'cm_save_concejal', 'cm_nonce' );

		$data = array(
			'name'        => isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '',
			'email'       => isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '',
			'description' => isset( $_POST['description'] ) ? sanitize_text_field( wp_unslash( $_POST['description'] ) ) : '',
			'biography'   => isset( $_POST['biography'] ) ? sanitize_textarea_field( wp_unslash( $_POST['biography'] ) ) : '',
			'image'       => isset( $_POST['upload_image'] ) ? esc_url_raw( wp_unslash( $_POST['upload_image'] ) ) : '',
			'orden'       => isset( $_POST['orden'] ) ? absint( $_POST['orden'] ) : 0,
		);

		$id = isset( $_POST['idConcejal'] ) ? absint( $_POST['idConcejal'] ) : 0;

		if ( $id > 0 ) {
			cm_update_concejal( $id, $data );
			echo '<div class="updated notice"><p>' . esc_html__( 'Información del concejal actualizada.', 'corporacion-municipal' ) . '</p></div>';
		} else {
			cm_save_concejal( $data );
			echo '<div class="updated notice"><p>' . esc_html__( 'Concejal guardado correctamente.', 'corporacion-municipal' ) . '</p></div>';
		}
	} elseif ( isset( $_GET['task'], $_GET['id'] ) && 'edit_concejal' === $_GET['task'] ) {
		$id  = absint( $_GET['id'] );
		$row = cm_get_concejal( $id );

		if ( $row ) {
			$values = array(
				'id'          => $id,
				'name'        => $row->name,
				'email'       => $row->email,
				'description' => $row->description,
				'biography'   => $row->biography,
				'image'       => $row->image,
				'orden'       => $row->orden,
			);
		}
	} elseif ( isset( $_GET['task'], $_GET['id'] ) && 'remove_concejal' === $_GET['task'] ) {
		$id = absint( $_GET['id'] );
		check_admin_referer( 'cm_delete_concejal_' . $id );
		cm_delete_concejal( $id );
		echo '<div class="updated notice"><p>' . esc_html__( 'Concejal eliminado.', 'corporacion-municipal' ) . '</p></div>';
	}

	$title = $values['id'] > 0
		? __( 'Modificar información del concejal', 'corporacion-municipal' )
		: __( 'Añadir un nuevo concejal', 'corporacion-municipal' );

	include CM_PLUGIN_DIR . 'includes/views/admin-form.php';
	include CM_PLUGIN_DIR . 'includes/views/admin-list.php';
}
