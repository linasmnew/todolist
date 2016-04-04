<?php
require_once '../model/db.php';
session_start();

require('taskFunctions.php');

  if(isset($_POST['removeUrl'])){

    $url = $_POST['removeUrl'];

    $arr = array("data"=>"Task/tasks removed");

    completelyDeleteTask($_SESSION['user_id'], $url, $conn);

    header('Content-Type: application/json');
     echo json_encode($arr);
  }else{

    }

?>
