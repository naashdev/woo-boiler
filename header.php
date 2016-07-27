<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<!--[if gt IE 9]><!-->
<html>
<!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>A Boilerplate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <?php wp_head(); ?>
  </head>
  <body>
    <header class="header">
      <div class="grid">
        <a class="logo" href="#">
          <span class="hide-text">Logo</span>
        </a>
        <nav class="main-navigation js-main-nav" role="navigation">
          <ul class="nav">
            <li><a href="<?php echo site_url(); ?>">Shop</a></li>
            <li><a href="<?php echo site_url() . '/product-category/posters'; ?>">Posters</a></li>
            <li><a href="<?php echo site_url() . '/product-category/clothing'; ?>">Clothing</a></li>
          </ul>
        </nav>
        <a class="header-cart js-cart" href="<?php echo WC()->cart->get_cart_url(); ?>">
            <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            <div class="cart-notice">
                You have added
                <strong></strong>
                to your cart.
            </div>
        </a>

        <a class="menu-ctrl js-menu-ctrl" href="#">
          <span class="line line1"></span>
          <span class="line line2"></span>
          <span class="line line3"></span>
          <span class="hide-text">Menu</span>
        </a>
      </div>
    </header>
