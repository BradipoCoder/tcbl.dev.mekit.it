/**
 * 
 */

jQuery().ready(function(){
  if (jQuery('body').hasClass('front')){
    
    /**
     * Il tutto racchiuso in un if, disattivo nel mobile mobile
     * Al click sul menu, cerco l'attributo nid nella voce, se esiste ed esiste il blocco, effettuo lo scroll
     * se trova la classe 'scroll_home_link_top' torna al top
     * altrimenti utilizzo il link originale
     */

    if (findBootstrapState() !== 'xs'){

      jQuery('.scroll-home-link').click(function(e){
        if (jQuery('.nav-bar-toggle')){
          e.preventDefault();
        }

        href = jQuery(this).attr('href');
        toolbar = jQuery('#toolbar').outerHeight();
        //console.debug(toolbar);
        navbar = jQuery('#navbar').outerHeight();
        //console.debug(navbar);
        //navbar = 0;

        if (jQuery(this).attr('nid')){
          nid = jQuery(this).attr('nid');
          anchor = '#scroll-home-anchor-' + nid;
          if (jQuery(anchor).length == 1 ){
            //esiste il blocco in home page
            jQuery('html, body').stop().animate({
              scrollTop: jQuery(anchor).offset().top - navbar - toolbar + 1
            }, 1000, 'easeOutQuad', function(){
              //alla fine dell'animazione
            });
            //active_item(nid);
          } else {
            //controllo se è il link home
            if (jQuery(this).hasClass('scroll-home-link-home')){
              jQuery('html, body').stop().animate({
                scrollTop: 0
              }, 1000, 'easeOutQuad');
            } else {
              //vai al link
              window.location = href;
            }
          }
        }
      });

      // trigger scroll della pagina
      jQuery(document).on("scroll", onScroll);

    }

  }
});

/**
 * funzione chiamata alla scroll della pagina
 * attiva o disattiva le voci del menu
 */
function onScroll(event){
  toolbar = jQuery('#toolbar').outerHeight();
  navbar = jQuery('#navbar').outerHeight();
  var scrollPos = jQuery(document).scrollTop() + navbar + toolbar + 100;

  jQuery('.scroll-home-link').each(function () {
    if (jQuery('.scroll-home-anchor-n-1').length > 0){
      var min_y = jQuery('.scroll-home-anchor-n-1').offset().top;
      if (scrollPos < min_y) {
        jQuery('.scroll-home-li').removeClass('active');
        jQuery('.scroll-home-li-home').addClass('active');
      } else {
        //se esiste il nid
        if (jQuery(this).attr('nid')){
          var nid = jQuery(this).attr('nid');
          //tralascio la home
          if (nid !== 'home'){
            var curr_li = jQuery('.scroll-home-li-' + nid);
            //controllo se il nodo è visualizzato
            if (jQuery('#scroll-home-anchor-' + nid).length > 0){
              var anchor = jQuery('#scroll-home-anchor-' + nid);
              var node = jQuery('#node-' + nid);
              var y = anchor.offset().top;
              var h = node.outerHeight();
              //console.debug(h);
              //se lo scroll è tra l'inizio e la fine della sezione
              if ((y <= scrollPos) && ( y + h > scrollPos )) { 
                jQuery('.scroll-home-li').removeClass('active');
                curr_li.addClass('active');
              }
            }
          } 
        }
      }
    }
  });
}