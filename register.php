<?php
require('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $contact_details = htmlspecialchars(trim($_POST['contact_details']));
    $address = htmlspecialchars(trim($_POST['address']));
    $description = htmlspecialchars(trim($_POST['description']));

    // Validate required fields
    if (empty($name) || empty($email) || empty($password) || empty($contact_details) || empty($description)) {
        die("All fields are required.");
    }

    // Check for existing email
    $sql = "SELECT * FROM suppliers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Email already registered in suppliers.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $logo_path = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["file"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $allowed_types)) {
            if ($_FILES["file"]["size"] > 2000000) {
                die("Sorry, your file is too large. Maximum size is 2MB.");
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $logo_path = $target_file;
            } else {
                die("Error uploading file.");
            }
        } else {
            die("Only JPG, JPEG, PNG, & GIF files are allowed.");
        }
    }

    // Insert into database
    $sql = "INSERT INTO suppliers (name, email, password, contact_details, address, logo, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $hashed_password, $contact_details, $address, $logo_path, $description);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        die("Error during insertion");
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #28a745;
            color: #fff;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 20px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #ffc107;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .form-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .form-header h2 {
            font-size: 24px;
            color: #343a40;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #218838;
        }

        /* Input focus effects */
        input:focus, textarea:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }

        .form-control {
            border-radius: 8px;
        }
        .form-footer {
            margin-top: 1rem;
            text-align: center;
        }

        .form-footer a {
            color: #28a745;
            text-decoration: none;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: auto;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<header>
        <nav>
            <div class="logo">
                <h1>FertiConnect</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="supplier.php">Suppliers</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <div class="form-header">
                        <h2 style="color: #218838;">Supplier Registration</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password (min 6 characters)" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_details" class="form-label">Contact Details</label>
                            <input type="text" class="form-control" id="contact_details" name="contact_details" placeholder="Enter your contact details" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter a brief description" maxlength="50"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom btn-lg">Register</button>
                        </div>
                    </form>

                    <div class="form-footer">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer>
        <p>&copy; 2024 FertiConnect. All rights reserved.</p>
    </footer>
</html>
