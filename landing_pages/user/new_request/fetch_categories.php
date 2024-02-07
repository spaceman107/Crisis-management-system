<?php


error_reporting(E_ALL);
    ini_set('display_errors', '1');
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crisis management";

// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch category names from the database
$sql = "SELECT * FROM product_type";
$result = mysqli_query($conn, $sql);

// Check for errors in the query
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Fetch data as an associative array
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the categories as JSON
header('Content-Type: application/json');
echo json_encode($categories);

// Close the connection
mysqli_close($conn);
?>

