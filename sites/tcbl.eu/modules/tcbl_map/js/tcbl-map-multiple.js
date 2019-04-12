/**
 * TCBL MAP MULTIPLE
 */

jQuery().ready(function(){

  console.debug(Drupal.settings.tcbl_map);

  // Get Map Id
  var mid = false;
  if (Drupal.settings.tcbl_map.list !== undefined){
    mid = Drupal.settings.tcbl_map.mid;
    list = Drupal.settings.tcbl_map.list;
    tcblMapBuilMapMultiple(mid, list);
  }

  /**
   * Costruisce la mappa e aggiunge il popup
   */
  function tcblMapBuilMapMultiple(mid, list){
    var mymap = L.map(mid);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      id: 'mapbox.streets',
      accessToken: 'pk.eyJ1IjoibHVjYWNhdHRhbmVvIiwiYSI6IkxrZ2wtaDAifQ.0zUmY-XudF0nGTnKzuS7zA'
    }).addTo(mymap);

    // Add markers to map
    var bounds = [];
    _.each(list, function(item){
      var marker = L.marker(item.coord).addTo(mymap).bindPopup("<b>" +item.title + "</b><br>" + item.address);
      bounds.push(item.coord);
    })

    // Set center
    mymap.fitBounds(bounds);
    mymap.zoomControl.setPosition('topright');
  }

});
