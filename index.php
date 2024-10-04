<?php
include 'db.php'; // Include the database connection

// Query to fetch product name and filePath
$sql = "SELECT id, name, filePath FROM products";
$result = $conn->query($sql);
?>



<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linking Farmers with Fertilizer Suppliers</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #28a745, #4CAF50);
            color: white;
        }

        /* Transparent Navbar Styles */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
            padding: 15px 0;
            transition: background-color 0.3s ease;
            background-color: transparent; /* No background initially */
        }

        /* Background color on scroll */
        .scroll-active {
            background-color: rgba(0, 0, 0, 0.85); /* Set the background color when scrolling */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height:4px;
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

        /* Hover effect */
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

        /* Mobile Menu Toggle Button */
        .navbar-toggler {
            display: none;
        }

        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                background-color: rgba(0, 0, 0, 0.95);
                top: 0;
                right: 0;
                width: 70%;
                height: 100vh;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                display: none;
                transition: all 0.3s ease;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links li {
                margin: 20px 0;
            }

            .navbar-toggler {
                display: block;
                background-color: white;
                color: #28a745;
                border: none;
                cursor: pointer;
                font-size: 1.8rem;
                padding: 10px;
                margin-left: auto;
            }

            .nav-links a {
                font-size: 1.5rem;
            }
        }

        /* Smooth Scroll for anchors */
        html {
            scroll-behavior: smooth;
        }

        /* Carousel Styles */
        .carousel-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            margin-top: 0;
        }

        .carousel {
            display: flex;
            transition: transform 0.8s ease-in-out;
        }

        .carousel img {
            width: 100%;
            height: 600px;
            object-fit: cover;
            min-width: 100%;
        }

        /* Carousel Content */
        .carousel-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .carousel-content h2 {
            font-size: 3rem;
            margin: 0;
            font-weight: 700;
        }

        .carousel-content p {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .carousel-content .btn {
            padding: 12px 30px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .carousel-content .btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Product Section Styles */
        .products-section {
    padding: 50px 20px;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.1);
}

.products-section h2 {
    font-size: 2.5rem;
    margin-bottom: 30px;
    color: #fff;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.product-item {
    background-color: #fff;
    color: #000;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    height: 300px; /* Set a fixed height for all product items */
    display: flex;
    flex-direction: column; /* Align content vertically */
    justify-content: space-between; /* Space between image and title/button */
}

.product-item img {
    width: 100%;
    height: 150px; /* Set a consistent height */
    object-fit: cover; /* Ensures the image covers the area without stretching */
    border-radius: 8px;
    margin-bottom: 10px; /* Space between image and title */
}

.product-item h3 {
    margin: 15px 0 10px;
    font-size: 1.3rem;
    color: #28a745;
}

/* Hover effect */
.product-item:hover {
    transform: scale(1.05); /* Slightly enlarge on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Enhance shadow on hover */
}

/* Button Styles */
.btn {
    padding: 12px 30px;
    background-color: #28a745; /* Green background */
    color: white; /* White text */
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease, transform 0.3s ease;
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Align properly */
}

.btn:hover {
    background-color: #218838; /* Darker green on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}

        /* Navigation Buttons */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .btn {
    padding: 12px 30px;
    background-color: #28a745; /* Green background */
    color: white; /* White text */
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease, transform 0.3s ease;
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Align properly */
}

.btn:hover {
    background-color: #218838; /* Darker green on hover */
    transform: scale(1.05); /* Slightly enlarge on hover */
}


/* General Styles */
footer {
    font-family: 'Roboto', sans-serif;
    line-height: 1.6;
    color: #f1f1f1;
    background-color: #1a1a1a;
    padding: 60px 0;
}

footer a.footer-link {
    color: #f1f1f1;
    text-decoration: none;
    font-size: 16px;
    padding: 5px 10px; /* Add some padding for better clickable area */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s ease, color 0.3s ease;
}

footer a.footer-link:hover {
    color: #1a1a1a; /* Change text color */
    background-color: #ffc107; /* Change background color */
    text-decoration: none; /* Remove underline */
}

/* Section Text Alignment */
footer .footer-section {
    text-align: left;
}

/* Center alignment for sections that need it */
footer .footer-section.text-center {
    text-align: center;
}

/* Newsletter Input */
footer .input-group .form-control {
    background-color: #333;
    color: white;
    border-radius: 5px 0 0 5px;
    border: none;
    padding: 10px;
    transition: background-color 0.3s ease;
}

footer .input-group .form-control::placeholder {
    color: #ccc; /* Placeholder text color */
}

footer .input-group .form-control:focus {
    background-color: #444;
    outline: none;
}

footer .input-group button {
    background-color: #ffc107;
    border: none;
    color: #333;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

footer .input-group button:hover {
    background-color: #e0a800;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-flex {
        flex-direction: column;
    }

    .footer-section {
        margin-bottom: 30px;
    }
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
                <button class="navbar-toggler" onclick="toggleMenu()">☰</button>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="supplier.php">Supplier</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </header>

        <!-- Carousel Section -->
        <section id="home" class="carousel-container">
            <div class="carousel" id="carousel">
                <img src="fertilizer-bg.jpg" alt="Fertilizer Image 1">
                <img src="fertilizer-bg.jpg" alt="Fertilizer Image 2">
                <img src="fertilizer-bg.jpg" alt="Fertilizer Image 3">
            </div>

            <div class="carousel-content">
                <h2>Connecting Farmers with Fertilizer Suppliers</h2>
                <p>Find the best fertilizers for your crops and connect with suppliers near you.</p>
                
            </div>
        </section>

        <!-- Our Products Section -->
<section class="products-section">
    <h2>The Fertilizers</h2>
    <div class="products-grid">
    <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row["name"];
        $productImagePath = $row["filePath"];

        // Check if the filePath already contains 'uploads/'
        if (strpos($productImagePath, 'uploads/') === false) {
            $productImagePath = 'uploads/' . $productImagePath;
        }

        // Debugging output to check the image path
        // echo '<p>Image Path: ' . htmlspecialchars($productImagePath) . '</p>';

        // Display product and image
        echo '<div class="product-item">';
        echo '<img src="' . htmlspecialchars($productImagePath) . '" alt="Product Image" width="300" height="300">';
        echo '<h3>' . htmlspecialchars($productName) . '</h3>';
        echo '<a href="product-details.php?id=' . htmlspecialchars($row["id"]) . '" class="btn">View More</a>';
        echo '</div>';
    }
} else {
    echo "<p>No products found.</p>";
}
?>

    </div>
</section>


<footer style="background-color: #1a1a1a; padding: 60px 0; color: #f1f1f1; font-family: Arial, sans-serif;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div class="footer-flex" style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 40px;">

            <!-- About Section (FertiConnect) -->
            <div class="footer-section" style="flex: 1 1 300px; text-align: left;">
                <h5 style="color: #ffc107; font-size: 20px; font-weight: bold;">FertiConnect</h5>
                <p style="line-height: 1.8;">FertiConnect is your go-to platform for connecting farmers and fertilizer suppliers. Our mission is to empower farmers by providing easy access to high-quality fertilizers from trusted suppliers.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section" style="flex: 1 1 150px; text-align: left;">
                <h5 style="color: #ffc107; font-size: 20px; font-weight: bold;">Quick Links</h5>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" class="footer-link">Home</a></li>
                    <li><a href="#" class="footer-link">Products</a></li>
                    <li><a href="#" class="footer-link">Suppliers</a></li>
                    <li><a href="#" class="footer-link">Blog</a></li>
                    <li><a href="#" class="footer-link">Contact Us</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="footer-section" style="flex: 1 1 150px; text-align: left;">
                <h5 style="color: #ffc107; font-size: 20px; font-weight: bold;">Categories</h5>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" class="footer-link">Organic Fertilizers</a></li>
                    <li><a href="#" class="footer-link">Nitrogen Fertilizers</a></li>
                    <li><a href="#" class="footer-link">Phosphate Fertilizers</a></li>
                    <li><a href="#" class="footer-link">Potash Fertilizers</a></li>
                    <li><a href="#" class="footer-link">Custom Mix</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="footer-section" style="flex: 1 1 300px; text-align: center;">
                <h5 style="color: #ffc107; font-size: 20px; font-weight: bold;">Subscribe to Our Newsletter</h5>
                <form class="input-group" style="display: flex; justify-content: center; gap: 0;">
                    <input type="email" class="form-control" placeholder="Enter your email" style="flex: 1; max-width: 250px; padding: 10px; border: none; border-radius: 5px 0 0 5px; outline: none;">
                    <button type="submit" style="background-color: #ffc107; border: none; color: #1a1a1a; padding: 10px 20px; border-radius: 0 5px 5px 0; cursor: pointer;" >Subscribe</button>
                </form>
                <p style="margin-top: 10px; color: #ccc;">Stay updated with the latest offers and farming tips.</p>
            </div>
        </div>

        <hr style="border-top: 1px solid #555; margin: 40px 0;">

        <!-- Social Links & Footer Bottom -->
        <div class="footer-flex" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 40px;">
            <!-- Social Links -->
            <p style="color: #ccc;">&copy; 2024 FertiConnect. All rights reserved.</p>

            <!-- Footer Navigation -->
            <div class="footer-section" style="flex: 1 1 200px; text-align: center;">
                <ul class="list-inline" style="margin: 0; padding: 0;">
                    <li class="list-inline-item"><a href="#" class="footer-link">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#" class="footer-link">Terms & Conditions</a></li>
                    <li class="list-inline-item"><a href="#" class="footer-link">FAQs</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>






        <!-- Script for Navbar and Carousel -->
        <script>
            const nav = document.querySelector('header');
            const links = document.querySelector('.nav-links');
            const carousel = document.getElementById('carousel');
            let carouselIndex = 0;

            // Sticky Navbar Effect
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    nav.classList.add('scroll-active');
                } else {
                    nav.classList.remove('scroll-active');
                }
            });

            // Mobile Menu Toggle
            function toggleMenu() {
                links.classList.toggle('active');
            }

            // Carousel Functionality
            function nextSlide() {
                carouselIndex = (carouselIndex + 1) % carousel.children.length;
                carousel.style.transform = `translateX(-${carouselIndex * 100}%)`;
            }

            function prevSlide() {
                carouselIndex = (carouselIndex - 1 + carousel.children.length) % carousel.children.length;
                carousel.style.transform = `translateX(-${carouselIndex * 100}%)`;
            }

            // Auto-slide every 5 seconds
            setInterval(nextSlide, 5000);
        </script>
    </div>
</body>

</html>
<?php
$conn->close();
?>