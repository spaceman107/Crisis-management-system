<?php
session_start();
include("connection.php");
$user_id = $_SESSION['user_id'];

// Fetch vehicle_id associated with the specified user_id
$sql1 = "SELECT vehicle_id FROM rescuer WHERE user_id = $user_id";
$result1 = $con->query($sql1);

if ($result1 && $result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $vehicleId = $row1['vehicle_id'];

    // Fetch product_id and quantity associated with the specified vehicle_id
    $sql2 = "SELECT product_id, quantity FROM vehicle_product WHERE vehicle_id = $vehicleId";
    $result2 = $con->query($sql2);

    if ($result2 && $result2->num_rows > 0) {
        // Loop through each product_id and quantity
        while ($row2 = $result2->fetch_assoc()) {
            $productId = $row2['product_id'];
            $quantity = $row2['quantity'];

            // Update the product table with the new quantity
            $sql3 = "UPDATE product SET quantity = quantity + $quantity WHERE product_id = $productId";
            $result3 = $con->query($sql3);

            // Check if the update query was successful
            if (!$result3) {
                header('Content-Type: application/json');
                echo json_encode(array('error' => 'Error updating product quantity'));
                exit;
            }
        }

        // Now that products are updated, delete the records in vehicle_product
        $sql4 = "DELETE FROM vehicle_product WHERE vehicle_id = $vehicleId";
        $result4 = $con->query($sql4);

        // Check if the delete query was successful
        if (!$result4) {
            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Error deleting records from vehicle_product'));
            exit;
        }

        // Return a success response
        header('Content-Type: application/json');
        echo json_encode(array('success' => true, 'message' => 'Products unloaded successfully.'));
    } else {
        // Return an error if no records found for the specified vehicle_id in vehicle_product
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'No records found for the specified vehicle_id in vehicle_product'));
    }
} else {
    // Return an error if no vehicle_id is associated with the user_id
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'No vehicle_id found for the user_id'));
}
?>
