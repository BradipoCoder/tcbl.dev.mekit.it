/**
 * TCBL Company
 */

(function ($, Drupal) {
  Drupal.behaviors.company = {

    attach: function (context, settings) {
      this.tabs = $('#company-tabs');
      this.tlinks = $('.company-tabs__a', this.tabs);
      this.panels = $('.company-contents__panel');
      this.slider = false;

      var me = this;

      $('#company-head').once('companyOnce', function(){
        me.setUpSlider();
        me.armCompanyTabs();
        me.checkForHash();
      });
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

        // Refresh the slider
        if (id == 'about'){
          me.slider.refresh();
        }

      });
    },

    setUpSlider: function(){
      var me = this;
      this.domSlider = $('#company-slider');
      this.domSlider.imagesLoaded(
        function(){
          me.createSlider();  
        }
      );
    },

    createSlider: function(){
      var options = {
        item:  2,
        mode: 'slide',
        loop: false,
        slideMargin: 10,
        slideMove: 1,
        slideEndAnimation: false,
        auto: true,
        autoWidth: true,
        speed: 2000,
        pause: 10000,
        prevHtml: '<i class="fa fa-lg fa-angle-left"></i>',
        nextHtml: '<i class="fa fa-lg fa-angle-right"></i>',
        controls: false,
        pager: true,
      };
      this.slider = this.domSlider.lightSlider(options);
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
