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
        // name: $(selector)
    };

}

// Private functions
var _bindEvents = function(){

};

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
