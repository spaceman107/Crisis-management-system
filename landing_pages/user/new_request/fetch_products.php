<?php
session_start();
include("../../../login/connection.php");

//decode the selected categories from the request parameter
$selectedCategories = isset($_GET['category']) ? explode(',', $_GET['category']) : ['all'];

//check if all is in the selected category
if (in_array('all', $selectedCategories)) {
    $sql = "SELECT p.*,product_type.name_category AS category, COALESCE(SUM(t.quantity), 0) AS total_quantity_in_transactions
            FROM product p
            LEFT JOIN transaction t ON p.product_id = t.product_id
            LEFT JOIN product_type ON p.product_category = product_type.product_category_id
            WHERE t.status = 'ACCEPTED' OR t.status IS NULL
            GROUP BY p.product_id";
} else {
    // using IN clause to handle multiple categories
    $selectedCategoriesString = implode(',', $selectedCategories);

    $sql = "SELECT p.*,product_type.name_category AS category, COALESCE(SUM(t.quantity), 0) AS total_quantity_in_transactions
            FROM product p
            LEFT JOIN transaction t ON p.product_id = t.product_id
            LEFT JOIN product_type ON p.product_category = product_type.product_category_id
            WHERE (product_category IN ($selectedCategoriesString) OR 'all' IN ($selectedCategoriesString)) AND (t.status = 'ACCEPTED' OR t.status IS NULL)
            GROUP BY p.product_id";

}



$result = mysqli_query($con, $sql);

//catch errors in the query
if (!$result) {
    die("Error: " . mysqli_error($con));
}

// turn the results in an associative array
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// use the assosiative array to return the products as JSON
header('Content-Type: application/json');
echo json_encode($products);

//close the con
mysqli_close($con);
?>
