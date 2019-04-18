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

      me.perPage = Drupal.settings.tcbl_labs.perPage;
    
      this.checkCookies();
      this.updateFilterVals();

      this.armFilters();
      this.reloadAll();
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
    },

    /**
     * Reload all labs list
     * @return {[type]} [description]
     */
    reloadAll: function(){
      me.setCookies();

      var filter = $('#labs-filters');

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
      encodedQuery = encodeURI(queryString);

      // Get filtered nodes
      var aurl = '/labs-get-results?' + encodedQuery;
      $('#labs-results').load(aurl + ' #labs-results > div', function(){
        filter.removeClass('loading');
      }); 
    },

    createPagination: function(data){
      var count = data.length;
      var pagination = $('#labs-pagination');
      
      if (count > me.perPage){  
        pagination.addClass('p-active');
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
        pagination.removeClass('p-active');  
      }
    },

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
      var data = Cookies.get('labs');
      if (data !== undefined){
        data = JSON.parse(data);
        me.filters = data;
        me.page = me.page;
      }
    },

    /**
     * Save filters in a cookie
     */
    setCookies: function(){
      var cData = me.filters;
      Cookies.set('labs', cData, { expires: 1 }); 
    },

    updateFilterVals: function(){
      if (me.filters.country !== undefined){
        $('#filter-country').val(me.filters.country);
      }
      if (me.filters.kas !== undefined){
        $('#filter-kas').val(me.filters.kas);
      }
      if ((me.filters.key !== undefined) && (me.filters.key)){
        $('#labs-search').val(me.filters.key);
      }
    }

  };
})(jQuery, Drupal);
