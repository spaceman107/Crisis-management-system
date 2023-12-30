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

// Get the selected categories from the query parameter
$selectedCategories = isset($_GET['category']) ? explode(',', $_GET['category']) : ['all'];

// Prepare the SQL statement based on the selected categories
if (in_array('all', $selectedCategories)) {
    $sql = "SELECT p.*,product_type.name_category AS category, COALESCE(SUM(t.quantity), 0) AS total_quantity_in_transactions
            FROM product p
            LEFT JOIN transaction t ON p.product_id = t.product_id
            LEFT JOIN product_type ON p.product_category = product_type.product_category_id
            WHERE t.status = 'ACCEPTED' OR t.status IS NULL
            GROUP BY p.product_id";
} else {
    // Use IN clause to handle multiple categories
    $selectedCategoriesString = implode(',', $selectedCategories);
    // $sql = "SELECT product.*, transaction.quantity AS quantity_in_vehicle
    //         FROM product 
    //         LEFT JOIN product_type ON product.product_category = product_type.product_category_id 
    //         LEFT JOIN transaction ON product.product_id = transaction.product_id
    //         WHERE product_category IN ($selectedCategoriesString) AND transaction.status = 'ACCEPTED'";


    // $sql = "SELECT product.*, transaction.quantity AS quantity_in_vehicle
    //     FROM product   
    //     LEFT JOIN product_type ON product.product_category = product_type.product_category_id
    //     LEFT JOIN transaction ON product.product_id = transaction.product_id
    //     WHERE $selectedCategories";


        // $sql = "SELECT * FROM product 
        //     LEFT JOIN product_type ON product.product_category = product_type.product_category_id 
        //     WHERE product_category = $selectedCategory";




                $sql = "SELECT p.*,product_type.name_category AS category, COALESCE(SUM(t.quantity), 0) AS total_quantity_in_transactions
            FROM product p
            LEFT JOIN transaction t ON p.product_id = t.product_id
            LEFT JOIN product_type ON p.product_category = product_type.product_category_id
            WHERE (product_category IN ($selectedCategoriesString) OR 'all' IN ($selectedCategoriesString)) AND (t.status = 'ACCEPTED' OR t.status IS NULL)

            GROUP BY p.product_id";

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
