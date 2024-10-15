<?php
// Database connection (replace with your actual connection parameters)
$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "fertilizer_connect";
$port = 3334;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>