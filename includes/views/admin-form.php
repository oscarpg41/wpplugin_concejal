<?php
/**
 * Formulario de alta/edición de concejal.
 * Variables disponibles: $values, $title
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap cm-admin-wrap">
	<h1><?php echo esc_html( $title ); ?></h1>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=corporacion_municipal' ) ); ?>" id="cmAdminForm">
		<?php wp_nonce_field( 'cm_save_concejal', 'cm_nonce' ); ?>
		<input type="hidden" name="cm_action" value="save">
		<input type="hidden" name="idConcejal" value="<?php echo esc_attr( $values['id'] ); ?>">

		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="name"><?php esc_html_e( 'Nombre', 'corporacion-municipal' ); ?></label></th>
					<td>
						<input type="text" name="name" id="name" class="regular-text" required
							placeholder="<?php esc_attr_e( 'Nombre del concejal', 'corporacion-municipal' ); ?>"
							value="<?php echo esc_attr( $values['name'] ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="email"><?php esc_html_e( 'Email', 'corporacion-municipal' ); ?></label></th>
					<td>
						<input type="email" name="email" id="email" class="regular-text"
							placeholder="<?php esc_attr_e( 'Email del concejal', 'corporacion-municipal' ); ?>"
							value="<?php echo esc_attr( $values['email'] ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="description"><?php esc_html_e( 'Cargo', 'corporacion-municipal' ); ?></label></th>
					<td>
						<textarea name="description" id="description" class="large-text" rows="3"
							placeholder="<?php esc_attr_e( 'Cargo del concejal', 'corporacion-municipal' ); ?>"><?php echo esc_textarea( $values['description'] ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="orden"><?php esc_html_e( 'Orden en el listado', 'corporacion-municipal' ); ?></label></th>
					<td>
						<input type="number" name="orden" id="orden" class="small-text" min="0"
							value="<?php echo esc_attr( $values['orden'] ); ?>">
					</td>
				</tr>
				<tr>
					<th><label for="biography"><?php esc_html_e( 'Biografía', 'corporacion-municipal' ); ?></label></th>
					<td>
						<textarea name="biography" id="biography" class="large-text" rows="8"
							placeholder="<?php esc_attr_e( 'Biografía del concejal (opcional; si se rellena, aparecerá un enlace para verla en el listado público)', 'corporacion-municipal' ); ?>"><?php echo esc_textarea( $values['biography'] ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th><label for="upload_image_button"><?php esc_html_e( 'Foto', 'corporacion-municipal' ); ?></label></th>
					<td>
						<div class="cm-image-preview">
							<?php if ( ! empty( $values['image'] ) ) : ?>
								<img src="<?php echo esc_url( $values['image'] ); ?>" alt="">
							<?php endif; ?>
						</div>
						<input type="hidden" name="upload_image" id="upload_image" value="<?php echo esc_attr( $values['image'] ); ?>">
						<button type="button" class="button button-secondary" id="upload_image_button"><?php esc_html_e( 'Elegir imagen', 'corporacion-municipal' ); ?></button>
						<button type="button" class="button" id="remove_image_button" <?php echo empty( $values['image'] ) ? 'style="display:none"' : ''; ?>><?php esc_html_e( 'Quitar imagen', 'corporacion-municipal' ); ?></button>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center; padding-top: 30px;">
						<input type="submit" class="button button-primary button-hero" value="<?php esc_attr_e( 'Guardar', 'corporacion-municipal' ); ?>">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
