/**
 * General JavaScripture
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 **/

Project.mobileNav = function () {
  $('.navbar-toggler').on('click', function () {
    $(this).find('.navbar-toggler-icon').toggleClass('active');
    $(this).siblings('.navbar-collapse').slideToggle('1000');
    $(this).closest('header').toggleClass('active');
  });

  $(window).on('load resize', function () {
    if ($(this).width() < 1070) {
      if (!$('.drop-toggle').length) {
        $('.site-header .navbar-nav > li').each(function () {
          topLink = $(this).children('a');
          topLevelLink = '<li class="nav-link"><a href="' +
          topLink.attr('href') + '" class="dropdown-item overview-link">' +
          topLink.text() + ' Overview' + '</a></li>';
          $(this).prepend('<button class="drop-toggle">' + topLink.text() + '</button>');
          $(this).children('ul').prepend(topLevelLink);
          topLink.hide();   
        });
        $('.site-header .navbar-nav > li').delegate('.drop-toggle', 'click', function() {
          // console.log(this);
          $(this).toggleClass('active');
          $(this).siblings('ul.dropdown-menu').slideToggle();
        });
      }
    } else {
      if ($('.drop-toggle').length) {
        $('.drop-toggle').remove(); 
        $('.site-header .navbar-nav > li > a').show();
      }
    }
  });

  $('nav.footer-nav > .nav > li > a').on('click', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    $(this).siblings('ul.sub-menu').slideToggle();
});

  $('.navbar-nav > li').each(function(){
    if ($(window).width() > 1070) {

    width = $(this).innerWidth() / 2;
    $(this).children('.dropdown-menu').css({
      'left' : -width
    });
    }
  }); 

};