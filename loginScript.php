<?php
require_once 'model/db.php';

session_start();

if(isset($_POST['login'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

  if(!empty($username) && !empty($password)){

    //encode special characters
    $username = filter_var($username, FILTER_SANITIZE_ENCODED);
    $password = filter_var($password, FILTER_SANITIZE_ENCODED);

    if(strlen($username) > 4 && !filter_var($username, FILTER_SANITIZE_STRING) === false){
      if(strlen($username) > 4 && !filter_var($password, FILTER_SANITIZE_STRING) === false){

          $check_username = $conn->prepare("SELECT id, password FROM user WHERE username = ?");
          $check_username->bindParam(1,$username, PDO::PARAM_STR);
          $check_username->execute();
          $result = $check_username->fetch(PDO::FETCH_ASSOC);

          if($check_username->rowCount()==1){
            if(password_verify($password,$result['password'])){
              //password matches
              $_SESSION['user_id'] = $result['id'];
              header('location: user/index.php');
            }else{
              $_SESSION['status'] = 'Invalid username or password';
              header('location: login.php');
            }
          }else{
            $_SESSION['status'] = 'Invalid username or password';
            header('location: login.php');
          }

      }else{
        $_SESSION['status'] = 'Invalid password, make sure it does not contain symbols and is at least 5 characters';
        header('location: login.php');
      }
    }else{
      $_SESSION['status'] = 'Invalid username, make sure it does not contain symbols and is at least 5 characters';
      header('location: login.php');
    }

  }else{
    $_SESSION['status'] = 'Please enter your login details';
    header('location: login.php');
  }
}
?>
