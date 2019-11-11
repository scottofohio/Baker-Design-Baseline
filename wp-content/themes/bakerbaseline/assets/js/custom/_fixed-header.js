Project.fixedHeader = function () {
  $(window).on('scroll load', function(){
    // console.log();
  
    if($(this).scrollTop() > 45) {
      $('.site-header').addClass('fixed');
      $('.hero').addClass('fixed-header');
    } else {
      $('.site-header').removeClass('fixed');
      $('.hero').removeClass('fixed-header');
    }
  });
};