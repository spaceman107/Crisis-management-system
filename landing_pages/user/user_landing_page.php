<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crisis Managment</title>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="announcements/announcements.js"></script>
    <script src="new_request/fetch_data.js"></script>
    <script src="transaction_history/history.js"></script>
    <link rel="stylesheet" type="text/css" href="user.css" />
</head>

<body>
    <header>
        <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
        <h2>Crisis Managment</h2>
        <a class="logout-btn" href="../login/logout.php>Logout</a>
    </header>
    <div id="mySidebar" class="sidebar">
        <nav>
            <ul>
                <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('new-request')"> <button type="new-request"> New request </button> </a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('transaction-history')">Transaction history</a></li>
                <li><a href="javascript:void(0)" onclick="changePanel('announcements')">Announcements</a></li>
            </ul>
        </nav>
    </div>
    <div id="main">
        <!-- Panels -->
        <div id="new-request" class="panel">
            <h2>New request</h2>
            <label for="category-filter">Choose categories:</label>
            <div id="categories-checkboxes"></div>
            <form class="request" autocomplete="on">
                <label for="autocomplete">Search category: </label>
                <input type="text" name="autocomplete" id="autocomplete">
            </form>
            <form action="new_request/create_request.php" class="request" method="POST">
                <label for="num-people">Enter the amount of people in need:<input type="text" name="num-people" min="1"></label>
                <label>After checking the desired products press the button to
                    submit you request: <br><br><button type="submit" class="request-button">Submit request</button>
                </label>
                <table class="styled-table" border="1">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Category</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody id="tBody"></tbody>
                </table>
            </form>
        </div>
        <div id="transaction-history" class="panel">
            <h2>Transaction history</h2>
            <table class="styled-table" border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Accepted on</th>
                            <th>Completed on</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="hisBody"></tbody>
            </table>
        </div>
        <div id="announcements" class="panel">
            <h2>Announcements</h2>
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
