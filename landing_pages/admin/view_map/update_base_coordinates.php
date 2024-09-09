<?php
session_start();
include("../../../login/connection.php");


if (isset($_POST['locationId'], $_POST['lat'], $_POST['lng'])) {
    // Retrieve the parameters
    $locationId = $_POST['locationId']; // Convert to integer
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

 
    $updateQuery = "UPDATE location SET x_coordinate = ?, y_coordinate = ? WHERE location_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);


    if ($stmt === false) {
        die('Error preparing statement');
    }

    
    mysqli_stmt_bind_param($stmt, "ddi", $lat, $lng, $locationId);

   
    $result = mysqli_stmt_execute($stmt);

    if ($result === false) {
        die('Error executing statement: ' . mysqli_stmt_error($stmt));
        echo json_encode($response);
    }

    mysqli_stmt_close($stmt);


    header("Location: ../admin_landing_page.php");
} else {

    $response = array('status' => 'error', 'message' => 'Invalid or missing parameters');
    echo json_encode($response);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>  
