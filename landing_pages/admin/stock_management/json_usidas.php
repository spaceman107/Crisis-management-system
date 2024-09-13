<?php
include("../../../login/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Predefined JSON URL
    $json_url = 'http://usidas.ceid.upatras.gr/web/2023/export.php'; // Replace with your JSON URL
    
    // Fetch JSON data from the predefined URL
    $json_data = file_get_contents($json_url);

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

?>
