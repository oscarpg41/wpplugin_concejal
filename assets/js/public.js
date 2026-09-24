( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var modal = document.getElementById( 'cm-modal' );
		if ( ! modal ) {
			return;
		}

		var title       = modal.querySelector( '.cm-modal-title' );
		var role        = modal.querySelector( '.cm-modal-role' );
		var bio         = modal.querySelector( '.cm-modal-bio' );
		var email       = modal.querySelector( '.cm-modal-email' );
		var photo       = modal.querySelector( '.cm-modal-photo' );
		var lastFocused = null;

		function openModal( card ) {
			lastFocused = document.activeElement;

			title.textContent = card.dataset.cmName || '';
			role.textContent  = card.dataset.cmRole || '';
			bio.innerHTML      = card.dataset.cmBio || '';

			if ( card.dataset.cmEmail ) {
				email.textContent   = card.dataset.cmEmail;
				email.href          = 'mailto:' + card.dataset.cmEmail;
				email.style.display = '';
			} else {
				email.style.display = 'none';
			}

			photo.innerHTML = '';
			if ( card.dataset.cmPhoto ) {
				var img = document.createElement( 'img' );
				img.src = card.dataset.cmPhoto;
				img.alt = '';
				photo.appendChild( img );
				photo.style.display = '';
			} else {
				photo.style.display = 'none';
			}

			modal.classList.add( 'cm-modal-open' );
			modal.setAttribute( 'aria-hidden', 'false' );
			document.body.classList.add( 'cm-modal-lock' );
			modal.querySelector( '.cm-modal-close' ).focus();
		}

		function closeModal() {
			modal.classList.remove( 'cm-modal-open' );
			modal.setAttribute( 'aria-hidden', 'true' );
			document.body.classList.remove( 'cm-modal-lock' );
			if ( lastFocused ) {
				lastFocused.focus();
			}
		}

		document.addEventListener( 'click', function ( event ) {
			if ( event.target.closest( '[data-cm-close]' ) ) {
				closeModal();
				return;
			}

			if ( event.target.closest( 'a[href]' ) ) {
				return;
			}

			var card = event.target.closest( '[data-cm-open]' );
			if ( card ) {
				openModal( card );
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && modal.classList.contains( 'cm-modal-open' ) ) {
				closeModal();
				return;
			}

			if ( 'Enter' !== event.key && ' ' !== event.key ) {
				return;
			}

			var card = event.target.closest( '[data-cm-open]' );
			if ( card ) {
				event.preventDefault();
				openModal( card );
			}
		} );
	} );
}() );
