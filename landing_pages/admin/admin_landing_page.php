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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="stock_view/fetch_data.js"></script> 
    
    <link rel="stylesheet" type="text/css" href="admin.css" />
    
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
            <script type="text/javascript" src="view_map/admin_map.js"></script>
        </div>
        <div id="stock-view" class="panel">
            <h2>Stock View Panel</h2>
             
            <label for="category-filter">Choose a category:</label>
            <select name="categories" id="categories-dropdown"></select>

            <table class="styled-table" border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Details</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody id="tBody"></tbody>
            </table>
        </div>
        <div id="transaction-statistics" class="panel">
            <h2>Transactions Statistics Panel</h2>
                  
            <div style="width: 700px;">
            <canvas id="myChart"></canvas>
        </div>
 
        <script type="text/javascript" src="transaction_Statistics_Chart.js"></script>

<label for="startMonth">Start Month:</label>
<select id="startMonth">
<option value="1">January</option>
  <option value="2">February</option>
  <option value="3">March</option>
  <option value="4">April</option>
  <option value="5">May</option>
  <option value="6">June</option>
  <option value="7">July</option>
  <option value="8">August</option>
  <option value="9">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
</select>

<label for="startYear">Start Year:</label>
<input type="text" id="startYear" placeholder="YYYY">

<label for="endMonth">End Month:</label>
<select id="endMonth">
  <option value="1">January</option>
  <option value="2">February</option>
  <option value="3">March</option>
  <option value="4">April</option>
  <option value="5">May</option>
  <option value="6">June</option>
  <option value="7">July</option>
  <option value="8">August</option>
  <option value="9">September</option>
  <option value="10">October</option>
  <option value="11">November</option>
  <option value="12">December</option>
</select>
<label for="endYear">End Year:</label>
<input type="text" id="endYear" placeholder="YYYY">

<button onclick="fetchAndUpdateChart()">Update Chart</button>
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
