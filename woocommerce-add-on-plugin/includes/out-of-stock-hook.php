<?php
// Replace displayed price by a text for out of stock WooCommerce products
add_filter('woocommerce_get_price_html', 'change_sold_out_product_price_html', 100, 2 );
function change_sold_out_product_price_html( $price_html, $product ) {
    if ( ! $product->is_in_stock() ) {
        $price_html = __("<b style='color:red'>Temporarily Unavailable</b>", "woocommerce");
    }
    return $price_html;
}
?>