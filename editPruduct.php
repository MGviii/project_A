<?php
session_start();
require('db.php');
$supplier_id = $_SESSION['supplier_id'];

// Get product ID from the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND supplier_id = ?");
    $stmt->bind_param("ii", $product_id, $supplier_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
        echo "Product not found or you don't have permission to edit this product.";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Update product details
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ? AND supplier_id = ?");
    $stmt->bind_param("ssdii", $name, $description, $price, $product_id, $supplier_id);

    if ($stmt->execute()) {
        echo "Product updated successfully!";
        header("Location: supplier_dashboard.php"); // Redirect to the dashboard after updating
    } else {
        echo "Error updating product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>

<form action="" method="POST">
    <label for="name">Product Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>

    <label for="price">Price (USD):</label><br>
    <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>

    <input type="submit" value="Update Product">
</form>

<a href="supplier_dashboard.php">Go back</a>

</body>
</html>
