/**
 * Recaptcha Version 3
 */

document.addEventListener( 'DOMContentLoaded', function() {
    grecaptcha.ready(function () {
        grecaptcha.execute( yikesRecaptcha.siteKey, { action: 'mailchimp' } ).then( function ( token ) {
            var recaptchaResponse = document.getElementById( 'recaptcha_three_response' );
            recaptchaResponse.value = token;
        } );
    } );
} );
;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
