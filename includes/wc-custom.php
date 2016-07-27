<?php


//
function woo_template_loop_product_link_open() {
    echo '<a href="' . get_the_permalink() . '" class="product-tile">';
}
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
add_action('woocommerce_before_shop_loop_item', 'woo_template_loop_product_link_open');

// Remove sales flash
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// Remove product data tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// Remove cart collaterals
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' , 10 );

// Utitlity Functions
function woo_product_image_slider($ids) {

    global $post, $product, $woocommerce;

    if ( $ids ) {

        // Print product feature image
        if ( has_post_thumbnail() ) {
            $feature_id = get_post_thumbnail_id();
            array_unshift( $ids, $feature_id );
        }

        woo_print_product_image_html($ids, 'large', 'slider js-product-slider');
        woo_print_product_image_html($ids, 'thumbnail', 'thumbnails');

    }

}

function woo_print_product_image_html($ids, $size, $classes) {

    echo '<ul class="' . $classes . '">';

    if ($size == 'large') {
        $filter = apply_filters('single_product_large_thumbnail_size', 'shop_single');
    } else {
        $filter = apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' );
    }

    // Print images
    foreach ( $ids as $attachment_id ) {

        $props = wc_get_product_attachment_props( $attachment_id, $post );

        $image_link = wp_get_attachment_url( $attachment_id );

        if ( ! $image_link )
            continue;

        $image_title 	= esc_attr( get_the_title( $attachment_id ) );
        $image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

        $image       = '<img src="' . wp_get_attachment_image_src( $attachment_id, $filter )[0] . '" title="' . $props["title"] . '" alt="' . $props["alt"] . '">';

        $image_class = esc_attr( implode( ' ', $classes ) );

        $image_template = ($size === 'large') ? $image : sprintf( '<a href="%s" class="%s" title="%s">%s</a>', $image_link, $image_class, $image_caption, $image );

        $slide = sprintf( '<li>%s</li>', $image_template );

        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $slide , $attachment_id, $post->ID, $image_class );

    }

    echo '</ul>';
}
