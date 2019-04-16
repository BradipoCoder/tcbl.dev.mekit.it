/**
 * TCBL LABS
 */

(function ($, Drupal) {
  Drupal.behaviors.tcblLabs = {

    attach: function (context, settings) {
      // Using once() to apply the myCustomBehaviour effect when you want to do just run one function.
      // $('body', context).once('myCustomBehavior').addClass('well');
      me = this;

      me.filters = [];
      me.context = context;
      me.settings = settings;
    
      this.armFilters();
    },

    /**
     * Arm labs filter
     * @return {[type]} [description]
     */
    armFilters: function(){
      var filter = jQuery('#labs-filters');
      var select = jQuery('.labs-select', filter);
      var search = jQuery('#labs-search', filter);
      var searchButton = jQuery('#search-button', filter);

      select.change(function(e){
        var item = jQuery(this);
        var name = item.attr('name');
        var value = item.val();
        me.filters[name] = value;
        me.reloadAll();
      });

      searchButton.click(function(){
        var value = search.val();
        me.filters['key'] = value; 
        me.reloadAll();
      });

      // Return key
      search.keydown(function(event){
        if(event.keyCode == 13) {
          var value = search.val();
          if (value == ''){
            value = 'false';
          }
          me.filters['key'] = value;
          me.reloadAll();

          // Faccio il refresh dell'archivio
          search.blur();
        }
      });  
    },

    /**
     * Reload all labs list
     * @return {[type]} [description]
     */
    reloadAll: function(){
      console.debug(me.filters);
    },
  };
})(jQuery, Drupal);
