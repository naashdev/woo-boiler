// Required
// .....

// Init
var _init = function(){

    // Cache elements
    _setEl();

    // Bind events
    _bindEvents();

};

// Elements
var $el = {};

var _setEl = function(){

    $el = {
        header: $('.header'),
        nav: $('.header .js-main-nav'),
        navLi: $('.header .main-navigation > ul > li'),
        subnavs: $('.header .main-navigation .submenu'),
        openNav: $('.header .js-menu-ctrl, .header .main-navigation .js-submenu-ctrl'),
        cartNotice: $('.header .js-cart .cart-notice')
    };

}

// Private functions
var _bindEvents = function(){

    //Toggle nav
    $el.openNav.on('click', _toggle);

};

var _toggle = function(e){

    if (typeof e !== 'undefined') e.preventDefault();

    if ($(this).hasClass('js-menu-ctrl')) {

        $el.cartNotice.removeClass('is-visible');

        if ($BODY.hasClass('nav-open')) {
            // Close subnavs
            $el.subnavs.slideUp();
            $el.navLi.removeClass('is-open');
        }

        // Open main nav
        $el.nav.slideToggle(400);
        $BODY.toggleClass('nav-open');


    } else {

        var parent = $(this).closest('li'),
            subnav = parent.find('.submenu');

        // Close all sub navs
        $el.navLi.not(parent).removeClass('is-open');
        $el.subnavs.not(subnav).slideUp(400);

        // Open sub nav
        parent.toggleClass('is-open');
        subnav.slideToggle(400);

    }

};

var _checkFixed = function(){
    var scroll = $WINDOW.scrollTop();
    if (scroll > $el.header.height() ) {
        $BODY.addClass('nav-fixed');
        setTimeout(function(){
            $BODY.addClass('nav-animate')
        }, 200);
    } else {
        $BODY.removeClass('nav-animate').removeClass('nav-fixed');
    }
};

// On Resize
var _resize = function(){
    // Resize events go here...
};


// On Scroll
var _scroll = function(){
    // Scroll events go here...
    _checkFixed();
};


module.exports = {
    init: _init,
    resize: _resize,
    scroll: _scroll,
};
