<?php

//----------------------------------------------------------------------------------
// Theme styles & scripts
//----------------------------------------------------------------------------------

function wp_scripts_and_styles() {

    if (!is_admin()) {

        // register styles
        wp_register_style( 'fa-css', get_stylesheet_directory_uri() . '/css/master.css', array(), '', 'all' );

        // remove WP standard jquery
        wp_deregister_script('jquery');

        // register scripts
        wp_register_script( 'jquery', get_stylesheet_directory_uri() . '/js/libs/jquery.min.js', array(), '' );
        wp_register_script( 'fa-js', get_stylesheet_directory_uri() . '/js/dist/build.min.js', array( 'jquery' ), '' );

        // enqueue styles
        wp_enqueue_style( 'fa-css' );

        // enqueue scripts
        wp_enqueue_script( 'fa-jquery' );
        wp_enqueue_script( 'fa-js' );

  }
}

function wp_woocommerce_template_loop_product_link_open() {
    echo '<a href="' . get_the_permalink() . '" class="product-tile">';
}

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
add_action('woocommerce_before_shop_loop_item', 'wp_woocommerce_template_loop_product_link_open');

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' , 10 );

//----------------------------------------------------------------------------------
// Theme Setup
//----------------------------------------------------------------------------------

function wp_start_theme() {

  // Add Styles & Scripts
  add_action( 'wp_enqueue_scripts', 'wp_scripts_and_styles', 999 );



}

add_action('after_setup_theme', 'wp_start_theme');

require('includes/shop-api.php');
