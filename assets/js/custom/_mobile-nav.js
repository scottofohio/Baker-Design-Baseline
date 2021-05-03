/**
 * General JavaScripture
 * @package WordPress
 * @subpackage BakerDesign
 * @since 2.0
 **/


 Project.mobileNav = function() {
  $('.hamburger').on('click',function(){
    $(this).toggleClass('active');
    $(this).siblings('nav').toggleClass('active');
  });

  // $('menu-toggle').
  
  
  

  $('.menu-toggle').on('click',function(){
    $(this).toggleClass('active');
    $(this).siblings('.inline-page-nav').toggleClass('active');
  });
};