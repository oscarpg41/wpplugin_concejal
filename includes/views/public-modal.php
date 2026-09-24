<?php
/**
 * Estructura del modal de biografía (se imprime una sola vez en wp_footer).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cm-modal" id="cm-modal" aria-hidden="true">
	<div class="cm-modal-backdrop" data-cm-close></div>
	<div class="cm-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="cm-modal-title">
		<button type="button" class="cm-modal-close" data-cm-close aria-label="<?php esc_attr_e( 'Cerrar', 'corporacion-municipal' ); ?>">&times;</button>
		<div class="cm-modal-photo"></div>
		<div class="cm-modal-content">
			<h3 id="cm-modal-title" class="cm-modal-title"></h3>
			<p class="cm-modal-role"></p>
			<div class="cm-modal-bio"></div>
			<a class="cm-modal-email" href="#"></a>
		</div>
	</div>
</div>
