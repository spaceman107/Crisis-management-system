<?php
session_start();
include("../../../login/connection.php");


if (isset($_SESSION['user_id'])) {
    $logged_in_user_id = $_SESSION['user_id'];
    $sql = "SELECT transaction_id, status, time_of_acceptance, time_of_completion FROM transaction WHERE user_id = $logged_in_user_id";
}

$result = mysqli_query($conn, $sql);

$trans = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($trans);
?>