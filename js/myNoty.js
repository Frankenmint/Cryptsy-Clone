$.noty.layouts.bottomLeft = {
  name: 'bottomLeft',
    options: { // overrides options

    },
    container: {
      object: '<ul id="noty_bottomLeft_layout_container" />',
      selector: 'ul#noty_bottomLeft_layout_container',
      style: function() {
        $(this).css({
          bottom: 20,
          left: 20,
          position: 'fixed',
          width: '310px',
          height: 'auto',
          margin: 0,
          padding: 0,
          listStyleType: 'none',
          zIndex: 10000000
        });

        if (window.innerWidth < 600) {
          $(this).css({
            left: 5
          });
        }
      }
    },
    parent: {
      object: '<li />',
      selector: 'li',
      css: {}
    },
    css: {
      display: 'none',
      width: '310px'
    },
    addClass: ''
  };

  $.noty.defaults = {
    layout: 'bottomLeft',
    theme: 'defaultTheme',
    type: 'success',
    text: '', // can be html or string
    dismissQueue: true, // If you want to use queue feature set this true
    template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
    animation: {
      open: {height: 'toggle'},
      close: {height: 'toggle'},
      easing: 'swing',
        speed: 500 // opening & closing animation speed
      },
    timeout: false, // delay for closing event. Set false for sticky notifications
    force: false, // adds notification to the beginning of queue when set to true
    modal: false,
    maxVisible: 5, // you can set max visible notification for dismissQueue true option,
    killer: false, // for close all notifications before show
    closeWith: ['click'], // ['click', 'button', 'hover']
    callback: {
      onShow: function() {},
      afterShow: function() {},
      onClose: function() {},
      afterClose: function() {}
    },
    buttons: false // an array of buttons
  };