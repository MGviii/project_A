<?php
include("../db.php"); // Include database connection

// Delete a single product if the ID is passed via GET
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);  // Sanitize input

    // Delete query
    $sql = "DELETE FROM products WHERE id = $product_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: products.php?msg=Product deleted successfully");
    } else {
        header("Location: products.php?msg=Error deleting product");
    }
}

// Delete multiple products if selected via POST
if (isset($_POST['product_ids'])) {
    $product_ids = $_POST['product_ids'];  // Get the array of selected product IDs

    // Sanitize and prepare IDs for SQL query
    $product_ids = implode(',', array_map('intval', $product_ids));

    // Delete query for multiple products
    $sql = "DELETE FROM products WHERE id IN ($product_ids)";

    if ($conn->query($sql) === TRUE) {
        header("Location: products.php?msg=Products deleted successfully");
    } else {
        header("Location: products.php?msg=Error deleting products");
    }
} else if (isset($_POST['delete_selected'])) {
    header("Location: products.php?msg=No products selected");
}

$conn->close();
?>
