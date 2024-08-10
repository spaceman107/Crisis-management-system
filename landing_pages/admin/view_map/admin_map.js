
var offerPendingLayer = L.layerGroup();
var requestpendingLayer = L.layerGroup();
var requestacceptedLayer = L.layerGroup();
var baseLayer = L.layerGroup();
var vehicleLayer = L.layerGroup();
var offerAcceptedLayer = L.layerGroup();
var draggableMarkers = {};


const map = L.map('map', {
    center: [37.983810, 23.727539],
    zoom: 10,
    layers: [requestpendingLayer, offerAcceptedLayer, offerPendingLayer, requestacceptedLayer, baseLayer, vehicleLayer]
});

const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Â© OpenStreetMap contributors',
}).addTo(map);



const overlays = {
    "ACCEPTED REQUESTS": requestacceptedLayer,
   "PENDING REQUESTS": requestpendingLayer,
    "PENDING OFFERS": offerPendingLayer,
    "ACCEPTED OFFERS": offerAcceptedLayer,
    "BASES": baseLayer,
    "VEHICLES": vehicleLayer
};


const layerControl = L.control.layers(null, overlays).addTo(map);


fetch('view_map/offer_coordinates.php')
    .then(response => response.json())
    .then(OfferCoordinates => {
        console.log(OfferCoordinates);

        OfferCoordinates.forEach(item => {
            var markerOffer = L.divIcon({
                html: '<img src="https://cdn-icons-png.flaticon.com/512/4151/4151073.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerOffer',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerOffer }).addTo(map).addTo(offerPendingLayer).bindPopup("Offer.");

        });
    })
    .catch(error => console.error('Error fetching data:', error));

/////////

    fetch('view_map/accepted_offer_coordinates.php')
    .then(response => response.json())
    .then(OfferCoordinates1 => {
        console.log(OfferCoordinates1);

        OfferCoordinates1.forEach(item => {
            var markerOffer1= L.divIcon({
                html: '<img src="https://cdn-icons-png.flaticon.com/512/4151/4151073.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerOffer1',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerOffer1 }).addTo(map).addTo(offerAcceptedLayer)
            .bindPopup(
                "User Fullname: " + item.first_name + " " + item.last_name +
                "<br>Phone: " + item.phone +
                "<br>Time of Submission: " + item.time_of_submition +
                "<br>Product Category: " + item.name_category +
                "<br>Vehicle Name: " + item.vehicle_name);;

        });
    })
    .catch(error => console.error('Error fetching data:', error));


///REQUEST PENDING COORDINATES

fetch('view_map/request_coordinates_pending.php')
    .then(response => response.json())
    .then(RequestCoordinates => {
        console.log(RequestCoordinates);


        RequestCoordinates.forEach(item => {
            var markerRequest = L.divIcon({
                html: '<img src="https://image.pngaaa.com/232/2702232-middle.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerRequest',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerRequest })
                .addTo(requestpendingLayer)
                .bindPopup(
                    "User Fullname: " + item.first_name + " " + item.last_name +
                    "<br>Phone: " + item.phone +
                    "<br>Time of Submission: " + item.time_of_submition +
                    "<br>Product Category: " + item.name_category +
                    "<br>Vehicle Name: " + item.vehicle_name);
        });
    })
    .catch(error => console.error('Error fetching data:', error));

///REQUEST ACCEPTED COORDINATES

