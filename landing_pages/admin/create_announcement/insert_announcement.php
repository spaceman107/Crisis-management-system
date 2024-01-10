<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crisis management";

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$announcementText = $_POST['announcementText'];
$productIds = $_POST['productIds'];

// Insert data into the 'announcement' table
$sql = "INSERT INTO announcement (description) VALUES ('$announcementText')";
$conn->query($sql);

// Get the last inserted announcement_id
$announcementId = $conn->insert_id;

// Insert data into the 'announcement_products' table
foreach ($productIds as $productId) {
    $sql = "INSERT INTO announcement_products (announcement_id, product_id) VALUES ('$announcementId', '$productId')";
    $conn->query($sql);
}

$conn->close();
?>

