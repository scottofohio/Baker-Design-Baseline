Project.splitHeight = function () {
  $(window).on('load resize', function () {
    
      $('.split-text-block').each(function () {
        if ($(this).width() > 768) {
        // console.log($(this).find('img'));
        img = $(this).find('img')[0];
        console.log(img.clientHeight);
        $(this).find('figure').css({
          'height': img.clientHeight,
          'overflow': 'hidden'
        });
        } else {
          $(this).find('figure').css({
            'height': 'auto',
            'overflow': 'visible'
          });
        }
      });
   
  });
};