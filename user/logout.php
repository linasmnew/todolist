<?php
require_once '../model/db.php';

session_start();

if(!isset($_SESSION['user_id'])){
  header('location: ../login.php');
}else{
  session_destroy();
  header('location: ../login.php');
}


?>
