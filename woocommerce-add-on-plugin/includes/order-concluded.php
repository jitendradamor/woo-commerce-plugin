<?php
// Hook into WooCommerce order completion event
add_action('woocommerce_order_status_completed', 'send_custom_data_to_api');

function send_custom_data_to_api( $order_id ) {
    // Get the order object
    $order = wc_get_order( $order_id );

    // Get purchased items
    $items = array();
    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        $items[] = array(
            'product_id' => $product->get_id(),
            'name' => $product->get_name(),
            'quantity' => $item->get_quantity(),
            'subtotal' => $item->get_subtotal(),
        );
    }

    // Get user's previous orders
    $previous_orders = array();
    $customer_id = $order->get_customer_id();
    if ($customer_id) {
        $args = array(
            'customer_id' => $customer_id,
            'exclude' => $order_id,
            'limit' => -1,
        );
        $previous_orders = wc_get_orders( $args );
        $previous_orders = wp_list_pluck( $previous_orders, 'ID' );
    }

    // Prepare the request body
    $request_body = array(
        'order_id' => $order_id,
        'purchased_items' => $items,
        'previous_orders' => $previous_orders,
    );

    // Send the POST request
    $response = wp_remote_post('https://webapi.com', array(
        'body' => $request_body,
    ));

    // Handle the response
    if (!is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200) {
        // Request was successful
        $response_body = wp_remote_retrieve_body( $response );
        // Process the response body as needed
    } else {
        // Request failed, handle the error
        $error_message = is_wp_error( $response ) ? $response->get_error_message() : 'Unknown error';
        // Handle the error message appropriately
    }
}
?>