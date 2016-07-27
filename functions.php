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


//----------------------------------------------------------------------------------
// Theme Setup
//----------------------------------------------------------------------------------

function wp_start_theme() {

    // Required
    //require('includes/wp-custom.php');
    require('includes/wc-custom.php');

    // Add Styles & Scripts
    add_action( 'wp_enqueue_scripts', 'wp_scripts_and_styles', 999 );

}

add_action('after_setup_theme', 'wp_start_theme');

// Shop API extension
require('includes/shop-api.php');
