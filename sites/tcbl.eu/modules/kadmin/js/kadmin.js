jQuery().ready(function(){
  var menuWidth=0;
  jQuery('ul.kadmin-menu > li').map(function(){
      menuWidth = menuWidth + jQuery(this).outerWidth(true);
  });
  // + 2px as fix
  jQuery('.kadmin-menu').css('width', (menuWidth + 120));
});