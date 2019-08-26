Project.utilityToggle = function () {
  $('.utility-toggle').on('click', function(){
  $(this).children('.dropdown-menu').toggle();
  });

  $(window).on('keyup', function(e){
    if(e.keyCode == 27) {
      $('.utility-toggle').attr('open', false);
    }
  });

  $('#maincontent').on('click', function(){
    $('.utility-toggle').attr('open', false);
  });
};