/**
 * TCBL Basic fuctionalities
 */
jQuery().ready(function(){
  tcblArmCollapsibleList();
});

function tcblArmCollapsibleList(){
  jQuery('ul.ul-collapsible').each(function(i){
    var id = 'ul-coll-' + i;
    var selector = '#' + id;
    var ul = jQuery(this);
    ul.attr('id', id);

    var n = jQuery('li', ul).length - 3;


    jQuery(selector).append('<span class="ul-collapsible-toggle"><span class="ul-coll-more">' + n + ' more</span><span class="ul-coll-close">Close</span></span>');

    var toggle = jQuery('.ul-collapsible-toggle', selector);
    jQuery(toggle).click(function(){

      if (jQuery(selector).hasClass('open')){
        scrollTo(selector, -130);
      }

      jQuery(selector).toggleClass('open');
    })
  })
}