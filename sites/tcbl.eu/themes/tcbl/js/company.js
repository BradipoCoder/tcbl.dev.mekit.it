/**
 * TCBL Company
 */

(function ($, Drupal) {
  Drupal.behaviors.company = {

    attach: function (context, settings) {
      this.tabs = $('#company-tabs');
      this.tlinks = $('.company-tabs__a', this.tabs);
      this.panels = $('.company-contents__panel');

      this.armCompanyTabs();
      this.checkForHash();
    },

    /**
     * Armo funzionalità tabs
     * @todo : add fragment
     */
    armCompanyTabs: function(){
      var links = this.tlinks;
      var me = this;
      links.click(function(){
        var id = $(this).attr('data-id');
        me.openTab(id);  
      });
    },

    /**
     * Check for hash presence
     */
    checkForHash: function(){
      if(window.location.hash) {
        var id = window.location.hash.substr(1);
        this.openTab(id);
      }
    },

    /**
     * Open the tab
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    openTab: function(id){
      var link = $('#company-tabs-a-' + id);
      var panel = $('#company-contents--' + id);
      var links = this.tlinks;
      var panels = this.panels;

      if (!link.hasClass('open')){
        links.removeClass('open');
        panels.removeClass('open');
        link.addClass('open');
        panel.addClass('open');
      }  
    }

  };
})(jQuery, Drupal);
