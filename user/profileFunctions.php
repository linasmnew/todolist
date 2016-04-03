<?php

function getUserDetails($user_id, $conn){
  $getUserDetails = $conn->prepare("SELECT email, password FROM user WHERE id = ?");
  $getUserDetails->bindParam(1,$user_id, PDO::PARAM_STR);
  $getUserDetails->execute();
  $results = $getUserDetails->fetch(PDO::FETCH_ASSOC);

  return $results;
}

?>
