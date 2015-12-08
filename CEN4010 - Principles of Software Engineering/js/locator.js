
var currentLat;
var currentLng;
var dID;

$(document).ready(function() {

    updateLocation();
    window.setInterval(updateLocation, 20000);
    
});


function updateLocation(){
    
    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function(position){
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            dID = $("#dID").data("did");
            currentLat = pos['lat'];
            currentLng = pos['lng'];
            
            $.ajax({
                method: "POST",
                url: "updateLocation.php",
                data: { 
                    dID: dID,
                    lat: currentLat,
                    lng: currentLng 
                }
            }).done(function(data){
                console.log(data);
            });
        });
    }
}