<?php
session_start();
include("../../../login/connection.php");

// Check if the required parameters are set
if (isset($_POST['lat'], $_POST['lng'])) {
    // Sanitize and retrieve the parameters
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $logged_in_location_id = $_SESSION['location_id'];

    // Update the database
    $updateQuery = "UPDATE location SET x_coordinate = ?, y_coordinate = ? WHERE location_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);

    // Check for errors in preparing the statement
    if ($stmt === false) {
        die('Error preparing statement');
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ddi", $lat, $lng, $logged_in_location_id);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    // Check for errors in executing the statement
    if ($result === false) {
        die('Error executing statement: ' . mysqli_stmt_error($stmt));
        echo json_encode($response);
    }

    mysqli_stmt_close($stmt);

    // Success response
    header("Location: rescuer_landing_page.php");
} else {
    // Invalid or missing parameters
    $response = array('status' => 'error', 'message' => 'Invalid or missing parameters');
    echo json_encode($response);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>  
