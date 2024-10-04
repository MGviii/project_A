
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fertilizer Connect</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <header>
        <!-- Bootstrap Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-success">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <h1 class="text-white m-0">Fertilizer Connect</h1>
                </a>
                <!-- Navbar Toggler visible on medium screens and below -->
                <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Sign up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="mt-4">
        <section id="about" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-4">About Us</h2>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <p>We are a team committed to improving agriculture by bridging the gap between farmers and fertilizer traders. Our mission is to create a transparent and accessible platform that makes it easier for farmers to find the best fertilizer for their crops.</p>
                        <p>With our technology-driven approach, we aim to foster sustainable agricultural practices and increase productivity for farmers worldwide.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="platform" class="py-5">
            <div class="container">
                <h2 class="text-center mb-4">How Our Platform Works</h2>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <p>Our platform helps farmers connect with reliable fertilizer traders to get the right fertilizers for their crops. Farmers can browse through a variety of fertilizers without needing to register or Login. To see detailed descriptions and supplier contact information. Traders can list, update, and delete their fertilizers after completing a one-time registration and payment process for Uploading.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Fertilizer Connect. All Rights Reserved.</p>
            <p>Contact us: info@fertilizerconnect.com</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
