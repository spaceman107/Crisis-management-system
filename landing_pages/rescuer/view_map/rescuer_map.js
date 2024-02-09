// Define layers for different types of markers
var offerLayerPending = L.layerGroup();
var offerLayerHimself = L.layerGroup();

var requestpendingLayer = L.layerGroup();
var requestLayerHimself = L.layerGroup();
var baseLayer = L.layerGroup();
var lines = L.layerGroup();
var RescuerLayer = L.layerGroup();
var draggableMarkers = {};
var rescuerCoordinates = { lat: null, lng: null };
// Create the map and add the tile layer
const map = L.map('map', {
    center: [37.983810, 23.727539],
    zoom: 10,
    layers: [RescuerLayer, requestpendingLayer, offerLayerPending, requestLayerHimself, baseLayer, offerLayerHimself, lines]


});

const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Â© OpenStreetMap contributors',
}).addTo(map);


// Create overlay maps for the layer control
const overlays = {
    "MY REQUESTS": requestLayerHimself,
    "PENDING REQUESTS": requestpendingLayer,
    "PENDING OFFERS": offerLayerPending,
    "MY OFFERS ": offerLayerHimself,
    "BASES": baseLayer,
    "LINES": lines,
    "RESCUER": RescuerLayer
};

// Add layer control to the map
const layerControl = L.control.layers(null, overlays, { collapsed: false }).addTo(map);

function executeSQLQuery(userId, transactionId) {
    userId = parseInt(userId, 9);
    transactionId = parseInt(transactionId, 11);

    console.log('User ID:', userId);
    console.log('Transaction ID:', transactionId);

    // Execute your SQL query when the marker is clicked
    fetch('view_map/rescuer_transaction.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ userId, transactionId })
        })
        .then(response => response.json())
        .then(queryResult => {
            console.log('SQL Query Result:', queryResult);
            // Handle the result as needed
        })
        .catch(error => console.error('Error executing SQL query:', error));
}


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

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerOffer })
                .addTo(offerLayerPending)
                .bindPopup(
                    "User Fullname: " + item.first_name + " " + item.last_name +
                    "<br>Phone: " + item.phone +
                    "<br>Time of Submission: " + item.time_of_submition +
                    "<br>Product Category: " + item.name_category +
                    "<br>Product Quantity: " + item.quantity +
                    "<br> Status : Pending");
            marker.on('click', function() {
                // Call the common function with the user_id and transaction_id
                executeSQLQuery(item.user_id, item.transaction_id);
            });

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

            var marker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerRequest })
                .addTo(requestpendingLayer)
                .bindPopup(
                    "User Fullname: " + item.first_name + " " + item.last_name +
                    "<br>Phone: " + item.phone +
                    "<br>Time of Submission: " + item.time_of_submition +
                    "<br>Product Category: " + item.name_category +
                    "<br>Product Quantity: " + item.quantity +
                    "<br> Status : Pending");

            marker.on('click', function() {
                // Call the common function with the user_id and transaction_id
                executeSQLQuery(item.user_id, item.transaction_id);
            });

        });
    })
    .catch(error => console.error('Error fetching data:', error));







/// BASE COORDINATES

fetch('view_map/base_coordinates.php')
    .then(response => response.json())
    .then(BaseCoordinates => {
        console.log('BaseCoordinates:', BaseCoordinates);

        BaseCoordinates.forEach(item => {
            var markerBase = L.divIcon({
                html: '<img src="https://cdn.iconscout.com/icon/free/png-256/free-base-1786434-1520324.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerBase',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerBase, }).addTo(map).addTo(baseLayer).bindPopup("Base id :" + item.base_id);




        });
    })
    .catch(error => console.error('Error fetching data:', error));


