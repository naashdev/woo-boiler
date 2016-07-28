<?php
//----------------------------------------------------------------------------------
// Register navigation
//----------------------------------------------------------------------------------
function utl_register_navigation() {
  register_nav_menus(
    array(
      'header-nav' => __( 'Header Navigation' ),
    )
  );
}
add_action( 'init', 'utl_register_navigation' );


//----------------------------------------------------------------------------------
// Navigation filters
//----------------------------------------------------------------------------------

// Remove ID's from nav html
function utl_css_attributes_filter($var) {
  return is_array($var) ? array() : '';
}
add_filter('nav_menu_item_id', 'ca_css_attributes_filter', 100, 1);

// Add active class
function utl_active_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'is-active ';
     }
     return $classes;
}
add_filter('nav_menu_css_class' , 'utl_active_nav_class' , 11 , 2);
