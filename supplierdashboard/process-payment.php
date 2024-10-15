<?php
session_start();
include("../db.php");
include 'pay.php';

if (!isset($_SESSION['supplier_id'])) {
    header("Location: login.php");
    exit();
}

// Get form input
$supplier_id = $_SESSION['supplier_id'];
$phone_number = $_POST['phone_number'];
$amount = $_POST['amount'];
// generate random payment
$transaction_ref = rand(100000,999999);
// prefix farm-connect
$transaction_ref = 'farm-connect-'.$transaction_ref;

$payment = hdev_payment::pay($phone_number,$amount,$transaction_ref,'');
if(!is_null($payment) && $payment->status == 'success')
{
    // alert message 
    echo "<script>alert(".$payment->message.");</script>";
    // Payment was successful, redirect to add-product.php
    // header("Location: add-product.php?msg=Payment successful! You can now add your product.");
    // header("Location: wait.php?tx_ref=".$transaction_ref);
    // js redirect
    $payment_success = true;
}else{
    // Payment failed, show an error message
    header("Location: products.php?msg=Payment failed! Please try again.");
}
// You would typically integrate with a payment gateway API here
// Mock payment process (you can replace it with actual payment API logic)
$payment_success = true; // Mock success, replace with actual payment result

// Prepare SQL to insert transaction
$status = $payment_success ? 'pending' : 'failed';
$sql = "INSERT INTO transactions (supplier_id, phone_number, amount, status) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isds", $supplier_id, $phone_number, $amount, $status);
$stmt->execute();

// Check if payment was successful and redirect accordingly
if ($payment_success) {
    // Payment was successful, redirect to add-product.php
    echo "<script>window.location.href='wait.php?tx_ref=".$transaction_ref."';</script>";
} else {
    // Payment failed, show an error message
    header("Location: products.php?msg=Payment failed! Please try again.");
}
exit();
?>
