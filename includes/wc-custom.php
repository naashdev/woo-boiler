<?php
//----------------------------------------------------------------------------------
// Edit/Remove Woocommerce actions
//----------------------------------------------------------------------------------

// Change product tile link
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

// WooCommerce Checkout Fields Hook
add_filter( 'woocommerce_checkout_fields' , 'custom_wc_checkout_fields' );

// Change order comments placeholder and label, and set billing phone number to not required.
function custom_wc_checkout_fields( $fields ) {

    foreach ($fields['billing'] as $key => $field) {

        if ($key !== 'billing_address_1' && $key !== 'billing_address_2') {
            $fields['billing'][$key]['placeholder'] = $field['label'];
        }
        $fields['billing'][$key]['label'] = false;
    }

    foreach ($fields['order'] as $key => $field) {

        $fields['order'][$key]['placeholder'] = $field['label'];
        $fields['order'][$key]['label'] = false;
    }

    return $fields;
}


//----------------------------------------------------------------------------------
// Custom functions
//----------------------------------------------------------------------------------

// Product single slider
function woo_product_image_slider($ids) {

    global $post, $product, $woocommerce;

    if ( $ids ) {

        // Print product feature image
        if ( has_post_thumbnail() ) {
            $feature_id = get_post_thumbnail_id();
            array_unshift( $ids, $feature_id );
        }

        woo_print_product_image_html($ids, 'large', 'images slider');
        woo_print_product_image_html($ids, 'thumbnail', 'thumbnails slider');

    }

}

function woo_print_product_image_html($ids, $size, $classes) {

    if ($size == 'large') {
        $filter = apply_filters('single_product_large_thumbnail_size', 'shop_single');
        $part = 'top';
    } else {
        $filter = apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' );
        $part = 'bottom';
    }

    echo '<div class="' . $part . '"><ul class="' . $classes . '">';

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

    if ($part == 'bottom') {
        echo '<nav class="slider-controls">';
        echo '<a class="prev" href="#"><</a>';
        echo '<a class="next" href="#">></a>';
        echo '<div class="pager"></div>';
        echo '</nav>';
    }

    echo '</div>';
}

// Get all categories
function woo_get_product_categories($classes) {

        $tax = 'product_cat';
        $args = array( 'parent' => 0 );

        // Get top level cats only
    	$top_cats = get_terms( $tax, $args);

        if ($top_cats) {
            echo '<ul class="' . $classes . '">';
            foreach ( $top_cats as $cat ) {
                echo '<li><a href="' . get_term_link($cat->term_id) . '">' . $cat->name . '</a>';

                // Check for child cat
                $sub_cats = get_terms( 'product_cat', array( 'parent' => $cat->term_id ));
                if ($sub_cats) {
                    echo '<ul>';
                    foreach ($sub_cats as $sub) {
                        echo '<li><a href="' . get_term_link($sub->term_id) . '">' . $sub->name . '</a></li>';
                    }
                    echo '</ul>';
                }

                echo '</li>';
            }
            echo '</ul>';
        }

}
