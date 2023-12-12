<?php
    session_start();
    include("connection.php");
    include("functions.php");

// COORDINATES FOR USER(PINS)
// COORDINATES FOR USER REQUEST (PINS)
$RequestCoordinatesQuery = " SELECT x_coordinate AS lat, y_coordinate AS lng ,   user.first_name ,user.last_name,user.phone, transaction.time_of_submition
    FROM location 
    INNER JOIN user  ON location.location_id = user.location_id 
    INNER JOIN transaction ON user.user_id = transaction.user_id 
    WHERE transaction.type = 'REQUEST'";
$RequestCoordinatesResult = mysqli_query($con, $RequestCoordinatesQuery);

$RequestCoordinates = [];
while ($row = mysqli_fetch_assoc($RequestCoordinatesResult)) {
    $RequestCoordinates[] = $row;
}
// COORDINATES FOR USER OFFER (PINS)
$OfferCoordinatesQuery = " SELECT x_coordinate AS lat, y_coordinate AS lng ,   user.first_name ,user.last_name,user.phone, transaction.time_of_submition,product_category 
    FROM location    
    INNER JOIN user  ON location.location_id = user.location_id 
    INNER JOIN transaction ON user.user_id = transaction.user_id 
    INNER JOIN product ON transaction.product_id = product.product_id  
    WHERE transaction.type = 'OFFER' ";
$OfferCoordinatesResult = mysqli_query($con, $OfferCoordinatesQuery);

$OfferCoordinates = [];
while ($row = mysqli_fetch_assoc($OfferCoordinatesResult)) {
    $OfferCoordinates[] = $row;
}


// COORDINATES FOR BASE(PINS)
$BaseCoordinatesQuery = "SELECT base.base_id, location.x_coordinate AS lat, location.y_coordinate AS lng
    FROM location 
    INNER JOIN base ON location.location_id = base.location_id";
$BaseCoordinatesResult = mysqli_query($con, $BaseCoordinatesQuery);

$BaseCoordinates = [];
while ($row = mysqli_fetch_assoc($BaseCoordinatesResult)) {
    $BaseCoordinates[] = $row;
}
// COORDINATES FOR vehicle(PINS)
$VehicleCoordinatesQuery = " SELECT vehicle.vehicle_name, product.product_name ,transaction.status, x_coordinate AS lat, y_coordinate AS lng
    FROM location 
    INNER JOIN user ON location.location_id = user.location_id 
    INNER JOIN rescuer ON user.user_id = rescuer.user_id
    INNER JOIN vehicle ON  rescuer.vehicle_id = vehicle.vehicle_id 
    INNER JOIN task ON vehicle.vehicle_id = task.vehicle_id
    INNER JOIN transaction ON task.transaction_id = transaction.transaction_id
    INNER JOIN product ON transaction.product_id = product.product_id";

$VehicleCoordinatesResult = mysqli_query($con, $VehicleCoordinatesQuery);

$VehicleCoordinates = [];
while ($row = mysqli_fetch_assoc($VehicleCoordinatesResult)) {
    $VehicleCoordinates[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }

        #map { height: 80%; 
               width: 80%;
        }

        section {
            position: relative;
            flex: 1;
            padding: 20px;
        }

        .logout-btn {
            position: absolute;
            top: 30px;
            right: 15px;
            background-color: #4285f4;
            color: #fff;
            padding: 0.5em 1em;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #0056b3;
        }

        .wrapper {
            display: flex;
            min-height: 100%;
        }

        .wrapper.collapsed nav {
            width: 0;
        }

        nav {
            width: 250px;
            background-color: #444;
            color: white;
            padding: 10px;
            box-sizing: border-box;
            transition: width 0.3s;
            overflow: hidden;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #111;
        }

        section {
            flex: 1;
            padding: 20px;
        }

        section h2 {
            border-bottom: 2px solid #444;
            padding-bottom: 5px;
        }

        section ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        section a {
            text-decoration: none;
            color: rgb(135, 84, 84);
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        section a:hover {
            background-color: #111;
        }
    

        ul {
            list-style-type: none;
        }

        ul ul {
            margin-top: 10px;
            margin-left: 20px;
        }

        .toggleButton {
            position: absolute;
            top: 4px;
            left: 10px;
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 50px;
        }



        section#create-announcement {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 20px;
            text-align: center;
        }



        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-top: 10px;
            color: #555;
            font-weight: bold;
        }

        textarea,
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .announcement-submit-button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .announcement-submit-button:hover {
            background-color: #45a049;
        }

        .transport-submit-button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin: 20px;
        }

        .transport-submit-button:hover {
            background-color: #45a049;
        }
        
        .transport-form label  {
            text-align: left;
        }

        .json-fetch-data input{
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin: 20px;
            width: fit-content;
            
        }
        

    </style>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

