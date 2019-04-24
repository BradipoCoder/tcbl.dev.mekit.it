/**
 * TCBL Company Key Activities
 */

(function ($, Drupal) {
  Drupal.behaviors.companyKas = {

    attach: function (context, settings) {
      this.heads = $('.company-kas__head');
      this.items = $('.company-kas__item');

      this.armKasHeads();
    },

    /**
     * Armo funzionalità tabs
     * @todo : add fragment
     */
    armKasHeads: function(){
      var heads = this.heads;
      var me = this;
      heads.click(function(){
        var id = $(this).attr('data-tid');
        me.openTab(id);  
      });
    },

    /**
     * Open the tab
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    openTab: function(id){
      var items = this.items;
      var item = $('#company-kas-item-' + id);
      if (!item.hasClass('open')){
        items.removeClass('open');
        item.addClass('open');
      }  
    }

  };
})(jQuery, Drupal);
