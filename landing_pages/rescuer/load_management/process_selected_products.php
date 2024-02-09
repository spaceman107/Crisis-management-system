<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

$selectedProducts = $input['selectedProducts'];

$user_id = $_SESSION['user_id'];

$sql1 = "SELECT vehicle_id FROM rescuer WHERE user_id = $user_id";
$result1 = $con->query($sql1);

if ($result1 && $result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $vehicleId = $row1['vehicle_id'];

    foreach ($selectedProducts as $product) {
        $productId = $product['productId'];
        $quantity = $product['quantity'];

        $stmt = $con->prepare("INSERT INTO vehicle_product (vehicle_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $vehicleId, $productId, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'No vehicle_id found for the user_id']);
}
?>
