<?php
session_start();
include("connection.php");

// Check if the required parameters are set
if (isset($_POST['baseId'], $_POST['lat'], $_POST['lng'])) {
    // Sanitize and retrieve the parameters
    $baseId = mysqli_real_escape_string($con, $_POST['baseId']);
    $lat = mysqli_real_escape_string($con, $_POST['lat']);
    $lng = mysqli_real_escape_string($con, $_POST['lng']);

    // Update the database
    $updateQuery = "UPDATE location SET x_coordinate = '$lat', y_coordinate = '$lng' WHERE location_id = '$baseId'";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        // Success response
        $response = array('status' => 'success', 'message' => 'Coordinates updated successfully');
        echo json_encode($response);
    } else {
        // Error response
        $response = array('status' => 'error', 'message' => 'Error updating coordinates');
        echo json_encode($response);
    }
} else {
    // Invalid or missing parameters
    $response = array('status' => 'error', 'message' => 'Invalid or missing parameters');
    echo json_encode($response);
}
?>
