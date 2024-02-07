
<?php


$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crisis management";



error_reporting(E_ALL);
ini_set('display_errors', '1');

// Create connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);



$query = "SELECT a.announcement_id, a.description,GROUP_CONCAT(ap.product_id SEPARATOR ', ') AS pro_id, GROUP_CONCAT(p.product_name SEPARATOR ', ') AS products
          FROM announcement a
          LEFT JOIN announcement_products ap ON a.announcement_id = ap.announcement_id
          LEFT JOIN product p ON ap.product_id = p.product_id
          GROUP BY a.announcement_id";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($announcements);
?>