function updateCoordinates(lat, lng) {
    fetch('view_map/rescuer_update_coordinates.php', {
            method: 'POST',
            mode: 'cors',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                lat: lat,
                lng: lng,
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Server Response:', data);

            if (data.status === 'success') {
                alert('Coordinates updated successfully');
            } else {
                alert('Error updating coordinates: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error updating coordinates:', error);
        });
    console.log('Sending data to update:', { lat, lng });
}






/// RESCUER COORDINATES

fetch('view_map/rescuer_coordinates.php')
    .then(response => response.json())
    .then(RescuerCoordinates => {
        console.log('RescuerCoordinates:', RescuerCoordinates);

        RescuerCoordinates.forEach(item => {
            var markerRescuer = L.divIcon({
                className: 'markerRescuer',
                html: '<img src="https://png.pngtree.com/png-vector/20190215/ourmid/pngtree-vector-car-icon-png-image_515825.jpg" width="30" height="30" alt="Custom Marker">',
                iconSize: [30, 20],
            });

            var RescuerMarker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], {
                icon: markerRescuer,
                draggable: true
            }).addTo(RescuerLayer)

            rescuerCoordinates.lat = parseFloat(item.lat);
            rescuerCoordinates.lng = parseFloat(item.lng);

            RescuerMarker.on('dragend', function(event) {
                var newLatLng = event.target.getLatLng();
                document.getElementById('latInput').value = newLatLng.lat;
                document.getElementById('lngInput').value = newLatLng.lng;

                if (confirm('Are you sure you want to update the coordinates?')) {
                    // Submit the form
                    document.getElementById('updateForm').submit();
                } else {
                    // Revert the marker position if the user cancels
                    event.target.setLatLng(new L.LatLng(document.getElementById('latInput').value, document.getElementById('lngInput').value));
                }
            });
        });

        // Call updateCoordinates after markers are created (if needed)
        // updateCoordinates(someLat, someLng);
    })
    .catch(error => console.error('Error fetching data:', error));




///HIS REQUEST  COORDINATES

fetch('view_map/Request_Coordinates_Himself.php')
    .then(response => response.json())
    .then(RequestAcceptedCoordinates => {
        console.log('RequestAcceptedCoordinates:', RequestAcceptedCoordinates);


        RequestAcceptedCoordinates.forEach(item => {
            var markerAcceptedRequest = L.divIcon({
                html: '<img src="https://cdn-icons-png.flaticon.com/512/4151/4151073.png" width="30" height="30" alt="Custom Marker">',
                className: 'markerAcceptedRequest',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerAcceptedRequest })

                .addTo(requestLayerHimself)
                .bindPopup(
                    "User Fullname: " + item.first_name + " " + item.last_name +
                    "<br>Phone: " + item.phone +
                    "<br>Time of Submission: " + item.time_of_submition +
                    "<br>Time of Acceptance: " + item.time_of_acceptance +
                    "<br>Product Category: " + item.name_category +
                    "<br>Vehicle Name: " + item.vehicle_name);

            if (rescuerCoordinates.lat && rescuerCoordinates.lng) {
                L.polyline([
                    [rescuerCoordinates.lat, rescuerCoordinates.lng],
                    [parseFloat(item.lat), parseFloat(item.lng)]
                ], { color: 'blue' }).addTo(lines);
            }

        });
    })
    .catch(error => console.error('Error fetching data:', error));



fetch('view_map/offer_coordinates_himself.php')
    .then(response => response.json())
    .then(OfferHimselfCoordinates => {
        console.log(OfferHimselfCoordinates);

        OfferHimselfCoordinates.forEach(item => {


            var markerOffer1 = L.divIcon({

                className: 'markerOffer1',
                html: '<img src="https://image.pngaaa.com/232/2702232-middle.png" width="30" height="30" alt="Custom Marker">',
                iconSize: [30, 20],
            });

            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerOffer1 })
                .addTo(offerLayerHimself)
                .bindPopup(
                    "User Fullname: " + item.first_name + " " + item.last_name +
                    "<br>Phone: " + item.phone +
                    "<br>Time of Submission: " + item.time_of_submition +
                    "<br>Time of Acceptance: " + item.time_of_acceptance +
                    "<br>Product Category: " + item.name_category +
                    // posothta
                    "<br>Vehicle name: " + item.vehicle_name

                )
            if (rescuerCoordinates.lat && rescuerCoordinates.lng) {
                L.polyline([
                    [rescuerCoordinates.lat, rescuerCoordinates.lng],
                    [parseFloat(item.lat), parseFloat(item.lng)]
                ], { color: 'red' }).addTo(lines);
            }

        });
    })
    .catch(error => console.error('Error fetching data:', error));