<?php
require_once '../model/db.php';
session_start();

require('categoryFunctions.php');

  if(isset($_POST['categoryId'])){

    $category_id = $_POST['categoryId'];

    $arr = array("data"=>"Category removed");

    deleteCategory($_SESSION['user_id'], $category_id, $conn);

    header('Content-Type: application/json');
     echo json_encode($arr);
  }else{

    }

?>
