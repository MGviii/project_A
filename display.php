<?php
require('db.php');

// Fetch all products along with their supplier information
$query = "
    SELECT products.*, suppliers.name, suppliers.email, suppliers.contact_details
    FROM products JOIN suppliers ON products.supplier_id = suppliers.id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <style>
        /* Navigation Bar */
        header {
            background-color: #4CAF50;
            padding: 10px 0;
            position: fixed;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 40px;
        }


        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 100%;
            margin: 0 auto;
            padding: 0 20px;

        }

        nav .logo h1 {
            color: white;
            font-size: 24px;

        }

        nav ul {
            list-style: none;
            display: flex;

        }

        nav ul li {
            margin-left: 20px;
            ;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;

        }

        nav ul li a:hover {
            color: #fff7a0;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .product {
            border: 1px solid #ccc;
            padding: 15px;
            width: 250px;
            text-align: center;
        }

        .product img {
            max-width: 100%;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 60%;
            border-radius: 10px;
            text-align: left;
        }

        .modal-close {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h1>All Products</h1>
    <!-- Navigation Bar -->
    <header>
        <nav>
            <div class="logo">
                <h1>Fertilizer Connect</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="display.php">Browse Products</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="login.php" class="login-link">Login</a></li> <!-- New Login Link -->
            </ul>
        </nav>
    </header>
    <div class="product-list">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($product['filePath']); ?>" alt="Product Image">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Price: <?php echo htmlspecialchars($product['price']); ?> USD</p>
                    <button onclick="openModal(<?php echo htmlspecialchars(json_encode($product)); ?>)">Get More Info</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>

    <!-- Modal Structure -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2 id="modalProductName"></h2>
            <p id="modalProductDescription"></p>
            <p id="modalProductPrice"></p>
            <h3>Supplier Information</h3>
            <p id="modalSupplierName"></p>
            <p id="modalSupplierEmail"></p>
            <p id="modalSupplierContact"></p>
        </div>
    </div>

    <!-- JavaScript to Handle Modal Display -->
    <script>
        function openModal(product) {
            // Set the product details in the modal
            document.getElementById('modalProductName').textContent = "Product: " + product.name;
            document.getElementById('modalProductDescription').textContent = "Description: " + product.description;
            document.getElementById('modalProductPrice').textContent = "Price: " + product.price + " USD";

            // Set the supplier information in the modal
            document.getElementById('modalSupplierName').textContent = "Supplier Name: " + product.name;
            document.getElementById('modalSupplierEmail').textContent = "Email: " + product.email;
            document.getElementById('modalSupplierContact').textContent = "Contact: " + product.contact_details;

            // Show the modal
            document.getElementById('productModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }
    </script>

</body>

</html>