/**
 * TCBL MAP MULTIPLE
 */

(function ($, Drupal) {
  Drupal.behaviors.tcblMaps = {

    attach: function (context, settings) {
      this.markerGroup = false;

      if (Drupal.settings.tcbl_map.list !== undefined){
        this.mid = Drupal.settings.tcbl_map.mid;
        this.list = Drupal.settings.tcbl_map.list;
        this.buildMap();
        this.updateMarkersOnMap();
      }
    },

    buildMap: function(){
      this.mymap = L.map(this.mid);

      L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoibHVjYWNhdHRhbmVvIiwiYSI6IkxrZ2wtaDAifQ.0zUmY-XudF0nGTnKzuS7zA'
      }).addTo(this.mymap);

      this.mymap.zoomControl.setPosition('topright');
    },

    /**
     * Method used to update the map data (see tcbl-labs.js)
     */
    updateData: function(data){
      if (data){
        this.list = data;
        this.updateMarkersOnMap();  
      } else {
        this.markerGroup.clearLayers();
        this.mymap.fitWorld()
      }
    },

    /**
     * Update Markers Data on map
     */
    updateMarkersOnMap: function(){
      // Add markers to map
      var bounds = [];
      var map = this.mymap;

      // Clear all markers
      if (this.markerGroup){
        this.markerGroup.clearLayers();  
      }

      if (this.list){
        // Create a marker group
        var markerGroup = L.layerGroup().addTo(map);

        // Add markers to the group
        _.each(this.list, function(item){
          var marker = L.marker(item.coord).addTo(markerGroup).bindPopup('<b><a href="' + item.url + '">' + item.title + '</a></b><br>' + item.address);
          bounds.push(item.coord);
        })

        this.markerGroup = markerGroup;

        // Set center
        this.mymap.fitBounds(bounds);  
      }
    },
  };
})(jQuery, Drupal);