<?php


$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "crisis management";

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Create connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedProducts = $_POST['products'];
    $quantities = $_POST['quantities'];

    // looping through the arrays
    for ($i = 0; $i < count($selectedProducts); $i++) {
        $product = $selectedProducts[$i];
        $quantity = $quantities[$i];

        $sql = "INSERT INTO transaction (transaction_id, user_id,product_id,number_of_people_in_need,status, type, quantity) VALUES (45,4,$product,'3','PENDING','OFFER', $quantity)";
                   
            mysqli_query($connection, $sql);

    }
}
?>
