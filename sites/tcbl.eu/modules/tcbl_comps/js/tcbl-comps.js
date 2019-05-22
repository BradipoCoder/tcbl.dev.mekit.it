/**
 * TCBL COMPS
 */

(function ($, Drupal) {
  Drupal.behaviors.tcblLabs = {

    attach: function (context, settings) {
      // Using once() to apply the myCustomBehaviour effect when you want to do just run one function.
      
      me = this;

      me.page = 1;
      me.context = context;
      me.settings = settings;
      me.showPagination = false;

      me.archiveId = Drupal.settings.tcbl_comps.id;
      me.filters = Drupal.settings.tcbl_comps.filters;

      // This should not be referenced
      me.defaultFilters = Object.assign({}, me.filters);
      // console.debug(me.defaultFilters, 'default filters | load ');

      me.perPage = Drupal.settings.tcbl_comps.perPage;
      me.withArgs = Drupal.settings.tcbl_comps.withArgs;

      if (Drupal.settings.tcbl_comps.scroll){
        me.scrollToComps();
      }

      $('body', context).once('tcblLabs').each(function(){
        me.checkCookies();
        me.armFilters();
        me.reloadAll();
        me.armReset();  
      });
    },

    /**
     * Arm comps filter
     * @return {[type]} [description]
     */
    armFilters: function(){
      var filter = jQuery('#comps-filters');
      var toggleMap = jQuery('#toggle-map');
      var select = jQuery('.comps-select', filter);
      var search = jQuery('#comps-search', filter);
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
        me.filters = Object.assign({}, me.defaultFilters);
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
      var select = jQuery('.comps-select');
      select.each(function(){
        var item = jQuery(this);
        var name = item.attr('name');
        var value = item.val();
        me.filters[name] = value; 
      });
    },

    /**
     * Reload all comps list
     * @return {[type]} [description]
     */
    reloadAll: function(){
      me.setCookies();

      var filter = $('#comps-filters');
      var results = jQuery('#compsmain-results');

      filter.addClass('loading');

      var aurl = '/comps-get-results';
      var tmpFilters = me.filters;
      delete tmpFilters.page;
      var queryString = Object.keys(tmpFilters).map(key => key + '=' + tmpFilters[key]).join('&');
      var encodedQuery = encodeURI(queryString);

      // Get filtered maps data (without pagination)
      var aurl = '/comps-get-data?' + encodedQuery;
      $.ajax({
        url: aurl
      }).done(function(data){
        // Send this data to the map
        Drupal.behaviors.tcblMaps.updateData(data);
      });

      // Get all nids list (without pagination)
      var aurl = '/comps-get-nids?' + encodedQuery;
      $.ajax({
        url: aurl
      }).done(function(data){
        me.createPagination(data);
      });

      // Update query with current page
      tmpFilters.page = me.page;
      queryString = Object.keys(tmpFilters).map(key => key + '=' + tmpFilters[key]).join('&');
      // console.debug(queryString);
      encodedQuery = encodeURI(queryString);

      // Get filtered nodes
      var aurl = '/comps-get-results?' + encodedQuery;
      var compsResults = $('#comps-results');
      compsResults.load(aurl + ' #comps-results > div', function(){
        filter.removeClass('loading');
        var pagination = $('#comps-pagination');
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

        $(compsResults).imagesLoaded(function(){
          $('.same-h', compsResults).sameh();
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
      var pagination = $('#comps-pagination');
      
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
            me.scrollToComps();
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
      var pagination = $('#comps-pagination');
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
        var cookieName = me.archiveId;
        var data = Cookies.get(cookieName);
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
      var cookieName = me.archiveId;
      Cookies.set(cookieName, cData, { expires: 1 }); 
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
      if (me.filters.memb !== undefined){
        $('#filter-memb').val(me.filters.memb);
      } else {
        $('#filter-memb').val(false);
      }
      if ((me.filters.key !== undefined) && (me.filters.key)){
        $('#comps-search').val(me.filters.key);
      } else {
        $('#comps-search').val('');
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
    },

    /**
     * Scroll to the archive
     * @return {[type]} [description]
     */
    scrollToComps: function(){
      var element = Drupal.settings.tcbl_comps.scrollToElement;
      scrollTo(element);
    }
  };
})(jQuery, Drupal);
