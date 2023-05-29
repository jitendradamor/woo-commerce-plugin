<?php
// Add a custom checkout field
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );
function my_custom_checkout_field( $checkout ) {

    echo '<div id="my_custom_checkout_field">';

        woocommerce_form_field( 'gift_wrapping', array(
            'type'          => 'checkbox',
            'class'         => array('wrapping-class form-row-wide'),
            'label'         => __('Add Gift Wrapping'),
            'required'      => false,
        ), $checkout->get_value( 'gift_wrapping' ) );

        woocommerce_form_field( 'gift_wrapping_message', array(
            'type'          => 'textarea',
            'class'         => array('wrapping-message-class form-row-wide'),
            'label'         => __('Gift Wrapping Message'),
            'placeholder'   => __('Enter Message'),
            'required'      => false,
        ), $checkout->get_value( 'gift_wrapping_message' ) );

    echo '</div>';
}

// Save custom fields to order meta data
add_action( 'woocommerce_checkout_update_order_meta', 'carrier_update_order_meta', 30, 1 );
function carrier_update_order_meta( $order_id ) {
    if( isset( $_POST['gift_wrapping'] ) )
        update_post_meta( $order_id, 'gift_wrapping', sanitize_text_field( $_POST['gift_wrapping'] ) );

    if( isset( $_POST['gift_wrapping_message'] ))
        update_post_meta( $order_id, 'gift_wrapping_message', sanitize_text_field( $_POST['gift_wrapping_message'] ) );
}

// Display Custom Field in admin order details
add_action('woocommerce_admin_order_data_after_billing_address', 'custom_billing_fields_display_admin_order_meta', 10, 1);
function custom_billing_fields_display_admin_order_meta( $order ) {
    $gift_post_meta = get_post_meta( $order->id, 'gift_wrapping', true);

    if( $gift_post_meta == '1') {
        $gift_value = 'Yes';
    } else {
        $gift_value = 'No';
    }

    echo '<p><strong>' . __('Gift Wrapping') . ':</strong><br> ' . $gift_value . '</p>';

    if ( $gift_value == 'Yes') {
        echo '<p><strong>' . __('Gift Wrapping Message') . ':</strong><br> ' . get_post_meta( $order->id, 'gift_wrapping_message', true ) . '</p>';
    }
}
?>