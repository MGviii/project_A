
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Suppliers</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #28a745, #4CAF50);
            color: white;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
            padding: 15px 0;
            transition: background-color 0.3s ease;
            background-color: transparent;
        }

        .scroll-active {
            background-color: rgba(0, 0, 0, 0.85);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height: 4px;
        }

        .logo h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }

        .nav-links {
            display: flex;
            list-style: none;
            margin: 0;
        }

        .nav-links li {
            margin-left: 30px;
            position: relative;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background-color: #4CAF50;
            transition: all 0.3s ease;
        }

        .nav-links a:hover::before {
            width: 100%;
        }

        .nav-links a:hover {
            color: #4CAF50;
        }

        .suppliers-section {
            padding: 100px 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1);
            margin-top: 60px;
            position: relative;
        }

        .supplier-action {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* Button Styles */
        .supplier-action .btn {
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            animation: shine 25s infinite alternate; /* Animation added here */
        }

        /* Animation Keyframes */
        @keyframes shine {
            0% {
                background-color: yellowgreen; /* Original color */
            }
            20% {
                background-color: olivedrab; /* Light green */
                color: black;
            }
            40% {
                background-color: #b8e0a5; /* Pale green */
                color: black;
            }
            60% {
                background-color: #4CAF50; /* Standard green */
            }
            80% {
                background-color: #a5d99f; /* Another shade of green */
                color: black;
            }
            100% {
                background-color: orangered; /* Original color */
            }
        }

        .supplier-action .btn:hover {
            background-color: #218838;
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .suppliers-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #fff;
        }

        .supplier-card {
            background-color: #fff;
            color: #000;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            transition: transform 0.3s ease;
            display: inline-block;
            width: 250px;
        }

        .supplier-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .supplier-card h3 {
            margin: 10px 0;
            font-size: 1.5rem;
            color: #28a745;
        }

        .supplier-card p {
            font-size: 1rem;
        }

        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            background-color: #fff;
            color: #28a745;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #e9e9e9;
        }

        .pagination span {
            padding: 10px 15px;
            margin: 0 5px;
            color: #28a745;
        }

        .view-products-btn {
            padding: 12px 20px; /* Adjust padding as needed */
            background-color: #28a745; /* Use the same background color as the other buttons */
            color: white; /* Text color */
            border-radius: 25px; /* Same border radius */
            text-decoration: none; /* No underline */
            display: inline-block; /* Align it like a button */
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; /* Add transitions */
        }

        .view-products-btn:hover {
            background-color: #218838; /* Darker green on hover */
            transform: scale(1.05); /* Scale up effect */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }
    </style>
</head>

<body>
    <div class="homepage-content">
        <!-- Navigation Bar -->
        <header id="header">
            <nav>
                <div class="logo">
                    <h1>FertiConnect</h1>
                </div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="supplier.php">Suppliers</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </header>

        <!-- Suppliers Section -->
        <section class="suppliers-section">
            <h2>Our Suppliers</h2>

            <!-- Action Button for Register/Login -->
            <div class="supplier-action">
                <a href="login.php" class="btn">Register or Login as Supplier</a>
            </div>

            <?php
            // Include the database connection file
            include 'db.php';

            // Pagination setup
            $suppliersPerPage = 10;
            $totalSuppliersQuery = "SELECT COUNT(*) AS total FROM suppliers"; 
            $totalSuppliersResult = $conn->query($totalSuppliersQuery);
            $totalSuppliersRow = $totalSuppliersResult->fetch_assoc();
            $totalSuppliers = $totalSuppliersRow['total'];

            $totalPages = ceil($totalSuppliers / $suppliersPerPage);
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            // Validate current page
            if ($currentPage < 1) {
                $currentPage = 1;
            } elseif ($currentPage > $totalPages) {
                $currentPage = $totalPages;
            }

            // Calculate the starting index for suppliers on the current page
            $startIndex = ($currentPage - 1) * $suppliersPerPage;

            // Query suppliers for the current page
            $suppliersQuery = "SELECT id,name, description FROM suppliers LIMIT $startIndex, $suppliersPerPage";
            $suppliersResult = $conn->query($suppliersQuery);

            // Display supplier cards for the current page
            if ($suppliersResult->num_rows > 0) {
                while ($row = $suppliersResult->fetch_assoc()) {
                    
                    echo '<div class="supplier-card">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<a href="view_details.php?supplier_id=' . $row['id'] . '" class="view-products-btn btn">View Our Products</a>';


                    
                    echo '</div>';
                }
            } else {
                echo '<p>No suppliers found.</p>';
            }

            // Pagination Links
            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i === $currentPage) {
                    echo '<span>' . $i . '</span>';
                } else {
                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
                }
            }
            echo '</div>';

            // Close the database connection
            $conn->close();
            ?>
        </section>
    </div>

    <script>
        // Change header style on scroll
        window.addEventListener('scroll', function () {
            const header = document.getElementById('header');
            header.classList.toggle('scroll-active', window.scrollY > 0);
        });
    </script>
</body>

</html>
