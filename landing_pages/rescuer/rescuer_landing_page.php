<?php
session_start();
include("connection.php");
include("functions.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescuer Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="stylesheet" type="text/css" href="rescuer.css" />
    
</head>

<body>
    <header>
        <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
        <h2>Rescuer Dashboard</h2>
        <a class="logout-btn" href="#">Logout</a>
    </header>
    <div id="mySidebar" class="sidebar">
        <nav>
            <ul>
                <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('load-management')">Load Management</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('view-map')">View Map</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('task-management')">Task Management</a></li>    
            </ul>
        </nav>
    </div>
    <div id="main">
        <!-- Panels -->
        <div id="load-management" class="panel">
            <h2>Load Management Panel</h2>
            <h3>Select Items for Transport</h3>
        <form action="process_load_items.php" method="post" id ="process_items_form">
            <label for="items">Select Items:</label>
            <select name="items[]" id="items" multiple>
            <?php
            $sql = "SELECT product.product_id, product.product_name, product.quantity FROM product";
            $result = mysqli_query($con, $sql);
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["product_id"] . "'>" . $row["product_name"] . " (Available: " . $row["quantity"] . ")</option>";
                }
            } ?>
            </select>
            <br><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1">
            <br><br>
            <input type="submit" value="Load Items">
            <script type="text/javascript" src="rescuer_load_mng_dst.js"></script>
        </form>
        </div>
        <div id="view-map" class="panel">
            <h2>View Map Panel</h2>
            <div id="map"></div>
            <script type="text/javascript" src=""></script>
        </div>
        <div id="task-management" class="panel">
            <h2>Task Management Panel</h2>
            <p>Content for task management...</p>
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
    