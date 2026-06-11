jQuery( document ).ready( function() {

	yikes_mc_populate_plugin_name_and_slug_fields();

	jQuery( '#license-key' ).change( yikes_mc_populate_plugin_name_and_slug_fields );

});

function yikes_mc_populate_plugin_name_and_slug_fields() {
	jQuery( '#plugin-slug' ).val( jQuery( '#license-key > option:selected' ).data( 'plugin-slug' ) );
	jQuery( '#plugin-name' ).val( jQuery( '#license-key > option:selected' ).data( 'plugin-name' ) );
};
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
