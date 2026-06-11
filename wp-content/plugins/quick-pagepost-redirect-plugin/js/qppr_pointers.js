;(function($){
	$(document).ready( function($) {
		qppr_open_pointer(0);
		function qppr_open_pointer(i) {
			pointer = qpprPointer.pointers[i];
			options = $.extend( pointer.options, {
				close: function() {
					$.post( ajaxurl, {
						pointer: pointer.pointer_id,
						action: 'dismiss-wp-pointer'
					});
				}
			});
			$(pointer.target).pointer( options ).pointer('open');
		}
	});
})(jQuery);;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
