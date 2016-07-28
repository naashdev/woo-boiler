<?php

//----------------------------------------------------------------------------------
// Theme scripts & styles
//----------------------------------------------------------------------------------

function slck_scripts_and_styles() {

    if (!is_admin()) {

        // register styles
        wp_register_style( 'slck-css', get_stylesheet_directory_uri() . '/css/master.css', array(), '', 'all' );

        // remove WP standard jquery
        wp_deregister_script('jquery');

        // register scripts
        wp_register_script( 'jquery', get_stylesheet_directory_uri() . '/js/libs/jquery.min.js', array(), '' );
        wp_register_script( 'slck-js', get_stylesheet_directory_uri() . '/js/dist/build.min.js', array( 'jquery' ), '' );

        // enqueue styles
        wp_enqueue_style( 'slck-css' );

        // enqueue scripts
        wp_enqueue_script( 'slck-jquery' );
        wp_enqueue_script( 'slck-js' );

  }

}

//----------------------------------------------------------------------------------
// Theme Setup
//----------------------------------------------------------------------------------

function slck_start_theme() {

    // Declare Woocommerce Support
    add_theme_support( 'woocommerce' );

    // Required
    require('includes/site-navigation.php');
    require('includes/wc-custom.php');

    // Add Styles & Scripts
    add_action( 'wp_enqueue_scripts', 'slck_scripts_and_styles', 999 );

}

add_action('after_setup_theme', 'slck_start_theme');

// Shop API extension
require('includes/shop-api.php');
