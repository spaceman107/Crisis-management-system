<?php
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
        /* 0.5 second transition effect to slide in the sidebar */about:blank#blocked
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
<header>
    <h2>Rescuer Dashboard</h2>
    <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
    <a class="logout-btn" href="#">Logout</a>
</header>
<div id="mySidebar" class="sidebar">
        <nav>
            <ul>
                <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('vehicle-load-management')">Stock Management</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('view-map')">View Map</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('task-management')">Stock View</a></li>
     
            </ul>
        </nav>
    </div>
    <div id="main">
        <!-- Panels -->
        <div id="stock-management" class="panel">
            <!-- Stock Management Panel Content -->
        </div>

        <div id="view-map" class="panel">
        <div id="map"></div>
        <form id="updateForm" action="rescuer_update_coordinates.php" method="post">
        <input type="hidden" id="latInput" name="lat" value="">
       <input type="hidden" id="lngInput" name="lng" value="">
         </form>
            <script type="text/javascript" src="Rescuer_map.js"></script>
        </div>

        <div id="task-management" class="panel">
            <!-- Stock View Panel Content -->
        </div>
       
    </div>

</body>

</html>