</head>
<body>

<header>
    <h2>Admin Dashboard</h2>
    <button class="toggleButton", id="toggleButton">&#9776;</button>
    <a class="logout-btn" href="#">Logout</a>
</header>

<div class="wrapper">
    <nav>
        <ul>
            <li><a href="#stock-management">Stock Management</a></li>
            <li><a href="#view-map">View Map</a></li>
            <li><a href="#stock-view">Stock View</a></li>
            <li><a href="#transaction-statistics">Transactions Statistics</a></li>
            <li><a href="#add-rescuer">Add Rescuer</a></li>
            <li><a href="#create-announcement">Create Announcement</a></li>
        </ul>
    </nav>

    <section id="stock-management">
        <h2>Stock Management</h2>
        <h3>Load product description from json file</h3>
            <ul>
                <li><form action="json_usidas.php" method="post" class="json-fetch-data">
                    <input type="submit" name="fetch_json_usidas" value="Json from Usidas" >
                    </form>
                </li>
                <li><form action="json_local.php" method="post" enctype="multipart/form-data" class="json-fetch-data">
                    <input type = "file" name="json_local" accept=".json" required>
                    <br>
                    <input type="submit" name="fetch_json_local" value="Upload local json file" >
                    </form>
                </li>
            </ul>

        <h3>Select items for transport</h3>
        <form action="process_transfer.php" method="post" class="transport-form">
            <label for="categories">Select Item Categories:</label><br>
            <select name="category" id="category">
             <option value="">Select item categories</option>
            <?php
            $sql = "SELECT * from product_type";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $category_name = $row['name_category'];
                    $category_id = $row['product_category_id'];

                   echo '<option value="'.$category_id.'">'.$category_name.'</option>';
                }
            } ?> 
            </select>
            <br>
            <div id="itemTables"></div>

            <input type="submit" value="Submit Items for transport">
        </form>
            
    <script>
        // Fetch items based on selected category using JavaScript
        document.getElementById('category').addEventListener('change', function() {
            var category = this.value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var items = JSON.parse(xhr.responseText);
                        var table = '<table><tr><th>Select</th><th>Item ID</th><th>Item Name</th></tr>';
                        items.forEach(function(item) {
                            table += '<tr>';
                            table += '<td><input type="checkbox" name="selectedItems[]" value="' + item.product_id + '"></td>';
                            table += '<td>' + item.product_id + '</td>';
                            table += '<td>' + item.product_name + '</td>';
                            table += '</tr>';
                        });
                        table += '</table>';
                        var newItemTable = document.createElement('div');
                        newItemTable.innerHTML = '<h3>Items in Category ' + category + '</h3>' + table;
                        document.getElementById('itemTables').appendChild(newItemTable);
                    } else {
                        console.error(xhr.status);
                    }
                }
            };
            xhr.open('GET', 'get_items.php?category=' + category, true);
            xhr.send();
        });
    </script>
        
    </section>

    <section id="view-map">
        <h2>View Map</h2>

        <div id="map"></div>


        <script>
          var map = L.map('map').setView([37.983810, 23.727539], 11);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '© OpenStreetMap contributors'
          }).addTo(map);

        
          // Coordinates from PHP
          var OfferCoordinates = <?php echo json_encode($OfferCoordinates); ?>;
          console.log(OfferCoordinates); 
          // Add markers to the map with colored icons
          OfferCoordinates.forEach(item => {
          var markerOffer= L.divIcon({
            html :'<img src="https://cdn-icons-png.flaticon.com/512/4151/4151073.png" width="30" height="30" alt="Custom Marker">',
            className: 'markerOffer',
            iconSize: [30, 20],     
            });
 
            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerOffer }).addTo(map).bindPopup("Offer.");
          
            });

         // Coordinates from PHP
         var RequestCoordinates = <?php echo json_encode($RequestCoordinates); ?>;
          console.log(RequestCoordinates); 
          // Add markers to the map with colored icons
          RequestCoordinates.forEach(item => {
          var markerRequest= L.divIcon({
            html :'<img src="https://cdn-icons-png.flaticon.com/512/4151/4151073.png" width="30" height="30" alt="Custom Marker">',
            className: 'markerRequest',
            iconSize: [30, 20],     
            });
 
            L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerRequest }).addTo(map).bindPopup("Request.");
          
            });    




            var BaseCoordinates = <?php echo json_encode($BaseCoordinates); ?>;
