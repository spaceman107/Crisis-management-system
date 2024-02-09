<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");
$user_id = $_SESSION['user_id'];


$sql1 = "SELECT vehicle_id FROM rescuer WHERE user_id = $user_id";
$result1 = $con->query($sql1);

if ($result1 && $result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $vehicleId = $row1['vehicle_id'];


    $sql2 = "SELECT product_id  FROM vehicle_product WHERE vehicle_id = $vehicleId";
    $result2 = $con->query($sql2);

    if ($result2 && $result2->num_rows > 0) {
        $products = array();

    
        while ($row2 = $result2->fetch_assoc()) {
            $productId = $row2['product_id'];

            $sql3 = "SELECT product_name FROM product WHERE product_id = $productId";
            $result3 = $con->query($sql3);

            if ($result3 && $result3->num_rows > 0) {
                $row3 = $result3->fetch_assoc();
                $product = array('product_name' => $row3['product_name']);
                $products[] = $product;
            }
        }

    
        header('Content-Type: application/json');
        echo json_encode($products);
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'No product_id found for the vehicle_id'));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'No vehicle_id found for the user_id'));
}
?>
