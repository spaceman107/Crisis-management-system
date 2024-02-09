<?php
session_start();
include("../../../login/connection.php");
include("../../../login/functions.php");

$query = "SELECT a.announcement_id, a.description,GROUP_CONCAT(ap.product_id SEPARATOR ', ') AS pro_id, GROUP_CONCAT(p.product_name SEPARATOR ', ') AS products
          FROM announcement a
          LEFT JOIN announcement_products ap ON a.announcement_id = ap.announcement_id
          LEFT JOIN product p ON ap.product_id = p.product_id
          GROUP BY a.announcement_id";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);


header('Content-Type: application/json');
echo json_encode($announcements);
?>

