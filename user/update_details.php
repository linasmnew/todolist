<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header('location: ../login.php');
}
require_once '../model/db.php';


if(isset($_POST['update_email'])){
  $email = $_POST['email'];

  if(!empty($email)){
    //encode special characters
      if(!filter_var($email, FILTER_SANITIZE_EMAIL) === false){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){

          $update = $conn->prepare("UPDATE user SET email=? WHERE id = ?");
          $update->bindParam(1,$email, PDO::PARAM_STR);
          $update->bindParam(2,$_SESSION['user_id'], PDO::PARAM_STR);
          $update->execute();
          $update->closeCursor();

          $_SESSION['status'] = 'Email updated';
          header('location: profile.php');

        }else{
          $_SESSION['status'] = 'Email is not valid';
          header('location: profile.php');
        }
      }else{
        $_SESSION['status'] = 'Invalid email';
        header('location: profile.php');
      }
  }else{
    $_SESSION['status'] = 'Make sure the fields are not empty';
    header('location: profile.php');
  }
}//end isset



if(isset($_POST['update_password'])){
  $oldPassword = $_POST['oldpassword'];
  $newPassword = $_POST['newpassword'];

  if(!empty($oldPassword) && !empty($newPassword)){
    //encode special characters
    $oldPassword = filter_var($oldPassword, FILTER_SANITIZE_ENCODED);
    $newPassword = filter_var($newPassword, FILTER_SANITIZE_ENCODED);

    if(strlen($oldPassword) > 4 && !filter_var($oldPassword, FILTER_SANITIZE_STRING) === false){
      if(strlen($newPassword) > 4 && !filter_var($newPassword, FILTER_SANITIZE_STRING) === false){


        $check_old_password = $conn->prepare("SELECT password FROM user WHERE id=?");
        $check_old_password->bindParam(1,$_SESSION['user_id'], PDO::PARAM_STR);
        $check_old_password->execute();
        $result = $check_old_password->fetch(PDO::FETCH_ASSOC);
        $check_old_password->closeCursor();

          if($check_old_password->rowCount()==1){
            if(password_verify($oldPassword,$result['password'])){
              $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

              $updatePassword = $conn->prepare("UPDATE user SET password=? WHERE id = ?");
              $updatePassword->bindParam(1,$hashed_password, PDO::PARAM_STR);
              $updatePassword->bindParam(2,$_SESSION['user_id'], PDO::PARAM_STR);
              $updatePassword->execute();
              $updatePassword->closeCursor();

              $_SESSION['status'] = 'Password updated';
              header('location: profile.php');
            }else{
              $_SESSION['status'] = 'Incorrect old password';
              header('location: profile.php');
            }
          }else{
            $_SESSION['status'] = 'Incorrect old password';
            header('location: profile.php');
          }

      }else{
        $_SESSION['status'] = 'Invalid new password';
        header('location: profile.php');
      }
    }else{
      $_SESSION['status'] = 'Invalid old password';
      header('location: profile.php');
    }

  }else{
    $_SESSION['status'] = 'Make sure the fields are not empty';
    header('location: profile.php');
  }

}//end isset
?>
