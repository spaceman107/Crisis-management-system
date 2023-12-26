// Define layers for different types of markers
var offerLayer = L.layerGroup();
var requestpendingLayer = L.layerGroup();
var requestacceptedLayer = L.layerGroup();
var baseLayer = L.layerGroup();
var vehicleLayer = L.layerGroup();

var draggableMarkers = {};

// Create the map and add the tile layer
const map = L.map('map', {
    center: [37.983810, 23.727539],
    zoom: 10,
    layers: [requestpendingLayer, offerLayer, requestacceptedLayer, baseLayer, vehicleLayer]
});

const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Â© OpenStreetMap contributors',
}).addTo(map);


// Create overlay maps for the layer control
const overlays = {
    "ACCEPTED REQUESTS": requestacceptedLayer,
    "PENDING REQUESTS": requestpendingLayer,
    "OFFERS": offerLayer,
    "BASES": baseLayer,
    "VEHICLES": vehicleLayer
};

// Add layer control to the map
const layerControl = L.control.layers(null, overlays).addTo(map);


fetch('offer_coordinates.php')
    .then(response => response.json())
    .then(OfferCoordinates => {
        console.log(OfferCoordinates);

        OfferCoordinates.forEach(item => {
            var markerOffer = L.divIcon({
                html: '<img src="https://cdn-icons-png.flaticon.com/512/4151/4151073.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerOffer',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerOffer }).addTo(map).addTo(offerLayer).bindPopup("Offer.");

        });
    })
    .catch(error => console.error('Error fetching data:', error));




///REQUEST PENDING COORDINATES

fetch('request_coordinates_pending.php')
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

fetch('request_coordinates_accepted.php')
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


/// BASE COORDINATES

fetch('base_coordinates.php')
    .then(response => response.json())
    .then(BaseCoordinates => {
        console.log('BaseCoordinates:', BaseCoordinates);

        BaseCoordinates.forEach(item => {
            var markerBase = L.divIcon({
                html: '<img src="https://cdn.iconscout.com/icon/free/png-256/free-base-1786434-1520324.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerBase',
                iconSize: [30, 20],
            });

            var baseMarker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerBase, draggable: true }).addTo(map).addTo(baseLayer).bindPopup("Base id :" + item.base_id);

            // Event listener for dragend
            baseMarker.on('dragend', function(event) {
                var marker = event.target;
                var position = marker.getLatLng();
                var baseId = item.base_id;

                // Ask for confirmation before updating the coordinates
                if (confirm("Are you sure you want to update the coordinates?")) {
                    // Redirect to the PHP script with updated coordinates
                    updateCoordinates(baseId, position.lat, position.lng);
                } else {
                    // Revert the marker position if the user cancels
                    marker.setLatLng(new L.LatLng(item.lat, item.lng));
                }
            });

            draggableMarkers[item.base_id] = baseMarker;
        });
    })
    .catch(error => console.error('Error fetching data:', error));

function updateCoordinates(baseId, lat, lng) {
    // Use Fetch API to send a POST request to the PHP script
    fetch('update_base_coordinates.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `baseId=${baseId}&lat=${lat}&lng=${lng}`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Rescuer added successfully');
            } else {
                alert('Error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


// VEHICLE COORDINATES
fetch('vehicle_coordinates.php')
    .then(response => response.json())
    .then(VehicleCoordinates => {
        console.log('VehicleCoordinates:', VehicleCoordinates);

        // Ensure that the map is fully initialized before adding markers
        VehicleCoordinates.forEach(item => {
            var markerVehicle = L.divIcon({
                html: '<img src="https://www.clipartmax.com/png/middle/196-1961098_car-navigation-maps-for-lovers-of-long-distance-road-google-map-car.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerBase',
                iconSize: [30, 20],
            });

            // Split the comma-separated strings into arrays
            var productNames = item.product_names.split(',');
            var transactionStatuses = item.transaction_statuses.split(',');
            // Create popup content with product names and transaction statuses
            var popupContent = "Vehicle name: " + item.vehicle_name + "<br>";

            // Iterate over the arrays and construct the popup content
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
