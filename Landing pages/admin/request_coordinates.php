<?php
session_start();
include("connection.php");
include("functions.php");
// COORDINATES FOR USER REQUEST (PINS)
$RequestCoordinatesQuery = " SELECT x_coordinate AS lat, y_coordinate AS lng ,   user.first_name ,
user.last_name,
user.phone, 
transaction.time_of_submition
    FROM location 
    INNER JOIN user  ON location.location_id = user.location_id 
    INNER JOIN transaction ON user.user_id = transaction.user_id 
    WHERE transaction.type = 'REQUEST'";
$RequestCoordinatesResult = mysqli_query($con, $RequestCoordinatesQuery);

$RequestCoordinates = [];
while ($row = mysqli_fetch_assoc($RequestCoordinatesResult)) {
    $RequestCoordinates[] = $row;
    header('Content-Type: application/json');
echo json_encode($RequestCoordinates);
}
?> 
