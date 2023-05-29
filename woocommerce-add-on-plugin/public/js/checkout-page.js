/**
 * Gift wrapping message required if gift wrapping is checked
 */
jQuery( document ).ready(function($) {
    $('#gift_wrapping_message_field').hide();
    $('#gift_wrapping ').change( function(){
        $('#gift_wrapping_message_field').toggle();
    });
});