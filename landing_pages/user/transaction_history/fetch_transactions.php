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


$sql = "SELECT transaction_id, status, time_of_acceptance, time_of_completion FROM transaction WHERE user_id = '4'";


$result = mysqli_query($conn, $sql);

$trans = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($trans);
?>