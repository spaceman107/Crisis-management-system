<?php
session_start();
include("../../login/connection.php");

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style type="text/css">
    header {
        background-color: #111;
        color: white;
        text-align: center;
        padding: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logout-btn {
        background-color: #4285f4;
        color: #fff;
        padding: 0.5em 1em;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 15px;
        margin-left: 5px;
    }

    .logout-btn:hover {
        background-color: #0056b3;
    }

    /*hide all the other panels*/
    .panel {
        display: none;
    }

    #stock-management {
        display: block;
        /* Show the Stock Management panel by default */
    }

    /* The sidebar menu */
    .sidebar {
        height: 100%;
        /* 100% Full-height */
        width: 0;
        /* 0 width - change this with JavaScript */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Stay on top */
        top: 0;
        left: 0;
        background-color: #111;
        /* Black*/
        overflow-x: hidden;
        /* Disable horizontal scroll */
        padding-top: 60px;
        /* Place content 60px from the top */
        transition: 0.5s;
        /* 0.5 second transition effect to slide in the sidebar */
    }

    /* The sidebar links */
    .sidebar a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    /* When you mouse over the navigation links, change their color */
    .sidebar a:hover {
        color: #f1f1f1;
    }

    .sidebar ul {
        list-style-type: none;
    }

    .sidebar nav ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }


    /* Position and style the close button (top right corner) */
    .sidebar .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    /* The button used to open the sidebar */
    .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: #111;
        color: white;
        padding: 10px 15px;
        border: none;
    }

    .openbtn:hover {
        background-color: #444;
    }

    /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
    #main {
        transition: margin-left .5s;
        /* If you want a transition effect */
        padding: 20px;
    }

    #main h2 {
        border-bottom: 2px solid #444;
        padding-bottom: 5px;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    /*************************/
    /* Stock managment Panel */
    /*************************/
/*    .json-fetch-data,
    .transport-form {
        margin-bottom: 20px;
    }

    .json-fetch-data input,
    .transport-form select {
        margin-bottom: 10px;
    }

    .transport-form label {
        display: block;
        margin-bottom: 5px;
    }

    .json-fetch-data input[type="submit"],
    .transport-form input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .json-fetch-data input[type="submit"]:hover,
    .transport-form input[type="submit"]:hover {
        background-color: #45a049;
    }

    .transport-form select,
    .transport-form input[type="file"] {

        padding: 8px;
        margin: 5px 0 15px;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
*/

    /******************/
    /* View Map Panel */
    /******************/

    #map {
        width: 100%;
        height: 500px;
    }

    /*******************/
    /*Add rescuer panel*/
    /*******************/

/*somethhing affects view map layer control*/

    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    form select {
     padding: 8px;
        margin: 5px 0 15px;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    #map1 {
        height: 200px;
        width: 100%;
        margin-top: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }


    /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidebar {
            padding-top: 15px;
        }

        .sidebar a {
            font-size: 18px;
        }
    }
    </style>
</head>

<body>
    <header>
        <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
        <h2>Admin Dashboard</h2>
        <a class="logout-btn" href="#">Logout</a>
    </header>
    <div id="mySidebar" class="sidebar">
        <nav>
            <ul>
                <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('stock-management')">Stock Management</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('view-map')">View Map</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('stock-view')">Stock View</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('transaction-statistics')">Transactions Statistics</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('add-rescuer')">Add Rescuer</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('create-announcement')">Create Announcement</a></li>
            </ul>
        </nav>
    </div>
    <div id="main">
        <!-- Panels -->
        <div id="stock-management" class="panel">
            <h2>Stock Management Panel</h2>
            <h3>Load product description from json file</h3>
            <ul>
                <li>
                    <form action="json_usidas.php" method="post" class="json-fetch-data">
                        <input type="submit" name="fetch_json_usidas" value="Json from Usidas">
                    </form>
                </li>
                <li>
                    <form action="json_local.php" method="post" enctype="multipart/form-data" class="json-fetch-data">
                        <input type="file" name="json_local" accept=".json" required>
                        <br>
                        <input type="submit" name="fetch_json_local" value="Upload local json file">
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
        </div>
        <div id="view-map" class="panel">
            <h2>View Map Panel</h2>
            <div id="map"></div>
            <script type="text/javascript" src="Admin_map.js"></script>
        </div>
        <div id="stock-view" class="panel">
            <h2>Stock View Panel</h2>
            <p>Content for Stock View...</p>
        </div>
        <div id="transaction-statistics" class="panel">
            <h2>Transactions Statistics Panel</h2>
            <p>Content for Transactions Statistics...</p>
        </div>
        <div id="add-rescuer" class="panel">
            <h2>Add Rescuer Panel</h2>
            <form method="post">
                <!--form-->
                <label for="user_name">Username:</label><br>
                <input type="text" id="user_name" name="user_name" required><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
                <label for="first_name">First Name:</label><br>
                <input type="text" id="first_name" name="first_name" required><br>
                <label for="last_name">Last Name:</label><br>
                <input type="text" id="last_name" name="last_name" required><br>
                <label for="phone">Phone:</label><br>
                <input type="text" id="phone" name="phone" required><br>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <input type="submit" value="Add rescuer" name="submit"><br><br>
                <div id="map1"></div>
                <script>
                var map1 = L.map('map1').setView([37.983810, 23.727539], 11);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map1);

                var marker;

                function onMapClick(e) {
                    const { lat, lng } = e.latlng;

                    // Update the marker position
                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        // Create a new marker if it doesn't exist
                        marker = L.marker(e.latlng).addTo(map1);
                    }

                    // Set the values of the hidden input fields
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                }

                map1.on('click', onMapClick);
                </script>
            </form>
        </div>
        <div id="create-announcement" class="panel">
            <h2>Create Announcement Panel</h2>
            <p>Content for Create Announcement...</p>
        </div>
    </div>
    <script type="text/javascript">
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }

    function changePanel(panelId) {
        // Hide all panels
        var panels = document.getElementsByClassName("panel");
        for (var i = 0; i < panels.length; i++) {
            panels[i].style.display = "none";
        }

        // Show the selected panel
        document.getElementById(panelId).style.display = "block";
    }
    </script>
</body>

</html>