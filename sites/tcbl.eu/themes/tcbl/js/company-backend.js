/**
 * TCBL Company Key Activities
 */

(function ($, Drupal) {
  Drupal.behaviors.companyBackend = {

    attach: function (context, settings) {
      this.buildSameh();
      this.armMessage();  
    },

    buildSameh: function(){
      var tabs = $('.group-10 .horizontal-tab-button a, .vertical-tab-button a');
      tabs.click(function(){
        var panel = $('.htab-grid-3, .htab-grid-4').not('.horizontal-tab-hidden');
        console.debug(panel);
        $('fieldset', panel).sameh();
      });
    },

    armMessage: function(){
      var kas = $('#edit-field-ref-kas-und');
      kas.change(function(e){
        var help = $('#kas-help');
        var text = '<div id="kas-help"><span class="label label-warning">After saving, additional fields will be available for the enabled sections.</span></div>';
        var destination = $('.form-item-field-ref-kas-und .help-block');
        if (help.length !== 1){
          destination.append(text);
        }
        
      })
    }
  };
})(jQuery, Drupal);
