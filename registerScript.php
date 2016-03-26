<?php
require_once 'model/db.php';
session_start();

if(isset($_POST['register'])){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(!empty($username) && !empty($email) && !empty($password)){

    //encode special characters
    $username = filter_var($username, FILTER_SANITIZE_ENCODED);
    $password = filter_var($password, FILTER_SANITIZE_ENCODED);

    if(strlen($username) > 4 && !filter_var($username, FILTER_SANITIZE_STRING) === false){
      if(!filter_var($email, FILTER_SANITIZE_EMAIL) === false){
        if(strlen($password) > 4 && !filter_var($password, FILTER_SANITIZE_STRING) === false){
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
        $_SESSION['status'] = 'Invalid password, make sure it does not contain symbols and is at least 5 characters';
        header('location: register.php');
      }
    }else{
      $_SESSION['status'] = 'Invalid email';
      header('location: register.php');
    }
  }else{
    $_SESSION['status'] = 'Invalid username, make sure it does not contain symbols and is at least 5 characters';
    header('location: register.php');
  }

}else{
  $_SESSION['status'] = 'Please fill in all fields';
  header('location: register.php');
}
}
?>
