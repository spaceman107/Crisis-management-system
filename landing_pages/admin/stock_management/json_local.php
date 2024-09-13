<?php
include("../../../login/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['json_local'])) {
    $file_name = $_FILES['json_local']['name'];
    $file_tmp = $_FILES['json_local']['tmp_name'];
    $file_type = $_FILES['json_local']['type'];

    if ($file_type === 'application/json') {
        // Move uploaded JSON file to a location
        $target_directory = "C:/xampp/htdocs/web project/landing_pages/admin/stock_management/";
        $target_file = $target_directory . basename($file_name);

        if (move_uploaded_file($file_tmp, $target_file)) {
            // JSON file uploaded successfully, proceed with inserting into MySQL
            $json_data = file_get_contents($target_file);

            if ($json_data !== false) {
                // Decode JSON data into an associative array
                $data = json_decode($json_data, true);
        
                foreach ($data['categories'] as $category) {
                    $cat_id = $category['id'];
                    $cat_name = $category['category_name'];
        
                    $query = "INSERT INTO product_type (product_category_id, name_category) VALUES ('$cat_id', '$cat_name')";
                    mysqli_query($con, $query);
        
                }
        
                foreach ($data['items'] as $item) {
                    $id = $item['id'];
                    $name = $item['name'];
                    $category = $item['category'];
                    // Create a variable to hold concatenated details
                    $concatenated_details = '';
        
                    // Concatenate details if available
                    foreach ($item['details'] as $detail) {
                        $concatenated_details .= $detail['detail_name'] . ': ' . $detail['detail_value'] . ', ';
                    }
        
                    // Remove the trailing comma and space
                    $concatenated_details = rtrim($concatenated_details, ', ');
                    $sql = "INSERT INTO product (product_id, quantity, product_category, details, product_name) VALUES ('$id', NULL, '$category', '$concatenated_details', '$name') ";
                    mysqli_query($con, $sql);
                }
                    header("Location:landing_pages/admin/admin_landing_page.php");
            }
        }
    }
}
    ?>
