<?PHP

session_start();
include("connection.php");


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
         //Insert into location table
        $coordinatesQuery = "INSERT INTO location (x_coordinate, y_coordinate) VALUES ('$latitude', '$longitude')";
        
        if (mysqli_query($con, $coordinatesQuery)) {
            $location_id = mysqli_insert_Id($con);
            //save to database
           $query = "INSERT INTO user (username, password, user_type, first_name, last_name, phone,location_id) 
            VALUES ('$user_name', '$password', 'User', '$first_name', '$last_name', '$phone','$location_id')";
            
            if (mysqli_query($con, $query)) {
                header("Location: Login.php");
                die;
            } else 
            {
                echo "Error inserting into location table: " . mysqli_error($con);
            }
        } else 
        {
            echo "Error inserting into login_info/user table: " . mysqli_error($con);
        }
    } else {
        echo "Please enter valid information!";
    }
}
?>


<!DOCTYPE html>
<html lang="el">
<head>
    <link rel="stylesheet" href="styles.css">
   
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
   

</head>
<body>

<div class="form-container">

        <h1 class="form-heading">Crisis Management System</h1>
        <h2 class="form-subheading">Signup</h2>
<form method="post">                                      <!--form-->
        <label for="user_name">Username:</label>
        <input type="text" id="user_name" name="user_name" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        <label>Click your location on the map:</label>
        <div id="map"></div><br>

        <input type="submit" value="Signup" name="submit"><br>
     
        <a href="login.php">Click to login</a><br>
    </form>
  
    
</div>
 

</body>
<script>
  var map = L.map('map').setView([37.983810, 23.727539], 11);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

var marker;

function onMapClick(e) {
    const { lat, lng } = e.latlng;

    // Update the marker position
    if (marker) {
        marker.setLatLng(e.latlng);
    } else {
        // Create a new marker if it doesn't exist
        marker = L.marker(e.latlng).addTo(map);
    }

    // Set the values of the hidden input fields
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
}

map.on('click', onMapClick);
</script>    


</html>
