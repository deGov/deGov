/**
 * @file nrw_menu.js
 *
 * Defines the behavior of the NRW Menu module.
 */
(function ($, Drupal) {

  'use strict';

  /**
   * Collapsible/Expandable menu behaviour
   */
  Drupal.behaviors.nrw_menu = {
    attach: function (context, settings) {
      // do nothing if there is no menu__header on the page
      if ($('.nrw-menu__header', context).length == 0) {
        return;
      }
      // on click add the class to siblings
      /*$('.nrw-menu-header__col .nrw-menu__header', context).click(function (e) {
        e.preventDefault();
        // remove the class from all the content containers in the menu
        // add the class only to the sibling of the active menu__header
        var parent = $(this).closest('.nrw-menu-header__col');
        if ($(this).siblings('.nrw-menu-header__content').hasClass("is-expanded")) {
          $(this).parent().removeClass('is-open');
          $(this).siblings('.nrw-menu-header__content').removeClass("is-expanded");
        } else {
          $('.nrw-menu-header__col').removeClass('is-open');
          $('.nrw-menu-header__content').removeClass("is-expanded");
          $(this).parent().addClass('is-open');
          $(this).siblings('.nrw-menu-header__content').addClass("is-expanded");
        }
      });
        */
      //hover in first level to open menu

      /*
      $('.nrw-menu-header__icon').hover(function(){
        var classes = $(this).prop("classList");
        var lastEl = classes[classes.length-1];
        
        $('.nrw-menu-header__col').removeClass('is-active');
        if($('.nrw-menu-header__col').hasClass(lastEl)){
          console.log(lastEl);
          console.log($(this));
          $('.nrw-menu-header__col.'+lastEl).addClass('is-active')
        }

      });

      */

      //hover in second level to open menu
      $('.nrw-menu-header__col').hover(function(){
        $(this).toggleClass('is-open');
        $(this).find('.nrw-menu-header__content').toggleClass('is-expanded');
      });
      //clic on first level to open menu
      $('.nrw-menu-header__icon').click(function(){
        var classes = $(this).prop("classList");
        var lastEl = classes[0];
    
        $('.nrw-menu-header__col').removeClass('is-active');
        if($('.nrw-menu-header__col').hasClass(lastEl)){
          $('.nrw-menu-header__col.'+lastEl).addClass('is-active')
        }

      });
      // close menu
      $('.nrw-menu__content-close a', context).click(function (e) {
        $(this).parent().parent().parent().removeClass('is-expanded');
      });
    }
  }
  Drupal.behaviors.doubleTap = {
    attach: function (context, settings) {
      $('.nrw-menu-header__icon').each(
      function(i) {
          var classes = this.className.split(/\s+/);
          for (var i=0,len=classes.length; i<len; i++){
              if ($('.nrw-menu-header__col').hasClass(classes[i])){
                  $(this).addClass('has-children');
              }
          }
      });

      $('.has-children').doubleTapToGo();
      $('.nrw-menu__header-link-area').doubleTapToGo();
    }
  };
  // Responsive menu
  Drupal.behaviors.responsiveMenu = {
    attach: function (context, settings) {
      $('.header__menu-icon').click(function () {
        $('.nrw-menu-header-responsive').toggleClass('is-open');
      });
      $('.nrw-menu-header-responsive .nrw-menu-header-responsive__block-title').click(function () {
        $(this).toggleClass('is-close is-open');
        $(this).siblings('.nrw-menu-header-responsive__content').toggleClass('is-close is-open');
      });
      $('.nrw-menu-header-responsive .action').click(function () {
        $(this).parent().siblings('.nrw-menu-header-responsive__list').toggleClass('is-open');
        $(this).toggleClass('is-open');
      });
    }
  };

})(jQuery, Drupal);