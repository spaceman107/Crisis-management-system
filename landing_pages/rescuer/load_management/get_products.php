<?php
session_start();
include("connection.php");


// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch products from the database using an SQL query
$sql = "SELECT product_id, product_name , quantity FROM product";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Store the results in an array
    $products = array();
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Return the products as JSON
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    // Return an empty array if no products are found
    header('Content-Type: application/json');
    echo json_encode(array());
}

// Close the database connection
$con->close();
?>
