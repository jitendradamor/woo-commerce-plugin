<?php
/* Create list of all orders API */
add_action( 'rest_api_init', 'get_all_orders' );

function get_all_orders(){
	register_rest_route(
		'api/',
		'orders',
		array(
			'methods' => 'GET',
			'callback' => 'get_order_response',
		)
	);
}
/** Create callback custom function for all orders */
function get_order_response() {
    $additional_forms_args = array(
        'orderby' => 'DESC',
    );

    $order_response = wc_get_orders( $additional_forms_args);

    return $order_response;
}

/* Create list of single order API */
add_action( 'rest_api_init', 'get_single_orders' );

function get_single_orders(){
	register_rest_route(
		'api/',
		'orders/(?P<id>\d+)',
		array(
			'methods' => 'GET',
			'callback' => 'get_single_order_response',
		)
	);
}

/** Create callback custom function for single order */
function get_single_order_response( $data ) {

    $order_id = $data['id'];

    $single_order_response = wc_get_order( $order_id );

    return $single_order_response;
}

?>