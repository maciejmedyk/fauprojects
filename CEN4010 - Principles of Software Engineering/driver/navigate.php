<?php
include_once("session.php"); 
include_once("../header.php");

if(isset($_GET['clientID'])){
	$id=$_GET['clientID'];
	$_SESSION['customer_id']= $id;
} else {
	$id=$_SESSION['customer_id'];
}
?>
<body>
    <div id="dID" data-did="<?php echo $_SESSION['driverID']; ?>"></div>
<div id="dBackDiv">
    <div id="dHead">
        <div id="dHeadLeft">
            <a href="emergency.php"<button type="link" id="emergencyButton" class="btn btn-default"> Emergency </button></a>
        </div>
        <div id="dHeadRight">
            <a href="sheets.php"<button type="link" id="logoutButton" class="btn btn-default"> Back </button></a>
        </div>
    </div><br>
    <div id="dWireFrame">
        <b align="center" id="welcome">Driver : <?php echo $login_name; ?></b><br>
        <p><?php date_default_timezone_set("America/New_York"); $date = date("Y-m-d"); echo $date; ?></p>
        <div id="dInsideFrame">
            <?php
               
                $query = "SELECT * FROM `clients` WHERE `clients`.`cID` = $id";
				$sql = $db->query($query);
                $address = array();
                echo "<table border cellpadding = 3 class=\"driverDetailsSheets\">";
                echo "<th width=\"100%\">Address</th>";
                while ($info = $sql->fetch_array())
                {
                    echo "<tr><td id=\"dDSAddress1\">" . $info['cAddress1'] . ' ' . $info['cAddress2'] . "</td></tr>";
                    echo "<tr><td id=\"dDSAddress2\">" . $info['cCity'] . ', ' . $info['cState'] . ' ' . $info['cZip'] . "</td></tr>";
                    $address = $info['cAddress1'] . ' ' . $info['cCity'] . ' ' . $info['cState'] . ' ' . $info['cZip'];
                }
                echo "</table>";
            ?>
            <?php
            require '../map/geocode.php';
            #echo $address; echo "<br>";
            $geo = (getGeoLocation($address));
            #echo "<td id=\"dDSAction\"><form action=\"#\" method=\"post\"><input id=\"waypoint\" value=\"" .  $geo['lat'] . ', ' . $geo['lng'] . "\"></form></td></tr>";
            ?>

            <div id="map"></div>
            <div id="directions-panel"></div>
            <div id="text-panel"></div>
            <div id="checkoutB" <?php echo "<td id=\"dDSAction\"><form action=\"checkout.php\" method=\"post\"><input class=\"hidden\" name=\"cID\" value=\"" .  $id . "\"><input type=\"submit\" id=\"logoutButton\" class=\"btn btn-default\" value=\"Checkout\"></form></td></tr>"; ?></div>
            <div id="bottom-panel">
                <div id="waypoints-panel">
                    <select class="hidden" id="finaldestination">
                        <option value="<?php echo $geo['lat'] . ',' . $geo['lng']; ?>">Customer 1</option>
                    </select>
                    <!--<input class="btn btn-default button" type="submit" id="submit" value="Calculate Route">-->
                </div>
            </div>


        <?php require '../map/device.php'; ?>

            <script type="text/javascript">

                //
                //Variables for obtaining geolocation
                //
                var geoID;
                var browserSupportFlag =  new Boolean();
                var currentLocation = {
                    lat: 0,
                    lng: 0
                };
                
                var geoOptions = {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 0
                };
                
                //
                //This function will get the geolocation coordinates of the users current position.
                //Returns the coordinates.
                //
                function getLocation(position) {
                    browserSupportFlag = true;
                    if (position === undefined){
                        return;
                    }
                    currentLocation.lat = position.coords.latitude;
                    currentLocation.lng = position.coords.longitude;
                    
                    initMap(); //Should run this only the first time if autorefresh should be left on. 
                    //Turn off the auto refresh for now. 
                    navigator.geolocation.clearWatch(geoID);                 
                }
                
                //
                //This will be called if there is an error getting the location.
                //
                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    browserSupportFlag = false;
                }
                
                //
                //This will initialize the geolocation functions (successful, not successful, options of locator)
                //
                function startGeolocation(){
                    geoID = navigator.geolocation.watchPosition(getLocation, handleLocationError, geoOptions);
                }

                var map;

                //
                //Initializes the google maps API
                //
                function initMap() {
                    var directionsService = new google.maps.DirectionsService;
                    var directionsDisplay = new google.maps.DirectionsRenderer;
                    var directionsDisplayText = new google.maps.DirectionsRenderer;
                        map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 11, center: currentLocation, disableDefaultUI: true});

                    directionsDisplay.setMap(map);
                    directionsDisplayText.setPanel(document.getElementById('text-panel'));
                    calculateAndDisplayRoute(directionsService, directionsDisplay, directionsDisplayText);
                }

                //
                //This will calculate the directions to all locations and display them on the screen.
                //
                function calculateAndDisplayRoute(directionsService, directionsDisplay, directionsDisplayText) {
                    var waypts = [];
                    console.log(currentLocation);

                    directionsService.route({
                        origin: currentLocation, //document.getElementById('start').value,
                        destination: document.getElementById('finaldestination').value,
                        waypoints: waypts,
                        optimizeWaypoints: true,
                        travelMode: google.maps.TravelMode.DRIVING
                    }, function(response, status) {
                        if (status === google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                            directionsDisplayText.setDirections(response);
                            var route = response.routes[0];
                            var summaryPanel = document.getElementById('directions-panel');
                            summaryPanel.innerHTML = '';


                            // For each route, display summary information.
                            for (var i = 0; i < route.legs.length; i++)
                            {
                                var routeSegment = i + 1;
                                //summaryPanel.innerHTML += '<u>Destination</u><br>';
                                //summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                                summaryPanel.innerHTML += '<b>' + route.legs[i].end_address + '<b><br>';
                                if (routeSegment == 1){
                                    summaryPanel.innerHTML += '<i>Distance from current location: ' + route.legs[i].distance.text + '</i><br>';
                                }else{
                                    summaryPanel.innerHTML += '<i>Distance from last stop: ' + route.legs[i].distance.text + '</i><br>';
                                }

                                //Show navigation button depending on platform
                                if ("<?php echo isDevice('android');?>")
                                {
                                    summaryPanel.innerHTML += '<center><a class="btn btn-info bbb" role="button" href="google.navigation:q=' + route.legs[i].end_location + '";>Navigate with Google Maps</a></center><br>';
                                }
                                else if ("<?php echo isDevice('ios');?>")
                                {
                                    summaryPanel.innerHTML += '<center><a class="btn btn-info bbb" role="button" href="http://maps.apple.com/?q=' + route.legs[i].end_location + '";>Navigate with Apple Maps</a></center><br>';
                                }
                            }
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUacGLhz_V_YNulU_YET1DwK4d2Y_g8M8&signed_in=true&callback=startGeolocation"
                    async defer></script>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>