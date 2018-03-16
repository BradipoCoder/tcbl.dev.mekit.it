/**
 * TCBL Events functionality
 */
jQuery().ready(function(){
  tcblMoveEventsBanner();
});

function tcblMoveEventsBanner(){
  if (jQuery('#event-banner').length == 1){
    jQuery('#event-banner').insertAfter('.views-row-6').removeClass('hide');
  }
}