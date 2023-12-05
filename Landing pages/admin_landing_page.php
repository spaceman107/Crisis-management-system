<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

    </style>

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
                <li><a href="#load-json-from-usidas">Load json from Usidas</a></li>
                <li><a href="#upload-json">Upload local json file</a></li>
            </ul>

        <h3>Select items for transport</h3>
        <form action="process_transfer.php" method="post" class="transport-form">
            <label for="categories">Select Item Categories:</label><br>
            <select name="name_category">
             <option value="">Select item categories</option>
            <?php
            $sql = "SELECT * from product_type";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $category_name = $row['name_category'];
                    $category_id = $row['product_category_id'];

                   echo '<option value="'.$category_id.'">'.$category_name.'</option>'; ?> 
            </select>
            <label for="items">Select Items:</label><br>
            <select name="name">
                <option value="">Select items:</option>
            <?php
            $sqln = "SELECT * from product where product_category ='.$category_id.' ";
            $resultn = $con->query($sqln);

            if ($resultn->num_rows > 0) {
                while ($rown = $resultn->fetch_assoc()) {
                    $product_name = $rown['name'];
                    $product_id = $rown['product_id'];

                   echo '<option value="'.$product_id.'">'.$product_name.'</option>';
                }
            } 
        }
    } ?>
            </select>

    <button type="submit", class="transport-submit-button">Submit Transport</button>
    </form>
        
    </section>

    <section id="view-map">
        <h2>View Map</h2>

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

