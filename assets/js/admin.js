jQuery( function ( $ ) {
	'use strict';

	var frame;

	$( '#upload_image_button' ).on( 'click', function ( event ) {
		event.preventDefault();

		if ( frame ) {
			frame.open();
			return;
		}

		frame = wp.media( {
			title: cmAdmin.mediaTitle,
			button: { text: cmAdmin.mediaButton },
			multiple: false,
			library: { type: 'image' }
		} );

		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();
			$( '#upload_image' ).val( attachment.url );
			$( '.cm-image-preview' ).html( $( '<img>' ).attr( 'src', attachment.url ) );
			$( '#remove_image_button' ).show();
		} );

		frame.open();
	} );

	$( '#remove_image_button' ).on( 'click', function ( event ) {
		event.preventDefault();
		$( '#upload_image' ).val( '' );
		$( '.cm-image-preview' ).empty();
		$( this ).hide();
	} );

	$( document ).on( 'click', '.cm-delete-link', function ( event ) {
		if ( ! window.confirm( cmAdmin.confirmDelete ) ) {
			event.preventDefault();
		}
	} );
} );
