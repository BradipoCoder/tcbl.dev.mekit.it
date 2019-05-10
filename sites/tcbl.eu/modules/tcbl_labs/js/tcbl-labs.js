/**
 * TCBL LABS
 */

(function ($, Drupal) {
  Drupal.behaviors.tcblLabs = {

    attach: function (context, settings) {
      // Using once() to apply the myCustomBehaviour effect when you want to do just run one function.
      // $('body', context).once('myCustomBehavior').addClass('well');
      me = this;

      me.filters = {};
      me.page = 1;
      me.context = context;
      me.settings = settings;
      me.showPagination = false;

      me.perPage = Drupal.settings.tcbl_labs.perPage;
      me.withArgs = Drupal.settings.tcbl_labs.withArgs;

      if (Drupal.settings.tcbl_labs.scroll){
        scrollTo('#row-labs-archive');
      }
    
      this.checkCookies();
      this.armFilters();
      this.reloadAll();
      this.armReset();
    },

    /**
     * Arm labs filter
     * @return {[type]} [description]
     */
    armFilters: function(){
      var filter = jQuery('#labs-filters');
      var toggleMap = jQuery('#toggle-map');
      var select = jQuery('.labs-select', filter);
      var search = jQuery('#labs-search', filter);
      var searchButton = jQuery('#search-button', filter);

      select.change(function(e){
        var item = jQuery(this);
        var name = item.attr('name');
        var value = item.val();
        me.filters[name] = value;
        me.page = 1;
        me.reloadAll();
      });

      searchButton.click(function(){
        var item = jQuery(this);
        var value = search.val();
        var name = item.attr('name');
        me.filters[name] = value; 
        me.page = 1;
        me.reloadAll();
      });

      // Return key
      search.keydown(function(event){
        if (event.keyCode == 13) {
          var value = search.val();
          if (value == ''){
            value = false;
          }
          me.filters['key'] = value;
          me.page = 1;
          me.reloadAll();

          // Faccio il refresh dell'archivio
          search.blur();
        }
      });

      // Toggle map
      toggleMap.click(function(event){
        event.preventDefault();

        if (toggleMap.hasClass('on')){
          // Turn off map
          me.filters['view_mode'] = 'card';
          toggleMap.removeClass('on');
        } else {
          // Turn on
          me.filters['view_mode'] = 'teaser';
          toggleMap.addClass('on');
        }
        //me.page = 1;
        me.reloadAll();
      });
    },

    /**
     * Show reset filters
     * @return {[type]} [description]
     */
    armReset: function(){
      var reset = $('#reset-filters');
      reset.click(function(e){
        e.preventDefault();
        me.filters = {};
        me.page = 1;
        me.reloadAll();
        me.updateFilterVals();
        me.setCookies();
      })
    },

    /**
     * Update data from filters value
     * - usefull for query args
     */
    setDataFromFilters: function(){
      var select = jQuery('.labs-select');
      select.each(function(){
        var item = jQuery(this);
        var name = item.attr('name');
        var value = item.val();
        me.filters[name] = value; 
      });
    },

    /**
     * Reload all labs list
     * @return {[type]} [description]
     */
    reloadAll: function(){
      me.setCookies();

      var filter = $('#labs-filters');
      var results = jQuery('#labsmain-results');

      filter.addClass('loading');

      var aurl = '/labs-get-results';
      var tmpFilters = me.filters;
      delete tmpFilters.page;
      var queryString = Object.keys(tmpFilters).map(key => key + '=' + tmpFilters[key]).join('&');
      var encodedQuery = encodeURI(queryString);

      // Get filtered maps data (without pagination)
      var aurl = '/labs-get-data?' + encodedQuery;
      $.ajax({
        url: aurl
      }).done(function(data){
        // Send this data to the map
        Drupal.behaviors.tcblMaps.updateData(data);
      });

      // Get all nids list (without pagination)
      var aurl = '/labs-get-nids?' + encodedQuery;
      $.ajax({
        url: aurl
      }).done(function(data){
        me.createPagination(data);
      });

      // Update query with current page
      tmpFilters.page = me.page;
      queryString = Object.keys(tmpFilters).map(key => key + '=' + tmpFilters[key]).join('&');
      console.debug(queryString);
      encodedQuery = encodeURI(queryString);

      // Get filtered nodes
      var aurl = '/labs-get-results?' + encodedQuery;
      var labsResults = $('#labs-results');
      labsResults.load(aurl + ' #labs-results > div', function(){
        filter.removeClass('loading');
        var pagination = $('#labs-pagination');
        if (me.showPagination){
          pagination.addClass('p-active');  
        } else {
          pagination.removeClass('p-active'); 
        }

        if (me.filters['view_mode'] == 'card'){
          results.addClass('map-off');
        } else {
          results.removeClass('map-off');
        }

        $(labsResults).imagesLoaded(function(){
          $('.same-h', labsResults).sameh();
        });
        
        // This ends up in javascript loop?
        //Drupal.attachBehaviors();
      }); 
    },

    /**
     * Add pagination
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    createPagination: function(data){
      var count = data.length;
      var pagination = $('#labs-pagination');
      
      if (count > me.perPage){
        me.showPagination = true;
        pagination.pagination({
          items: data.length,
          itemsOnPage: me.perPage,
          displayedPages: 3,
          edges: 1,
          hrefTextPrefix: '#',
          ellipsePageSet: false,
          cssStyle: null,
          currentPage: me.page,
          prevText: '<i class="fa fa-angle-left"></i>',
          nextText: '<i class="fa fa-angle-right"></i>',
          onPageClick: function(pageNumber, event) {
            me.paginationUsefullClass();
            me.page = pageNumber;
            me.reloadAll();
            scrollTo('#row-labs-archive');
          },
          onInit: function() {
            me.paginationUsefullClass();
          }
        });
      } else {
        me.showPagination = false; 
      }
    },

    /**
     * Add usefull class to pagination
     * @return {[type]} [description]
     */
    paginationUsefullClass: function(){
      var pagination = $('#labs-pagination');
      $('.page-link, span.current, span.ellipse', pagination).not('.prev, .next').parent().addClass('li-item').last().addClass('li-item-last');
      $('.prev', pagination).parent().addClass('li-arrow li-arrow-prev');
      $('.next', pagination).parent().addClass('li-arrow li-arrow-next');  
    },

    /**
     * Read cookie
     * @return {[type]} [description]
     */
    checkCookies: function(){
      if (!me.withArgs){
        var data = Cookies.get('labs');
        if (data !== undefined){
          data = JSON.parse(data);
          me.filters = data;
          if (data.page !== undefined){
            me.page = data.page;
          }
          me.updateFilterVals();
        }  
      } else {
        me.setDataFromFilters();
      }
    },

    /**
     * Save filters in a cookie
     */
    setCookies: function(){
      var cData = me.filters;
      Cookies.set('labs', cData, { expires: 1 }); 
    },

    /**
     * Update dom filters Vals
     * @return {[type]} [description]
     */
    updateFilterVals: function(){
      if (me.filters.country !== undefined){
        $('#filter-country').val(me.filters.country);
      } else {
        $('#filter-country').val(false);
      }
      if (me.filters.kas !== undefined){
        $('#filter-kas').val(me.filters.kas);
      } else {
        $('#filter-kas').val(false);
      }
      if ((me.filters.key !== undefined) && (me.filters.key)){
        $('#labs-search').val(me.filters.key);
      } else {
        $('#labs-search').val('');
      }
      if (me.filters.view_mode !== undefined){
        if (me.filters.view_mode == 'card'){
          $('#toggle-map').removeClass('on');  
        } else {
          $('#toggle-map').addClass('on');
        }
      } else {
        $('#toggle-map').addClass('on');
      }
    }
  };
})(jQuery, Drupal);