var draggableMarkers = {};

BaseCoordinates.forEach(item => {
    var markerBase = L.divIcon({
        html: '<img src="https://cdn.iconscout.com/icon/free/png-256/free-base-1786434-1520324.png" width="30" height="30" alt="Custom Marker">',
        className: 'markerBase',
        iconSize: [30, 20],
    });

    var baseMarker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerBase, draggable: true }).addTo(map).bindPopup("Base id :" + item.base_id);

    // Event listener for dragend
    baseMarker.on('dragend', function (event) {
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
                alert('Coordinates updated successfully');
            } else {
                alert('Error updating coordinates');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


var VehicleCoordinates = <?php echo json_encode($VehicleCoordinates); ?>;

VehicleCoordinates.forEach(item => {
    var markerVehicle = L.divIcon({
        html: '<img src="https://png.pngtree.com/png-vector/20220119/ourmid/pngtree-vehicle-leaflet-material-vector-icon-label-png-image_4239122.png" width="30" height="30" alt="Custom Marker">',
        className: 'markerVehicle',
        iconSize: [30, 20],
    });

    L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: markerVehicle }).addTo(map).bindPopup("vehicle name :" + item.vehicle_name + "");
});
;

        </script>
        <!-- Content for Stock Management goes here -->
    </section>

    <section id="stock-view">
        <h2>Stock View</h2>
        <!-- Content for Stock Management goes here -->
    </section>

    <section id="transaction-statistics">
        <h2>Transactions Statistics</h2>
        <!-- Content for Stock Management goes here -->
    </section>


    <section id="add-rescuer">
        <h2>Add Rescuer</h2>
        <!-- Content for Stock Management goes here -->
    </section>

    <section id="create-announcement">
        <h2>Create Announcement</h2>

        <form>
            <label for="announcementText">Announcement Text:</label>
            <textarea id="announcementText" name="announcementText" rows="4" cols="50"></textarea>

            <label for="announcementProducts">Announcement Products:</label>
            <input type="text" id="announcementProducts" name="announcementProducts">

            <button type="submit", class="announcement-submit-button">Submit Announcement</button>
        </form>

        
        <!-- Content for Stock Management goes here -->
    </section>


</div>

<script>
    // JavaScript code to handle dynamic menu changes

    // Get all menu items and content containers
    const menuItems = document.querySelectorAll('nav a');
    const contentContainers = document.querySelectorAll('section');

    // Get the toggle button and wrapper
    const toggleButton = document.getElementById('toggleButton');
    const wrapper = document.querySelector('.wrapper');

    // Function to toggle the menu
    function toggleMenu() {
        wrapper.classList.toggle('collapsed');
    }

    // Function to set the active class and show the corresponding content
    function setActiveClass(index) {
        menuItems.forEach(item => item.classList.remove('active'));
        contentContainers.forEach(container => container.style.display = 'none');

        menuItems[index].classList.add('active');
        contentContainers[index].style.display = 'block';
    }

    // Add click event listeners to each menu item
    menuItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            setActiveClass(index);
        });
    });

    // Set an initial active class (for the Stock Management section, for example)
    setActiveClass(0);

    // Add click event listener to the toggle button
    toggleButton.addEventListener('click', toggleMenu);
</script>

</body>
</html>
