/* --------------------------------
 | Shop
 * ------------------------------*/

// Required

var PROD_GALLERY = require('../plugins/surgeSlider.min.js');
var CUSTOMSELECT = require('../plugins/jquery.customSelect.min.js');

// Init
var init = function(){

    // Cache elements
    setEl();

    // Bind events
    bindEvents();

    // Product slider
    $el.productSlider.surgeSlider({
        thumb: '.thumbnails',
        thumb_show: 3,
        thumb_gutter: 10,
        pager: '.pager',
    });

};

// Elements
var $el = {};

var setEl = function(){

    $el = {
        addToCart: $('.js-add-to-cart'),
        formAddToCart: $('form.js-single-cart-form'),
        cartCount: $('.js-cart > .count'),
        cartNotice: $('.js-cart > .cart-notice'),
        quantityPlus: $('.js-quantity > .plus'),
        quantityMinus: $('.js-quantity > .minus'),
        shippingState: $('#calc_shipping_state_field'),
        productSlider: $('.js-product-slider'),
    };

}

// Private functions

var data = {},
    noticeTimer,
    ajaxing;

var bindEvents = function(){

    //Single add to cart
    $el.addToCart.on('click', updateCart);

    //Form add to cart
    $el.formAddToCart.on('submit', updateCart);

    //Quantity counter
    $el.quantityPlus.on('click', updateQuantity).dblclick(function(e){
        e.preventDefault();
    });
    $el.quantityMinus.on('click', updateQuantity).dblclick(function(e){
        e.preventDefault();
    });

};

// Ajaxify cart
var updateCart = function(e){

    if (typeof e !== 'undefined') e.preventDefault();

    if (ajaxing) return false;

    ajaxing = true;

    var _this = $(this);
    var $btn = _this;

    data = {}; // clear data variable

    // If is form or single button
    if (_this.is('form')) {

        $btn = _this.find('button');

        quantity = _this.find('.quantity > input[type="text"]').val();

        $btn.attr('data-quantity', quantity);
        $btn.data('quantity', quantity);

    }

    data = {
        'add-to-cart': $btn.data('product_id'),
        'quantity': $btn.data('quantity')
    };

    $btn.addClass('is-loading').prop('disabled', true);

    $.each( $btn.data(), function(key, value) {
        data[key] = value;
    });

    $.post(window.location.href, data, function(response){
        updateHeaderCart($btn);
    });

};

var updateCartNotice = function(response){

    clearTimeout(noticeTimer);

    $el.cartNotice.find('strong').text(response.quantity + ' ' + response.product_title);

    $el.cartNotice.addClass('is-visible');

    noticeTimer = setTimeout(function(){
        $el.cartNotice.removeClass('is-visible');
    }, 5000);

};

var updateHeaderCart = function($link){

    $.post(woocommerce_params.ajax_url, {'action': 'shop_get_cart_count'}, function(response){
        if ( $el.cartCount.text(response.cart_count) ) updateCartNotice(data), $link.removeClass('is-loading').prop('disabled', false), ajaxing = false;
    });

};

var updateQuantity = function(e){

    if (typeof e !== 'undefined') e.preventDefault();

    var input = $(this).parent().find('input[type="text"]');
        quantity = parseInt( input.val() );

    var add = ( $(this).hasClass('plus') ) ? 1 : -1;
    var num = quantity + add;

    (num >= 1) ? input.val(num).attr('value', num) : input.val(1).attr('value', 1);

}

// On Resize
var resize = function(){
    // Resize events go here...
};

// On Scroll
var scroll = function(){
    // Scroll events go here...
};

module.exports = {
    init: init,
    resize: resize,
    scroll: scroll,
};