fetch('view_map/request_coordinates_accepted.php')
    .then(response => response.json())
    .then(RequestAcceptedCoordinates => {
        console.log(RequestAcceptedCoordinates);


        RequestAcceptedCoordinates.forEach(item => {
            var markerAcceptedRequest = L.divIcon({
                html: '<img src="https://cdn-icons-png.flaticon.com/512/4151/4151073.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerAcceptedRequest',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerAcceptedRequest })

                .addTo(requestacceptedLayer)
                .bindPopup(
                    "User Fullname: " + item.first_name + " " + item.last_name +
                    "<br>Phone: " + item.phone +
                    "<br>Time of Submission: " + item.time_of_submition +
                    "<br>Product Category: " + item.name_category +
                    "<br>Vehicle Name: " + item.vehicle_name);
        });
    })
    .catch(error => console.error('Error fetching data:', error));


    function updateCoordinates(locationId, lat, lng) {
        console.log('Updating coordinates for base:', { locationId, lat, lng });
       // Use Fetch API to send a POST request to the PHP script
       fetch('view_map/update_base_coordinates.php', {
               method: 'POST',
               headers: {
                   'Content-Type': 'application/json',
               },
               body: JSON.stringify({
                locationId: parseInt(locationId, 9),
                   lat: lat,
                   lng: lng,
               }),
           })
           .then(response => response.json())
           .then(data => {
               if (data.status === 'success') {
                   alert('Coordinates updated successfully');
               } else {
                   alert('Error updating coordinates');
               }
           })
           .catch(error => {
               console.error('Error:', error);
           });
          
       console.log('Sending data to update: ', { locationId, lat, lng });
   }


/// BASE COORDINATES

// BASE COORDINATES
fetch('view_map/base_coordinates.php')
    .then(response => response.json())
    .then(BaseCoordinates => {
        console.log('BaseCoordinates:', BaseCoordinates);

        BaseCoordinates.forEach(item => {
            var markerBase = L.marker([parseFloat(item.lat), parseFloat(item.lng)], {
                icon: L.divIcon({
                    html: '<img src="https://cdn.iconscout.com/icon/free/png-256/free-base-1786434-1520324.png" width="30" height="30" alt="Custom Marker">',
                    className: 'markerBase',
                    iconSize: [30, 20],
                }),
                draggable: true
            }).addTo(baseLayer);

            // Attach the location_id to the marker as a property
            markerBase.location_id = item.location_id;

            markerBase.on('dragend', function(event) {
                var newLatLng = event.target.getLatLng();
                document.getElementById('latInput').value = newLatLng.lat;
                document.getElementById('lngInput').value = newLatLng.lng;

                if (confirm('Are you sure you want to update the coordinates?')) {
                    
                    var locationId = event.target.location_id;
                    console.log("Location ID:", locationId);
                    document.getElementById('location_id').value = locationId;
                    document.getElementById('updateForm').submit();
                } else {
                    
                    event.target.setLatLng(new L.LatLng(document.getElementById('latInput').value, document.getElementById('lngInput').value));
                }
            });

            markerBase.addTo(map); // Add the marker to the map
        });
    })
    .catch(error => console.error('Error fetching data:', error));
    

    //var locationId = item.base_id ; 
// VEHICLE COORDINATES
fetch('view_map/vehicle_coordinates.php')
    .then(response => response.json())
    .then(VehicleCoordinates => {
        console.log('VehicleCoordinates:', VehicleCoordinates);

       
        VehicleCoordinates.forEach(item => {
            var markerVehicle = L.divIcon({
                html: '<img src="https://www.clipartmax.com/png/middle/196-1961098_car-navigation-maps-for-lovers-of-long-distance-road-google-map-car.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerBase',
                iconSize: [30, 20],
            });

     
            var productNames = item.product_names.split(',');
            var transactionStatuses = item.transaction_statuses.split(',');
            // Create popup content with product names and transaction statuses
            var popupContent = "Vehicle name: " + item.vehicle_name + "<br>";

           
            for (var i = 0; i < productNames.length; i++) {
                var productName = productNames[i].trim(); // Trim to remove leading/trailing spaces
                var transactionStatus = transactionStatuses[i].trim();

                popupContent += "Product: " + productName + "<br>Transaction status: " + transactionStatus + "<br>";
            }

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerVehicle })

                .addTo(vehicleLayer)
                .bindPopup(popupContent);
        });
    })
    .catch(error => console.error('Error fetching data:', error));
