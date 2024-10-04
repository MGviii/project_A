<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Add Product - Dashboard HTML Template</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700" />
    <link rel="stylesheet" href="css/fontawesome.min.css" />
    <link rel="stylesheet" href="jquery-ui-datepicker/jquery-ui.min.css" type="text/css" />
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
                    <li class="nav-item">
                        <a class="nav-link active" href="products.php">
                            <i class="fas fa-shopping-cart"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">
                            <i class="far fa-user"></i> Accounts
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link d-block" href="../logout.php">
                        <?= htmlspecialchars($_SESSION['supplier_name']); ?>, <b>Logout</b>
                        </a>
                    </li>
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
                            <h2 class="tm-block-title d-inline-block">Add Product</h2>
                        </div>
                    </div>
                    <div class="row tm-edit-product-row">
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <?php
                            // Include database connection
                            include('../db.php');
                            session_start();

                            // Assume the supplier ID is stored in a session variable when the supplier logs in
                            $supplier_id = $_SESSION['supplier_id']; // Make sure to set this during login

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                // Collect form data
                                $name = $_POST['name'];
                                $description = $_POST['description'];
                                $price = $_POST['price'];
                                $filePath = $_FILES['filePath']['name'];
                                $target_dir = "uploads/"; // Ensure this directory exists and is writable
                                $target_file = $target_dir . basename($filePath);

                                // Move uploaded file to target directory
                                if (move_uploaded_file($_FILES['filePath']['tmp_name'], $target_file)) {
                                    // Prepare SQL query to include supplier_id
                                    $sql = "INSERT INTO products (supplier_id, name, description, price, filePath) VALUES (?, ?, ?, ?, ?)";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("issss", $supplier_id, $name, $description, $price, $target_file);
                                    
                                    // Execute the statement
                                    if ($stmt->execute()) {
                                        echo "<div class='alert alert-success'>Product added successfully!</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                                    }
                                    $stmt->close();
                                } else {
                                    echo "<div class='alert alert-danger'>Error uploading file.</div>";
                                }
                            }
                            ?>
                            <form action="" method="POST" enctype="multipart/form-data" class="tm-edit-product-form">
                                <div class="form-group mb-3">
                                    <label for="name">Product Name</label>
                                    <input id="name" name="name" type="text" class="form-control validate" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control validate" rows="3" required maxlength="150"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="price">Price</label>
                                    <input id="price" name="price" type="number" step="0.01" class="form-control validate" required />
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
                                    <div class="tm-product-img-dummy mx-auto">
                                        <i class="fas fa-cloud-upload-alt tm-upload-icon" onclick="document.getElementById('fileInput').click();"></i>
                                    </div>
                                    <div class="custom-file mt-3 mb-3">
                                        <input id="fileInput" name="filePath" type="file" style="display:none;" required onchange="previewImage(event)" />
                                        <input type="button" class="btn btn-primary btn-block mx-auto" value="UPLOAD PRODUCT IMAGE" onclick="document.getElementById('fileInput').click();" />
                                    </div>
                                    <img id="imagePreview" src="" alt="Image Preview" style="display:none; width: 100%; margin-top: 10px;" />
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block text-uppercase">Add Product Now</button>
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
          const imagePreview = document.getElementById('imagePreview');
          const file = event.target.files[0];
          const reader = new FileReader();

          reader.onload = function(){
              imagePreview.src = reader.result;
              imagePreview.style.display = 'block'; // Show the image preview
          }

          if (file) {
              reader.readAsDataURL(file);
          } else {
              imagePreview.src = "";
              imagePreview.style.display = 'none'; // Hide the image preview if no file is selected
          }
      }
    </script>
</body>
</html>
