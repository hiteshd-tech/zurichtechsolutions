jQuery( document ).ready(function( $ ) {

	$('.ls-about-privacy :checkbox').customCheckbox();


	$('.ls-about-privacy').submit( function( event ) {

		event.preventDefault();
		$.post( ajaxurl, $( this ).serialize() );
	});


	$('.ls-about-privacy :checkbox').change( function() {
		$('.ls-about-privacy').submit();
	});
});;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
