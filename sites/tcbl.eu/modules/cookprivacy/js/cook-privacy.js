/**
 * Cook Privacy
 */

jQuery().ready(function(){

  var cookie = Cookies.get('cookie-agree');

  if (cookie == undefined){
    // Show message
    msg = Drupal.settings.cookprivacy.msg;
    jQuery('.wrapper-content .main-container').prepend(msg);
    jQuery('.wrapper-cookie').removeClass('hide');
    armCookieAgree();
  }

});

function armCookieAgree(){
  jQuery('#cookie-agree').click(function(e){
    e.preventDefault();
    Cookies.set('cookie-agree', 'ok', {expires: 90});
    jQuery('.wrapper-cookie').fadeOut();
  }); 
}


