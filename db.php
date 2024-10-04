<?php
// Database connection (replace with your actual connection parameters)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fertilizer_connect";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>