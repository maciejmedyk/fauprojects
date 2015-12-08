var map;
var marker;
    
function initMap() {
  var location = {lat: 26.127516, lng: -80.202787};

  map = new google.maps.Map(document.getElementById('emergencyMap'), {
    zoom: 13,
    center: location
  });

  marker = new google.maps.Marker({
    position: location,
    map: map,
    title: 'Meals on Wheels'
  });
}
    
function replaceMarker(location, title){
        
    marker.setMap(null);
    marker = new google.maps.Marker({
        position: location,
        map: map,
        title: title
    });
    map.setCenter(marker.getPosition());
}