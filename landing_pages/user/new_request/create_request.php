<?php
session_start();
include("../../../login/connection.php");
$logged_in_user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProducts = $_POST['products'];
    $numPeople = $_POST['num-people'];

    for ($i = 0; $i < count($selectedProducts); $i++) {
        $product = $selectedProducts[$i];
        
        $sql = "INSERT INTO transaction (user_id,product_id,number_of_people_in_need,status, type, quantity) VALUES ($logged_in_user_id,$product,$numPeople,'PENDING','REQUEST', '10')";
                   
            mysqli_query($con, $sql);

    }
}
?>
