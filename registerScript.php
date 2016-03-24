<?php
require_once 'model/db.php';
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // $username = htmlspecialchars($username, ENT_QUOTES);

  if(isset($username) && isset($email) && isset($password)){

    if(!filter_var($username, FILTER_SANITIZE_STRING) === false){
      if(!filter_var($email, FILTER_SANITIZE_EMAIL) === false){
        if(!filter_var($password, FILTER_SANITIZE_STRING) === false){
          if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){

            $check_username = $conn->prepare("SELECT username FROM user WHERE username = ?");
            $check_username->bindParam(1,$username, PDO::PARAM_STR);
            $check_username->fetch();
            $check_username->execute();
            $check_username->closeCursor();

            if($check_username->rowCount()==1){
                $_SESSION['status'] = 'Username is already in use';
                header('location: register.php');
            }else{
                $check_email = $conn->prepare("SELECT email FROM user WHERE email = ?");
                $check_email->bindParam(1,$email, PDO::PARAM_STR);
                $check_email->fetch();
                $check_email->execute();
                $check_email->closeCursor();

                if($check_email->rowCount()==1){
                    $_SESSION['status'] = 'Email is already in use';
                    header('location: register.php');
                }else{
                  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                  $register = $conn->prepare("INSERT INTO user(username,email,password) VALUES(?,?,?)");
                  $register->bindParam(1,$username, PDO::PARAM_STR);
                  $register->bindParam(2,$email, PDO::PARAM_STR);
                  $register->bindParam(3,$hashed_password, PDO::PARAM_STR);
                  $register->execute();
                  $register->closeCursor();

                  $_SESSION['status'] = 'Registered';
                  header('location: register.php');
                }
            }

        }else{
          $_SESSION['status'] = 'Email is not valid';
          header('location: register.php');
        }
      }else{
        $_SESSION['status'] = 'Invalid username';
        header('location: register.php');
      }
    }else{
      $_SESSION['status'] = 'Invalid email';
      header('location: register.php');
    }
  }else{
    $_SESSION['status'] = 'Invalid password';
    header('location: register.php');
  }

}
  $_SESSION['status'] = 'Only numbers and letters allowed';
  header('location: register.php');
}
?>
