<?php
require_once '../model/db.php';

session_start();

require('taskFunctions.php');

  if(isset($_POST['markUrl'])){

    $url = $_POST['markUrl'];

    $arr = array("data"=>"Task/tasks marked as read");

    completeAndRemoveTasks($_SESSION['user_id'], $url, $conn);

    header('Content-Type: application/json');
     echo json_encode($arr);
  }else{

    }

?>
