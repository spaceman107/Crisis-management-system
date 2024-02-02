<?php
session_start();
include("connection.php");

// Retrieve the JSON data from the POST request
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Access the selectedProducts array
$selectedProducts = $input['selectedProducts'];

// Assuming $user_id is already available in the session
$user_id = $_SESSION['user_id'];

// Fetch the vehicle_id associated with the specified user_id
$sql1 = "SELECT vehicle_id FROM rescuer WHERE user_id = $user_id";
$result1 = $con->query($sql1);

if ($result1 && $result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $vehicleId = $row1['vehicle_id'];

    // Insert each selected product and quantity into the vehicle_products table
    foreach ($selectedProducts as $product) {
        $productId = $product['productId'];
        $quantity = $product['quantity'];

        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO vehicle_product (vehicle_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $vehicleId, $productId, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    // Return a response indicating success
    echo json_encode(['success' => true]);
} else {
    // Return an error if no vehicle_id is associated with the user_id
    echo json_encode(['error' => 'No vehicle_id found for the user_id']);
}
?>
