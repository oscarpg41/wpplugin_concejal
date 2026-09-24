<?php
/**
 * Listado de concejales en el panel de administración.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$concejales = cm_get_concejales();
?>
<div class="wrap cm-admin-wrap">
	<hr>
	<h2><?php esc_html_e( 'Corporación municipal', 'corporacion-municipal' ); ?></h2>

	<?php if ( empty( $concejales ) ) : ?>
		<p><?php esc_html_e( 'Todavía no se ha añadido ningún concejal.', 'corporacion-municipal' ); ?></p>
	<?php else : ?>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th style="width:60px"><?php esc_html_e( 'Foto', 'corporacion-municipal' ); ?></th>
					<th><?php esc_html_e( 'Nombre', 'corporacion-municipal' ); ?></th>
					<th><?php esc_html_e( 'Email', 'corporacion-municipal' ); ?></th>
					<th><?php esc_html_e( 'Cargo', 'corporacion-municipal' ); ?></th>
					<th style="width:80px"><?php esc_html_e( 'Orden', 'corporacion-municipal' ); ?></th>
					<th style="width:220px"></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ( $concejales as $concejal ) : ?>
				<tr>
					<td>
						<?php if ( ! empty( $concejal->image ) ) : ?>
							<img src="<?php echo esc_url( $concejal->image ); ?>" alt="" class="cm-admin-thumb">
						<?php endif; ?>
					</td>
					<td><?php echo esc_html( $concejal->name ); ?></td>
					<td><?php echo esc_html( $concejal->email ); ?></td>
					<td><?php echo nl2br( esc_html( $concejal->description ) ); ?></td>
					<td><?php echo esc_html( $concejal->orden ); ?></td>
					<td>
						<a class="button button-small" href="<?php echo esc_url( admin_url( 'admin.php?page=corporacion_municipal&task=edit_concejal&id=' . $concejal->idConcejal ) ); ?>">
							<span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Modificar', 'corporacion-municipal' ); ?>
						</a>
						<a class="button button-small cm-delete-link" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=corporacion_municipal&task=remove_concejal&id=' . $concejal->idConcejal ), 'cm_delete_concejal_' . $concejal->idConcejal ) ); ?>">
							<span class="dashicons dashicons-trash"></span> <?php esc_html_e( 'Borrar', 'corporacion-municipal' ); ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
