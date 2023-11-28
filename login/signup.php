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
        //save to database
       
        $query = "INSERT INTO user (username, password, user_type, first_name, last_name, phone) 
        VALUES ('$user_name', '$password', 'User', '$first_name', '$last_name', '$phone')";
        if (mysqli_query($con, $query)) {
            // Insert into location table
            $coordinatesQuery = "INSERT INTO location (x_coordinate, y_coordinate) VALUES ('$latitude', '$longitude')";

            if (mysqli_query($con, $coordinatesQuery)) {
                header("Location: Login.php");
                die;
            } else {
                echo "Error inserting into location table: " . mysqli_error($con);
            }
        } else {
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
   <style>
    #map { height: 350px; }
   </style>

</head>
<body>

<head1><h1>ΦΟΡΜΑ ΠΑΡΟΧΗΣ ΒΟΗΘΕΙΑΣ</h1></head1>
<head1><h2>SIGN UP</h2></head1>
<form method="post">                                      <!--form-->
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

        <input type="submit" value="Signup" name="submit"><br><br>
     
        <a href="Login.php">Click to login</a><br><br>  
    </form>
  
    <div id="map">
   

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

