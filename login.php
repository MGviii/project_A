<?php
session_start();
require('db.php');

$error="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get input values
  $email = htmlspecialchars(trim($_POST['email']));
  $password = htmlspecialchars(trim($_POST['password']));

  // Basic validation
  if (empty($email) || empty($password)) {
    $error="All fields are required.";
  }

  // Check if email exists in the selected table
  $sql = "SELECT * FROM suppliers WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
      // Successful login, redirect to appropriate dashboard
      $_SESSION['supplier_name'] = $user['name'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['supplier_id'] = $user['id'];
      $_SESSION['loggedin'] = true;
      header("Location: supplierdashboard/products.php");
      exit();
    } else {
      $error="Incorrect password.";
    }
  } else {
    $error="No user found with the email in the suppliers table.";
  }

  // Close connection
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FertiConnect</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }

        .card-header {
            background-color: #28a745;
            color: #fff;
            padding: 1.5rem;
            text-align: center;
        }

        .card-body {
            padding: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            margin-bottom: 1rem;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #28a745;
            color: #fff;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
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

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .card {
                max-width: 100%;
            }
        }
        .error{
            color:red;
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
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="card">
            <div class="card-header">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <br>
                    <span class="error"><?php echo $error; ?></span>
                    <button type="submit">Login</button>
                    <div class="form-footer">
                        <a href="forget.html">Forgot password?</a>
                        <p>Don't have an account? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 FertiConnect. All rights reserved.</p>
    </footer>
</body>
</html>