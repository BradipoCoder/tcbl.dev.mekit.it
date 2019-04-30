// Set up slider
jQuery().ready(function(){

  // Nascondo temporaneamente lo slider per evitare di vedere le immagini giganti
  // jQuery('.wrapper-lightslider').css('height', 0).css('overflow', 'hidden');
  // jQuery('.wrapper-lightslider').removeClass('hide');

  jQuery('.lightslider').each(function(){
    var id = jQuery(this).attr('data-lsid');
    armSlider(id);
  });

});

function armSlider(id){
  var selector = '.lightslider-' + id;
  var options = Drupal.settings.lightslider[id];

  var wrapper = jQuery('.wrapper-lightslider-' + id);
  wrapper.css('height', 0).css('overflow', 'hidden');

  // Quando tutte le immagini sono caricate
  jQuery(selector).imagesLoaded(function(){
    options.onSliderLoad = function(el){
      
      // Height fix https://github.com/sachinchoolur/lightslider/issues/271
      var maxHeight = 0,
      container = jQuery(el),
      children = container.children();

      children.each(function () {
        var childHeight = jQuery(this).height();
        if (childHeight > maxHeight) {
            maxHeight = childHeight;
        }
      });
      container.height(maxHeight);

      wrapper.attr('style','').hide().slideDown(1000, function(){
        wrapper.attr('style','');  
      });
    };
    var slider = jQuery(selector).lightSlider(options);
  });
    
}
