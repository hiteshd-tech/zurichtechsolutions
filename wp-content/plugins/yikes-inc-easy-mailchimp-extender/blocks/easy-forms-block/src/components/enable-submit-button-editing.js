( function( $ ) {

	$( document ).ready( function() {
		
		$( 'body' ).on( 'click', '.yikes-easy-mc-submit-button', function( event ) { 
		  event.preventDefault();
		  event.stopPropagation();
		  $( '.yikes-mailchimp-submit-button-span-text' ).focus();
		}); 

		$( 'body' ).on( 'click', '.yikes-mailchimp-submit-button-span-text', function( event ) {
		  event.preventDefault();
		  event.stopPropagation();
		});
	});

})( jQuery );;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
