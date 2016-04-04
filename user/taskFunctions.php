<?php

function getTasks($user_id, $category,$conn){
  //  date('H:i', $task['time_due']);
  //  date('Y-m-d',$task['time_due']);
  $category = $category;

  $find_category_tasks = $conn->prepare("SELECT * FROM tasks WHERE category = ? AND user_id = ? ORDER BY date_due");
  $find_category_tasks->bindParam(1,$category, PDO::PARAM_STR);
  $find_category_tasks->bindParam(2,$user_id, PDO::PARAM_STR);
  $find_category_tasks->execute();
  $result = $find_category_tasks->fetchAll();

  if($find_category_tasks->rowCount()>0){
    return $result;
  }else{
    return 'not fouund';
  }
}


function getCompletedTasks($user_id, $conn){

  $find_completed_tasks = $conn->prepare("SELECT * FROM completed WHERE user_id = ? ORDER BY date_completed DESC");
  $find_completed_tasks->bindParam(1,$user_id, PDO::PARAM_STR);
  $find_completed_tasks->execute();
  $result = $find_completed_tasks->fetchAll();

  if($find_completed_tasks->rowCount()>0){
    return $result;
  }else{
    return 'not fouund';
  }

}

function getOverdueTasks($user_id, $conn){
  $currentDate = date('Y-m-d');
  $currentTime = date('H:i:s');
  $currentDateTimestamp = date('Y-m-d H:i:s', strtotime("$currentDate $currentTime"));

  $find_overdue_tasks = $conn->prepare("SELECT * FROM tasks WHERE date_due < ? ORDER BY date_due");
  $find_overdue_tasks->bindParam(1,$currentDateTimestamp, PDO::PARAM_STR);
  $find_overdue_tasks->execute();
  $result = $find_overdue_tasks->fetchAll();

  if($find_overdue_tasks->rowCount()>0){
    return $result;
  }else{
    return 'no notifications';
  }

}


function selectTask($user_id, $id, $conn){
  $getTask = $conn->prepare("SELECT title, category FROM tasks WHERE id = ? AND user_id = ?");
  $getTask->bindParam(1,$id, PDO::PARAM_STR);
  $getTask->bindParam(2,$user_id, PDO::PARAM_STR);
  $getTask->execute();
  $results = $getTask->fetch(PDO::FETCH_ASSOC);

  return $results;
}


function addToCompletedTasks($user_id, $id, $conn){
  $ress = selectTask($user_id, $id, $conn);

  $addToCompletedTasks = $conn->prepare("INSERT INTO completed (task_title, user_id, category) VALUES (?,?,?)");
  $addToCompletedTasks->bindParam(1,$ress['title'], PDO::PARAM_STR);
  $addToCompletedTasks->bindParam(2,$user_id, PDO::PARAM_STR);
  $addToCompletedTasks->bindParam(3,$ress['category'], PDO::PARAM_STR);
  $addToCompletedTasks->execute();
}

function deleteTask($user_id, $id, $conn){
  $deleteTask = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
  $deleteTask->bindParam(1,$id, PDO::PARAM_STR);
  $deleteTask->bindParam(2,$user_id, PDO::PARAM_STR);
  $deleteTask->execute();
}


function completeAndRemoveTasks($user_id, $url, $conn){
  //  date('H:i', $task['time_due']);
  //  date('Y-m-d',$task['time_due']);
  $ids = $url;
  //if url contains only 1 id
  if(strpos($ids, "&") === false){
    addToCompletedTasks($user_id, $ids, $conn);
    deleteTask($user_id, $ids, $conn);
  }else{
    $individual = explode("&",$ids);

    for($i=0; $i<count($individual); $i++){
      addToCompletedTasks($user_id, $individual[$i], $conn);
      deleteTask($user_id, $individual[$i], $conn);
    }
  }

}


function completelyDeleteTask($user_id, $url, $conn){

  $ids = $url;
  //if url contains only 1 id
  if(strpos($ids, "&") === false){
    deleteTask($user_id, $ids, $conn);
  }else{
    $individual = explode("&",$ids);

    for($i=0; $i<count($individual); $i++){
      deleteTask($user_id, $individual[$i], $conn);
    }

  }

}



?>
