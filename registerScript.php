<?php
require_once 'model/db.php';
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $check_username = $conn->query("SELECT username FROM user WHERE username = '$username'");
  $check_username->fetch();
  $check_username->execute();
  $check_username->closeCursor();

  if($check_username->rowCount()==1){
      $_SESSION['status'] = 'Username is already in use';
      header('location: register.php');
  }else{
      $check_email = $conn->query("SELECT email FROM user WHERE email = '$email'");
      $check_email->fetch();
      $check_email->execute();
      $check_email->closeCursor();

      if($check_email->rowCount()==1){
          $_SESSION['status'] = 'Email is already in use';
          header('location: register.php');
      }else{
        $register = $conn->prepare("INSERT INTO user(username,email,password) VALUES(?,?,?)");
        $register->bindParam(1,$username, PDO::PARAM_STR);
        $register->bindParam(2,$email, PDO::PARAM_STR);
        $register->bindParam(3,$password, PDO::PARAM_STR);
        $register->execute();
        $register->closeCursor();

        $_SESSION['status'] = 'Registered';
        header('location: register.php');
      }
  }
}
?>
