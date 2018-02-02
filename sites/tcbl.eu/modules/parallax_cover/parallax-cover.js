// Animazioni Cover
jQuery().ready(function(){
  //
  //jQuery('.wrapper-parallax').imagesLoaded(function() {
  //  center_cover_text();
  //});
  //
  //jQuery(window).resizeend({
  //  onDragStart : function(){
  //  },
  //  onDragEnd : function() {
  //    // alla fine del ridimensionamento
  //    center_cover_text();
  //  },
  //  runOnStart : false
  //  }
  //);
});

function center_cover_text(id){
  var wrapper = jQuery('.wrapper-parallax');
  jQuery('.over-parallax').attr('style','').hide();

  var wrapper = jQuery('.wrapper-parallax');
  var caption = jQuery('.wrapper-parallax .over-parallax');
  
  var wrapper_h = wrapper.outerHeight();
  var caption_h = caption.outerHeight();


  var top = (wrapper_h - caption_h) / 2;
  if (top < 0){
    top = 10;
    caption.css('maxHeight', (wrapper_h - 20) + 'px');
    caption.css('overflow', 'hidden');
  }

  caption.css('marginTop', top + 'px'); // + 85
  caption.delay(800).fadeIn();
}