/* --------------------------------
 | Shop
 * ------------------------------*/

// Required

var PROD_GALLERY = require('../plugins/surgeSlider.min.js');
var CUSTOMSELECT = require('../plugins/jquery.customSelect.min.js');

// Init
var _init = function(){

    // Cache elements
    _setEl();

    // Bind events
    _bindEvents();

    // Product slider
    $el.productSlider.surgeSlider({
        thumb: '.js-product-slider .thumbnails',
        thumb_show: 3,
        thumb_gutter: 10,
        active_class: 'is-active',
        pager: '.js-product-slider .pager',
    });

};

// Elements
var $el = {};

var _setEl = function(){

    $el = {
        addToCart: $('.js-add-to-cart'),
        formAddToCart: $('form.js-single-cart-form'),
        cartCount: $('.js-cart > .count'),
        cartNotice: $('.js-cart > .cart-notice'),
        quantityPlus: $('.js-quantity > .plus'),
        quantityMinus: $('.js-quantity > .minus'),
        shippingState: $('#calc_shipping_state_field'),
        productSlider: $('.js-product-slider .images'),
        productSliderToggle: $('.js-product-slider .slider-controls > .next, .js-product-slider .slider-controls > .prev')
    };

}

// Private functions

var data = {},
    noticeTimer,
    ajaxing;

var _bindEvents = function(){

    //Single add to cart
    $el.addToCart.on('click', _updateCart);

    //Form add to cart
    $el.formAddToCart.on('submit', _updateCart);

    // Next & Prev buttons for slider
    $el.productSliderToggle.on('click', _toggleSlider);

    // Bind cart table events
    _bindCart();

    // Rebind events on .woocommerce div udate
    $(document.body).on( 'updated_wc_div', _bindCart);

};

var _bindCart = function(){

    //Quantity counter
    $('.js-quantity > .plus').on('click', _updateQuantity).dblclick(function(e){
        e.preventDefault();
    });
    $('.js-quantity > .minus').on('click', _updateQuantity).dblclick(function(e){
        e.preventDefault();
    });

};

// Ajaxify cart
var _updateCart = function(e){

    if (typeof e !== 'undefined') e.preventDefault();

    if (ajaxing) return false;

    ajaxing = true;

    var _this = $(this);
    var $btn = _this;

    data = {}; // clear data variable

    // Ensure cart notice isn't open
    $el.cartNotice.removeClass('is-visible');

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
        _updateHeaderCart($btn);
    });

};

var _updateCartNotice = function(response){

    clearTimeout(noticeTimer);

    $el.cartNotice.find('strong').text(response.quantity + ' ' + response.product_title);

    $el.cartNotice.addClass('is-visible');

    noticeTimer = setTimeout(function(){
        $el.cartNotice.removeClass('is-visible');
    }, 5000);

};

var _updateHeaderCart = function($link){

    $.post(woocommerce_params.ajax_url, {'action': 'shop_get_cart_count'}, function(response){
        if ( $el.cartCount.text(response.cart_count) ) _updateCartNotice(data), $link.removeClass('is-loading').prop('disabled', false), ajaxing = false;
    });

};

var _updateQuantity = function(e){

    if (typeof e !== 'undefined') e.preventDefault();

    var input = $(this).parent().find('input[type="text"]');
        quantity = parseInt( input.val() );

    var add = ( $(this).hasClass('plus') ) ? 1 : -1;
    var num = quantity + add;

    (num >= 1) ? input.val(num).attr('value', num) : input.val(1).attr('value', 1);

}

// Toggle slider
var _toggleSlider = function(e){

    if (typeof e !== 'undefined') e.preventDefault();

    var trigger = ($(this).hasClass('next')) ? 'surge-slider-next' : 'surge-slider-prev';

    $el.productSlider.trigger(trigger);

}

// On Resize
var _resize = function(){
    // Resize events go here...
};

// On Scroll
var _scroll = function(){
    // Scroll events go here...
};

module.exports = {
    init: _init,
    resize: _resize,
    scroll: _scroll,
};
