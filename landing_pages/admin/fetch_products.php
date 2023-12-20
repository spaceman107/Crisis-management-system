<?php

// Replace these values with your actual database connection details
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crisis management";

error_reporting(E_ALL);
    ini_set('display_errors', '1');

// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the selected category from the query parameter
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

// Prepare the SQL statement based on the selected category
if ($selectedCategory === 'all') {
    $sql = "SELECT * FROM product   
            LEFT JOIN product_type ON product.product_category = product_type.product_category_id";
} else {
    $sql = "SELECT * FROM product 
            LEFT JOIN product_type ON product.product_category = product_type.product_category_id 
            WHERE product_category = $selectedCategory";
}

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors in the query
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Fetch the results as an associative array
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the products as JSON
header('Content-Type: application/json');
echo json_encode($products);

// Close the connection
mysqli_close($conn);
?>


