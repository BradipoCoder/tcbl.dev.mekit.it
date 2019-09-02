/**
 * TCBL SHORT RUNS
 */

(function ($, Drupal) {
  Drupal.behaviors.tcblSruns = {

    domUlTopics: false,
    domLiTopics: false,
    domQuestions: false,
    domResults: false,
    domProgress: false,
    domNext: false,

    topicsCount: false,

    data: {
      topics: {},
      current: false,
      progress: 0,
    },

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
        this.setUpVars();
        this.loadData();
        this.updateDom();

        this.armTopic();
        this.armButtons();
      }
    },

    setUpVars: function(){
      this.domUlTopics = $('#ul-topics');
      this.domLiTopics = $('.li-topic');
      this.domQuestions = $('.question');
      this.domResults = $('.results');
      this.domProgress = $('#sruns-progress');

      var current = $('.li-topic.open');
      var currentTid = current.attr('data-tid');
      this.data.current = currentTid;

      this.topicsCount = this.domLiTopics.length;
    },

    // ** ARM **
    // ---------
    
    armTopic: function(){
      var me = this;
      me.domLiTopics.click(function(){
        var tid = $(this).attr('data-tid');
        me.data.current = tid;
        me.renderTopic(tid);
        me.renderResults(tid);
        me.saveData();
      });  
    },

    armButtons: function(){
      var me = this;
      $('.bts').click(function(){
        var item = $(this);
        var tid = item.attr('data-tid');
        var value = false;

        if (item.hasClass('bts-yes')){
          value = 'yes';
        }
        if (item.hasClass('bts-no')){
          value = 'no';
        }
        if (item.hasClass('bts-skip')){
          value = 'skip';
        }

        me.data.topics[tid] = value;
        me.renderAnswer(tid, value);
        me.renderResults(tid);
        me.updateProgress();
        me.renderProgress();
        me.saveData();
        me.checkNextTopic(tid);
      });
    },

    // ** RENDER **
    // ------------
    
    renderAnswer: function(tid, value){
      var me = this;
      var wrapper = me.getDomItemFromId('wrapper-bts', tid); 
      var btns = $('.bts', wrapper);
      btns.removeClass('checked');

      var btn = me.getDomItemFromId('bts-' + value, tid);
      btn.addClass('checked');

      var li = me.getDomItemFromId('li-topic', tid);
      li.removeClass('answ-no').removeClass('answ-yes').removeClass('answ-skip');
      li.addClass('done').addClass('answ-' + value);

      // Yes
      if (value == 'yes'){
        li.removeClass('skip');
      }

      // No
      if (value == 'no'){
        li.removeClass('skip');
        me.domResults.addClass('hide');
      }

      // Skip
      if (value == 'skip'){
        li.addClass('skip');
      }
    },

    renderTopic: function(tid){
      this.domLiTopics.removeClass('open');
      this.domQuestions.addClass('hide').css('style', '');
      this.domResults.addClass('hide');

      // Topic active
      var li = this.getDomItemFromId('li-topic', tid);
      li.addClass('open');
      this.scrollHorizForMobile(li);

      var question = this.getDomItemFromId('question', tid);
      question.hide().removeClass('hide').fadeIn(); 
    },

    renderProgress: function(){
      $('.s-progress', this.domProgress).css('width', this.data.progress + '%');

      if (this.data.progress == 100){
        $('.btn', this.domNext).removeClass('disabled').removeClass('btn-default').addClass('btn-success');  
      } else {
        $('.btn', this.domNext).addClass('disabled').removeClass('btn-success').addClass('btn-default'); 
      }
    },

    renderResults: function(tid){
      var value = this.getTopicValue(tid);
      if (value){
        this.domResults.addClass('hide');
        var result = this.getDomItemFromId('result', tid);

        if (value == 'no'){
          result.hide().removeClass('hide').fadeIn(); 
          $('.sameh', result).sameh();
        } else {
          result.addClass('hide');  
        }
      }
    },

    // ** SAVE **
    // ----------
    
    saveData: function(){
      Cookies.set('sruns-data', this.data, { expires: 30 });
    },

    loadData: function(){
      var data = Cookies.get('sruns-data');
      if (data !== undefined){
        this.data = JSON.parse(data);
        return true;
      }
      return false;
    },

    // ** ACTIONS **
    // -------------

    updateDom: function(){
      var me = this;
      var topics = this.data.topics;
      _.each(topics,function(value, tid){
        me.renderAnswer(tid, value);
      })

      if (this.data.current){
        me.renderTopic(this.data.current);
        me.renderResults(this.data.current);
      }

      me.renderProgress();
    },

    updateProgress: function(){
      var yes = this.domLiTopics.filter('.answ-yes').length;
      var skip = this.domLiTopics.filter('.answ-skip').length;
      var tot = yes + skip;
      this.data.progress = Math.round(tot / this.topicsCount * 100);
    },

    /**
     * Scroll to the archive
     */
    scrollToTop: function(){
      var element = Drupal.settings.tcbl_comps.scrollToElement;
      scrollTo(element);
    },

    checkNextTopic: function(tid){
      var me = this;
      var li = this.getDomItemFromId('li-topic', tid);
      var value = this.getTopicValue(tid);
      if (value !== 'no'){
        var next = li.next();
        if (next.length !== 0){
          if (!next.hasClass('done')){
            var tid = next.attr('data-tid');
            me.renderTopic(tid);
          }
        }  
      }
    },

    scrollHorizForMobile: function(li){
      var me = this;
      if ($(window).width() < 768){
        setTimeout(function(){
          // Posizione attuale dello scrollo
          var ulPosition = me.domUlTopics.scrollLeft();
          
          // Correzion
          var correction = -10;
          if (li.is(':last-child') || li.is(':first-child')){
            correction = 0;
          }

          // Scostamento dell'item rispetto al genitore
          var offset = li.position().left + ulPosition + correction;

          me.domUlTopics.animate({
            scrollLeft: offset,
          }, 1000, 'easeOutQuad');
        }, 200); 
      }
    },

    // ** UTILITY **
    // -------------
    
    getDomItemFromId: function(prefix, id){
      var item = $('#' + prefix + '-' + id);
      return item;
    },

    getDomItemFromAttribute: function(domObject, prefix, attributeName){
      var id = domObject.attr(attributeName);
      var item = this.getDomItemFromId(prefix, id);
      return item;
    },

    getTopicValue: function(tid){
      if (this.data.topics[tid] !== undefined){
        return this.data.topics[tid];
      }
      return false;
    },
  };
})(jQuery, Drupal);
