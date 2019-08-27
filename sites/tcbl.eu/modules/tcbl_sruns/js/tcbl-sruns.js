/**
 * TCBL SHORT RUNS
 */

(function ($, Drupal) {
  Drupal.behaviors.tcblSruns = {

    attach: function (context, settings) {
      var me = this;
      // me.archiveId = Drupal.settings.tcbl_comps.id;
      // copy object without referencing it
      // me.defaultFilters = Object.assign({}, me.filters);

      $('body', context).once('tcblSruns').each(function(){
        me.setUp('firstTime');
      });
    },

    // ** SET UP **
    // ------------
    
    setUp: function(mode){
      if (mode == 'firstTime'){
        this.armTopic();
        this.armYes();
        this.armNo();
        this.armSkip();
      }
    },

    // ** ARM **
    // ---------
    
    armTopic: function(){
      $('.li-topic').click(function(){
        var tid = $(this).attr('data-tid');
        
        $('.li-topic').removeClass('open');
        $('.question').addClass('hide');
        $('.results').addClass('hide');

        // Topic active
        var li = $('#li-topic-' + tid);
        li.addClass('open');

        var question = $('#question-' + tid);
        question.removeClass('hide');
      });  
    },

    armYes: function(){
      $('.bts-yes').click(function(){
        var tid = $(this).attr('data-tid');
        var li = $('#li-topic-' + tid);
        li.addClass('done').removeClass('skip');
      })
    },

    armNo: function(){
      $('.bts-no').click(function(){
        $('.results').addClass('hide');
        var tid = $(this).attr('data-tid');
        var li = $('#li-topic-' + tid);
        li.removeClass('done').removeClass('skip');
        var result = $('#result-' + tid);
        result.removeClass('hide');
      })
    },

    armSkip: function(){
      $('.bts-skip').click(function(){
        var tid = $(this).attr('data-tid');
        var li = $('#li-topic-' + tid);
        li.addClass('done').addClass('skip');  
      });
    },

    // ** ACTIONS **
    // -------------

    /**
     * Scroll to the archive
     */
    scrollToTop: function(){
      var element = Drupal.settings.tcbl_comps.scrollToElement;
      scrollTo(element);
    }
  };
})(jQuery, Drupal);
