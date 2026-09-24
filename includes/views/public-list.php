<?php
/**
 * Listado público (shortcode [corporacion_municipal]).
 * Variables disponibles: $concejales, $columnas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cm-grid" style="--cm-columnas: <?php echo esc_attr( $columnas ); ?>;">
	<?php foreach ( $concejales as $concejal ) : ?>
		<?php
		$tiene_bio = '' !== trim( (string) $concejal->biography );
		$iniciales = cm_get_initials( $concejal->name );
		?>
		<div
			class="cm-card<?php echo $tiene_bio ? ' cm-card-clickable' : ''; ?>"
			<?php if ( $tiene_bio ) : ?>
				data-cm-open
				data-cm-name="<?php echo esc_attr( $concejal->name ); ?>"
				data-cm-role="<?php echo esc_attr( $concejal->description ); ?>"
				data-cm-bio="<?php echo esc_attr( wpautop( $concejal->biography ) ); ?>"
				data-cm-email="<?php echo esc_attr( $concejal->email ); ?>"
				data-cm-photo="<?php echo esc_attr( $concejal->image ); ?>"
				tabindex="0"
				role="button"
				aria-haspopup="dialog"
			<?php endif; ?>
		>
			<div class="cm-card-photo">
				<?php if ( ! empty( $concejal->image ) ) : ?>
					<img src="<?php echo esc_url( $concejal->image ); ?>" alt="<?php echo esc_attr( $concejal->name ); ?>" loading="lazy">
				<?php else : ?>
					<span class="cm-card-placeholder" aria-hidden="true"><?php echo esc_html( $iniciales ); ?></span>
				<?php endif; ?>
			</div>
			<div class="cm-card-body">
				<h3 class="cm-card-name"><?php echo esc_html( $concejal->name ); ?></h3>
				<?php if ( ! empty( $concejal->description ) ) : ?>
					<p class="cm-card-role"><?php echo nl2br( esc_html( $concejal->description ) ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $concejal->email ) ) : ?>
					<a class="cm-card-email" href="mailto:<?php echo esc_attr( $concejal->email ); ?>"><?php echo esc_html( $concejal->email ); ?></a>
				<?php endif; ?>
				<?php if ( $tiene_bio ) : ?>
					<span class="cm-card-more"><?php esc_html_e( 'Ver biografía', 'corporacion-municipal' ); ?> →</span>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
