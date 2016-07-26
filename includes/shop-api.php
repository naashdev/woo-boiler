<?php

class ShopAPI {

    /**
	 * Hook in ajax handlers.
	 */
	public function __construct() {
        add_action( 'wp_ajax_shop_get_cart_count', array($this, 'shop_get_cart_count' ) );
        add_action( 'wp_ajax_nopriv_shop_get_cart_count', array($this, 'shop_get_cart_count' ) );
	}

    /**
	 * Get cart count.
	 */
    public function shop_get_cart_count() {
        $data = array(
            'cart_count' => WC()->cart->get_cart_contents_count()
        );
        wp_send_json( $data );
        die();
    }

}

new ShopAPI();
