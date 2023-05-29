<?php

// Remove product showing result and default sorting in product category page
add_action( 'woocommerce_before_shop_loop', 'remove_sorting_total_count', 1 );
function remove_sorting_total_count(){
    if ( is_product_category() ) {
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    }
}

// Remove latest product in category page
add_action( 'woocommerce_shop_loop', 'remove_woocommerce_shop_loop' );
function remove_woocommerce_shop_loop() {
    remove_action( 'woocommerce_shop_loop', 'woocommerce_output_all_notices', 10 );
}

// Add featured product section
add_action( 'woocommerce_before_shop_loop', 'add_featured_product_section', 1 );
function add_featured_product_section() {
    if ( is_product_category() ) {

        $get_category = get_queried_object();
        $category_id = $get_category->term_id;
        $dynamic_product_count = 4;

        $args = array (
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $dynamic_product_count ,
            'meta_key'    => '_stock_status',
            'meta_value'  => 'instock',
            'tax_query' =>  array (
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' =>  'product_visibility',
                                        'field'    =>  'name',
                                        'terms'    =>  'featured',
                                    ),
                                    array(
                                        'taxonomy' =>  'product_cat',
                                        'field'    =>  'id',
                                        'terms'    =>  $category_id,
                                    ),
                                )
                            ),
        );

        $featured_product = new WP_Query( $args );

        echo "<p>Featured Product </p>";
        woocommerce_product_loop_start();
            if ( $featured_product->have_posts() ): while ( $featured_product->have_posts() ): $featured_product->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile; wp_reset_query(); endif;
        woocommerce_product_loop_end();

    }
}

// Add Best selling product in last month section
add_action( 'woocommerce_before_shop_loop', 'best_selling_product', 2 );
function best_selling_product() {
    if ( is_product_category() ) {

        $get_category = get_queried_object();
        $category_id = $get_category->term_id;
        $dynamic_product_count = 4;

        $args = array(
            'post_type'      =>  'product',
            'orderby'        =>  'meta_value_num',
            'posts_per_page' =>  $dynamic_product_count,
            'tax_query'      =>  array (
                                    array(
                                        'taxonomy' =>  'product_cat',
                                        'field'    =>  'id',
                                        'terms'    =>  $category_id,
                                    )
                                ),
            'meta_query'     => array(
                                    array(
                                        'key'     => 'total_sales',
                                        'value'   => '0',
                                        'compare' => '!=',
                                    )
                                )
        );

        $best_selling_products = new WP_Query( $args );

        echo "<p>Best Selling Product </p>";
        woocommerce_product_loop_start();
            if( $best_selling_products->have_posts() ) :
                while ( $best_selling_products->have_posts() ) : $best_selling_products->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile;
                wp_reset_postdata();
            endif;
        woocommerce_product_loop_end();
    }
}

// Add All other product excluding featured and best selling product
add_action( 'woocommerce_before_shop_loop', 'all_product_excluding_first_two_point', 3 );
function all_product_excluding_first_two_point() {
    if ( is_product_category() ) {

        $get_category = get_queried_object();
        $category_id = $get_category->term_id;
        $dynamic_product_count = 4;

        $args = array (
            'post_type' => 'product',
            'post_status' => 'publish',
            'orderby' => 'meta_value_num',
            'posts_per_page' => $dynamic_product_count,
            'tax_query' =>  array (
                                array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' =>  'product_visibility',
                                        'field'    =>  'name',
                                        'terms'    =>  'featured',
                                        'operator' => 'NOT IN',
                                    ),
                                    array(
                                        'taxonomy' =>  'product_cat',
                                        'field'    =>  'id',
                                        'terms'    =>  $category_id,
                                    ),
                                )
                            ),
            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key'     => 'total_sales',
                                    'value'   => '0',
                                    'compare' => '=',
                                ),
                                array(
                                    'meta_key'    => '_stock_status',
                                    'meta_value'  => 'instock',
                                )
                            )
        );

        $excluding_products = new WP_Query( $args );

        echo "<p>Excluding Product</p>";
        woocommerce_product_loop_start();
            if ( $excluding_products->have_posts() ): while ( $excluding_products->have_posts() ): $excluding_products->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile; wp_reset_query(); endif;
        woocommerce_product_loop_end();
    }
}

// Add Out of stock product section
add_action( 'woocommerce_before_shop_loop', 'out_of_stock_product', 4 );
function out_of_stock_product() {
    if ( is_product_category() ) {
        $get_category = get_queried_object();
        $category_id = $get_category->term_id;
        $dynamic_product_count = 4;

        $args = array(
            'post_type'      => 'product',
            'meta_key'       => '_stock_status',
            'meta_value'     => 'outofstock',
            'orderby'        => 'date',
            'posts_per_page' => $dynamic_product_count,
            'tax_query'      => array (
                                    array(
                                        'taxonomy' =>  'product_cat',
                                        'field'    =>  'id',
                                        'terms'    =>  $category_id,
                                    )
                                ),
        );

        $out_stock = new WP_Query( $args );

        echo "<p>Out Of Stock Products </p>";
        woocommerce_product_loop_start();
            if( $out_stock->have_posts() ) :
                while ( $out_stock->have_posts() ) : $out_stock->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile;
                wp_reset_postdata();
            endif;
        woocommerce_product_loop_end();
    }
}
?>