<?php
include 'connection.php';

if (isset($_GET['category'])) {

     // Fetch items based on the selected category
     $category = $_GET['category'];
     $sql = "SELECT product_id, product_name FROM product WHERE product_category = $category"; // Replace items with your actual table name and field names
 
     $result = $con->query($sql);
 
     $items = array();
 
     if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
             $items[] = array('product_id' => $row['product_id'], 'product_name' => $row['product_name']);
         }
     }
 
     echo json_encode($items);

}
?>