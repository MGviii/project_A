<?php
// Include database connection
include '../db.php'; // Replace with your actual connection script

// Check if product ID is passed
if (!isset($_GET['id'])) {
    header('Location: products.php');
    exit();
}

$product_id = $_GET['id'];

// Fetch product data from the database
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: products.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price']; // Get the price from the form

    // Handle file upload
    $filePath = $product['filePath']; // Default to existing image
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        // Set the target directory for uploads
        $targetDir = "../uploads/"; // Ensure this directory is writable
        $fileName = basename($_FILES["file"]["name"]);
        $filePath = $targetDir . uniqid() . "-" . $fileName; // Unique file name to avoid collisions

        // Move uploaded file to the target directory
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
            $error = "Failed to upload image.";
        }
    }

    // Update the product in the database
    $update_query = "UPDATE products SET name = ?, description = ?, price = ?, filePath = ?, updated_at = NOW() WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $name, $description, $price, $filePath, $product_id);

    if ($update_stmt->execute()) {
        header('Location: products.php?update=success');
        exit();
    } else {
        $error = "Failed to update product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Product - Dashboard Admin Template</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700" />
    <link rel="stylesheet" href="css/fontawesome.min.css" />
    <link rel="stylesheet" href="jquery-ui-datepicker/jquery-ui.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/templatemo-style.css">
</head>

<body>
    <nav class="navbar navbar-expand-xl">
        <div class="container h-100">
            <a class="navbar-brand" href="products.php">
                <h1 class="tm-site-title mb-0">Product Admin</h1>
            </a>
            <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars tm-nav-icon"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto h-100">
                    <li class="nav-item"><a class="nav-link active" href="products.php"><i class="fas fa-shopping-cart"></i> Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php"><i class="far fa-user"></i> Accounts</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link d-block" href="../logout.php"><?= htmlspecialchars($_SESSION['supplier_name']); ?>, <b>Logout</b></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container tm-mt-big tm-mb-big">
        <div class="row">
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="tm-block-title d-inline-block">Edit Product</h2>
                        </div>
                    </div>
                    <div class="row tm-edit-product-row">
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <form action="" method="post" enctype="multipart/form-data" class="tm-edit-product-form">
                                <div class="form-group mb-3">
                                    <label for="name">Product Name</label>
                                    <input id="name" name="name" type="text" value="<?php echo htmlspecialchars($product['name']); ?>" class="form-control validate" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control validate tm-small" rows="5" required maxlength="150"><?php echo htmlspecialchars($product['description']); ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="price">Price</label>
                                    <input id="price" name="price" type="text" value="<?php echo htmlspecialchars($product['price']); ?>" class="form-control validate" required />
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                                    <div class="tm-product-img-edit mx-auto">
                                        <img id="productImage" src="<?php echo htmlspecialchars($product['filePath']); ?>" alt="Product image" class="img-fluid d-block mx-auto" onerror="this.onerror=null; this.src='../uploads/default.png';">
                                        <i class="fas fa-cloud-upload-alt tm-upload-icon" onclick="document.getElementById('fileInput').click();"></i>
                                    </div>
                                    <div class="custom-file mt-3 mb-3">
                                        <input id="fileInput" type="file" name="file" style="display:none;" onchange="previewImage(event)" />
                                        <input type="button" class="btn btn-primary btn-block mx-auto" value="CHANGE IMAGE NOW" onclick="document.getElementById('fileInput').click();" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block text-uppercase">Update Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="tm-footer row tm-mt-small">
        <div class="col-12 font-weight-light">
            <p class="text-center text-white mb-0 px-4 small">
                Copyright &copy; <b>2018</b> All rights reserved.
                Design: <a rel="nofollow noopener" href="https://templatemo.com" class="tm-footer-link">Template Mo</a>
            </p>
        </div>
    </footer>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="jquery-ui-datepicker/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader(); // Create a FileReader object
            const file = event.target.files[0]; // Get the file from the input

            // Check if a file is selected
            if (file) {
                reader.onload = function() {
                    // Update the existing image with the new file
                    const img = document.getElementById('productImage');
                    img.src = reader.result; // Set the src to the new image
                };
                reader.readAsDataURL(file); // Read the file as a Data URL
            }
        }
    </script>
</body>
</html>
