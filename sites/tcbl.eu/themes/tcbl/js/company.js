/**
 * TCBL Company
 */
jQuery().ready(function(){
 
  armCompanyTabs();

  /**
   * Armo funzionalità tabs
   * @todo : add fragment
   */
  function armCompanyTabs(){
    var tabs = jQuery('#company-tabs');
    var links = jQuery('.company-tabs__a', tabs);
    var panels = jQuery('.company-contents__panel');

    links.click(function(){
      var link = jQuery(this);
      var id = link.attr('data-id');
      var panel = jQuery('#company-contents--' + id);

      if (!link.hasClass('open')){
        links.removeClass('open');
        panels.removeClass('open');
        link.addClass('open');
        panel.addClass('open');
      }
    });

  }
});
