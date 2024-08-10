<?php
session_start();
include("../../../login/connection.php");

// COORDINATES FOR BASE (PINS)
$BaseCoordinatesQuery = "SELECT base.base_id, location.x_coordinate AS lat, location.y_coordinate AS lng , location.location_id 
    FROM location 
    INNER JOIN base ON location.location_id = base.location_id";
$BaseCoordinatesResult = mysqli_query($con, $BaseCoordinatesQuery);

$BaseCoordinates = [];
while ($row = mysqli_fetch_assoc($BaseCoordinatesResult)) {
    $BaseCoordinates[] = $row;
}

// Send JSON response after the loop
header('Content-Type: application/json');
echo json_encode($BaseCoordinates);
?>
