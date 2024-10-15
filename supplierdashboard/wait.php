<?php
session_start();
include("../db.php");
include 'pay.php';

// if (!isset($_SESSION['supplier_id'])) {
//     header("Location: login.php");
//     exit();
// }

// // Get form input
// $supplier_id = $_SESSION['supplier_id'];
// $phone_number = $_POST['phone_number'];
// $amount = $_POST['amount'];
// // generate random payment
// $transaction_ref = rand(100000,999999);
// // prefix farm-connect
// $transaction_ref = 'farm-connect-'.$transaction_ref;

// $payment = hdev_payment::pay($phone_number,$amount,$transaction_ref,'');
// if(!is_null($payment) && $payment->status == 'success')
// {
//     // alert message 
//     echo "<script>alert(".$payment->message.");</script>";
//     // Payment was successful, redirect to add-product.php
//     // header("Location: add-product.php?msg=Payment successful! You can now add your product.");
//     // header("Location: wait.php?tx_ref=".$transaction_ref);
//     // js redirect
//     echo "<script>window.location.href='wait.php?tx_ref=".$transaction_ref."';</script>";
// }else{
//     // Payment failed, show an error message
//     header("Location: products.php?msg=Payment failed! Please try again.");
// }
// // You would typically integrate with a payment gateway API here
// // Mock payment process (you can replace it with actual payment API logic)
// $payment_success = true; // Mock success, replace with actual payment result

// // Prepare SQL to insert transaction
// $status = $payment_success ? 'success' : 'failed';
// $sql = "INSERT INTO transactions (supplier_id, phone_number, amount, status) VALUES (?, ?, ?, ?)";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("isds", $supplier_id, $phone_number, $amount, $status);
// $stmt->execute();

// // Check if payment was successful and redirect accordingly
// if ($payment_success) {
//     // Payment was successful, redirect to add-product.php
//     header("Location: add-product.php?msg=Payment successful! You can now add your product.");
// } else {
//     // Payment failed, show an error message
//     header("Location: products.php?msg=Payment failed! Please try again.");
// }
// exit();

// Get transaction reference from URL
if($_GET){
    if(isset($_GET['tx_ref'])){
        $tx_ref = $_GET['tx_ref'];
        // Check if transaction exists in the database
        $sql = "SELECT * FROM transactions WHERE tx_ref = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $tx_ref);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            // get transaction details
            $transaction = $result->fetch_assoc();
            // Check if transaction was successful
            if($transaction['status'] == 'pending'){
                $get_pay = hdev_payment::get_pay($tx_ref);
                if(!is_null($get_pay) && $get_pay->status == 'success'){
                    $sql = "UPDATE transactions SET status = 'success' WHERE tx_ref = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $tx_ref);
                    $stmt->execute();
                    header("Location: add-product.php?msg=Payment successful! You can now add your product.");
                }elseif(!is_null($get_pay) && ($get_pay->status == 'failed' || $get_pay->status == 'rejected')){
                    // update db 
                    $sql = "UPDATE transactions SET status = 'failed' WHERE tx_ref = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $tx_ref);
                    $stmt->execute();
                    header("Location: products.php?msg=Payment failed! Please try again.");
                }else{
                    //get status again from db 
                    $sql = "SELECT * FROM transactions WHERE tx_ref = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $tx_ref);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows > 0){
                        // get transaction details
                        $transaction = $result->fetch_assoc();
                        // Check if transaction was successful
                        if($transaction['status'] == 'pending'){
                            // Payment is still pending, show a message
                            // message is still pending message 
                            echo "<h1>Payment is still pending. Please wait...</h1>";
                            // js redirect in 5 seconds with message on screen 
                            echo "<script>setTimeout(function(){window.location.href='wait.php?tx_ref=".$tx_ref."';},5000);</script>";
                        }else{
                            // Transaction status is unknown, show an error message
                            header("Location: products.php?msg=Payment status unknown. Please try again.");
                        }
                    }
                }
            }else{
                if ($transaction['status'] == 'success') {
                    // Payment was successful, redirect to add-product.php
                    header("Location: add-product.php?msg=Payment successful! You can now add your product.");
                } else {
                    // Payment failed, show an error message
                    header("Location: products.php?msg=Payment failed! Please try again.");
                }
            }
        }else{
            // Transaction does not exist, redirect to products.php
            header("Location: products.php?msg=Payment failed! Please try again.");
        }
    }
}
?>
