import {domReady} from '@roots/sage/client';

/**
 * app.main
 */
const main = async (err) => {
  if (err) {
    // handle hmr errors
    console.error(err);
  }

  // application code
};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);

// AOS
import AOS from 'aos'
// Alpine
import Alpine from 'alpinejs'
import $ from 'jquery'
// import validate from 'jquery-validation'
require ('./validate.min.js')
import 'slick-carousel'


(function ($) {
  "use strict";

$(document).ready(function(){

  AOS.init({once: true});
  $(window).on("scroll", function () {
    AOS.init({once: true});
  });
  
  $('.js-carousel').slick();
  
  var btnBackToTop = $('.btn-back-top');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
    btnBackToTop.removeClass('hidden');
    } else {
    btnBackToTop.addClass('hidden');
    }
  });

  btnBackToTop.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
  });

  $('.menu-toggler').on('click', function(){
    $('body').toggleClass('overflow-hidden md:overflow-visible');
  });
  
  $(".form").validate({
    errorPlacement: function ( error, element ) {
      if ( element.prop( "type" ) === "checkbox" ) {
        error.insertAfter( element.parent( "div" ) );
      } else {
        error.insertAfter( element );
      }
    }
  });
  $('.form .form-control').on('blur', function() {
    if( !$(this).val() ) {
      $(this).removeClass("not-empty");
    } else{
      $(this).addClass("not-empty");
    }
  });
});

})(jQuery);
