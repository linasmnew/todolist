<?php

//get data from the database and return it
function getTasksBySearch($user_id, $keyword, $conn){
  $search = '[[:<:]]'.$keyword.'[[:>:]]';
  $find_tasks_by_search = $conn->prepare("SELECT * FROM tasks WHERE title regexp ? AND user_id = ? ORDER BY date_due, time_due");
  $find_tasks_by_search->bindParam(1,$search, PDO::PARAM_STR);
  $find_tasks_by_search->bindParam(2,$user_id, PDO::PARAM_STR);
  $find_tasks_by_search->execute();
  $result = $find_tasks_by_search->fetchAll();

  if($find_tasks_by_search->rowCount()>0){
    return $result;
  }else{
    return 'not fouund';
  }

}

?>
