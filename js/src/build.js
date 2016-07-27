/* --------------------------------
 | Modules
 * ------------------------------*/

var NAV = require('./modules/navigation');
var FORMS = require('./modules/forms');
var SHOP = require('./modules/shop');

/* --------------------------------
 | Config
 * ------------------------------*/

var _config = {
    docReady: function(){
        // Document ready JS goes here...
        // Environment vars
        $BODY = $('body');
        $HTML = $('html');
        $WINDOW = $(window);
        _setEnv();

        // Other global settings
        EASING = {
            easing: 'easeInOut'
        };

        // Global Events
        _bindEvents();

        // Modules
        NAV.init();
        FORMS.init();
        SHOP.init();

    },

    onResize: function(){
        // Resize events go here...
        _setEnv();
        NAV.resize();
    },

    onScroll: function(){
        // Scroll events go here...
        NAV.scroll();
    },

}

// Functions
var _setEnv = function() {
    VPW = $WINDOW.width();
    ISMOBILE = VPW < 768;
    NOTMOBILE = VPW > 767;
};

var _bindEvents = function(){
    // Resize listener
    $WINDOW.resize(function() {
        _config.onResize();
    });

    // Scroll listener
    $WINDOW.scroll( function() {
        _config.onScroll();
    } );
};

// Document ready
$(function(){
    _config.docReady();
});
