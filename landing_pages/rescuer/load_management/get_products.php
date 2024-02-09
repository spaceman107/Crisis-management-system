<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");



if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


$sql = "SELECT product_id, product_name , quantity FROM product";
$result = $con->query($sql);

if ($result->num_rows > 0) {
   
    $products = array();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

  
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
   
    header('Content-Type: application/json');
    echo json_encode(array());
}


$con->close();
?>
