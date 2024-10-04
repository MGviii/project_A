<?php
session_start();
require('db.php');
if($_SERVER['REQUEST_METHOD']=="POST"){
    $email=htmlspecialchars(trim($_POST['email']));
    $new_password=htmlspecialchars(trim($_POST['password']));
    $confirm_password=htmlspecialchars(trim($_POST['confirm']));
    if(empty($email) || empty($new_password) || empty($confirm_password)){
        die("all fields are required");
    }
    if($new_password==$confirm_password){
      $password=$confirm_password;
    }else{
      echo" Invalid Password";
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM suppliers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (($result->num_rows > 0) && ($new_password==$confirm_password)) {
      
    $sql="update suppliers set password=? where email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password,$email);
    $stmt->execute();
    if($stmt->execute()){
      echo"<html><heade></head><body>";
      echo"<p>"."Password resetted successfully"."</p>";
      echo"<a href='login.php'>"."Login"."</a>";
      echo"</body></html>";
      
    }else{
      echo"<html><head></head><body>";
      echo"<p>"."Password resetted failed"."</p>";
      echo"<a href='forget.php'>"."retry again"."</a>";
      echo"</body></html>";
    }}


}
?>
