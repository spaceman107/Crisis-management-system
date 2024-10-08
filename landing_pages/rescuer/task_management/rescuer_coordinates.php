<?php
session_start();
include("../../../login/connection.php");

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $logged_in_user_id = $_SESSION['user_id'];

    // Assuming $con is your database connection
    $RescuerCoordinatesQuery = "SELECT x_coordinate AS lat, y_coordinate AS lng, user.first_name, user.last_name
        FROM location 
        INNER JOIN user ON location.location_id = user.location_id 
        WHERE (user.user_type='Rescuer' AND user.user_id = $logged_in_user_id)";

    $RescuerCoordinatesResult = mysqli_query($con, $RescuerCoordinatesQuery);

    $RescuerCoordinates = [];
    while ($row = mysqli_fetch_assoc($RescuerCoordinatesResult)) {
        $RescuerCoordinates[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($RescuerCoordinates);
} else {
    // Handle the case where the user is not logged in
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in']);
}
?>
