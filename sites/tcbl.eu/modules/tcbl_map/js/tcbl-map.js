/**
 * TCBL MAP
 */

jQuery().ready(function(){

  // Get Map Id
  var mid = false;
  if (Drupal.settings.tcbl_map.mid !== undefined){
    mid = Drupal.settings.tcbl_map.mid;
  }

  // Get Address
  if (Drupal.settings.tcbl_map.coord !== undefined){
    
    // Cordinate | può essere false
    var coord = Drupal.settings.tcbl_map.coord;
    
    var address = Drupal.settings.tcbl_map.address
    var plainAddress = Drupal.settings.tcbl_map.plain_address;
    var title = Drupal.settings.tcbl_map.title;

    if (mid){
      if (coord){
        // Build the map
        tcblMapBuilMapCoord(mid, coord, title, plainAddress);  
      } else {
        
        if (address){
          // Try to get coordinates from address
          tcblMapGetCoordinates(mid, address, title, plainAddress); 
        }
      }
    }
  }

  // armGeocodeButton();

  /**
   * Richiesta a Open Street Map per avere i dati di posizione
   * @param  {[type]} address [description]
   * @param  {[type]} mid     [description]
   * @return {[type]}         [description]
   */
  function tcblMapGetCoordinates(mid, address, title, plainAddress){
    var xmlhttp = new XMLHttpRequest();

    // Indirizzo
    textAddress = address.street.trim() + ' ' + address.city.trim() + ' ' + address.country_name.trim();
    textAddress = encodeURI(textAddress);
    
    var token = 'pk.eyJ1IjoibHVjYWNhdHRhbmVvIiwiYSI6IkxrZ2wtaDAifQ.0zUmY-XudF0nGTnKzuS7zA';
    var url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + textAddress + '.json/?access_token=' + token;

    // console.debug('-- Load Coordinates --');

    xmlhttp.onreadystatechange = function(){
      if (this.readyState == 4){
        if (this.status == 200){
          var mapBoxData = JSON.parse(this.responseText);
          if (mapBoxData.features[0].center !== undefined){
            var coord = [mapBoxData.features[0].center[1],mapBoxData.features[0].center[0]];
            tcblMapBuilMapCoord(mid, coord, title, plainAddress);
            tclbMapSaveCoords(coord);
          }
        } else {
          console.debug(this);
        }
      }
    };

    // Effettuo la chiamata
    xmlhttp.open('GET', url, true);
    xmlhttp.send();
  }

  /**
   * Costruisce la mappa e aggiunge il popup
   */
  function tcblMapBuilMapCoord(mid, coord, title, address){
    var mymap = L.map(mid).setView(coord, 7);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      id: 'mapbox.streets',
      accessToken: 'pk.eyJ1IjoibHVjYWNhdHRhbmVvIiwiYSI6IkxrZ2wtaDAifQ.0zUmY-XudF0nGTnKzuS7zA'
    }).addTo(mymap);

    var marker = L.marker(coord).addTo(mymap);
    marker.bindPopup("<b>" + title + "</b><br>" + address);

    mymap.zoomControl.setPosition('topright');
  }

  /**
   * Update nodes coordinates
   * @param  {[type]} coord [description]
   * @param  {[type]} nid   [description]
   * @return {[type]}       [description]
   */
  function tclbMapSaveCoords(coord){
    
    // console.debug('-- Save Coordinates --');

    if (Drupal.settings.tcbl_map.nid !== undefined){
      var nid = Drupal.settings.tcbl_map.nid;

      var data = {
        'lat': coord[0],
        'lon': coord[1]
      };
    
      jQuery.ajax({
        method: 'POST',
        url: "/tcbl-map/save/" + nid + "/" + coord[0] + "/" + coord[1],
        contentType: 'application/json; charset=utf-8',
        success: function(data){
          console.debug(data);
        },
        failure: function(errMsg) {
          console.debug(errMsg);
        }
      });
    } else {
      console.debug('Error: missing nid - tclbMapSaveCoords');
    }  
  }

});
