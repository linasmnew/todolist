<?php

function getCategories($user_id, $conn){
  $find_category = $conn->prepare("SELECT * FROM category WHERE user_id = ?");
  $find_category->bindParam(1,$user_id, PDO::PARAM_STR);
  $find_category->execute();
  $result = $find_category->fetchAll();

  if($find_category->rowCount()>0){
    return $result;
  }else{
    return false;
  }
}


function findCategoriesTasks($user_id, $category_id, $conn){
  $find_category = $conn->prepare("SELECT name FROM category WHERE id = ? AND user_id = ?");
  $find_category->bindParam(1,$category_id, PDO::PARAM_STR);
  $find_category->bindParam(2,$user_id, PDO::PARAM_STR);
  $find_category->execute();
  $result = $find_category->fetch(PDO::FETCH_ASSOC);

  return $result;
}


function deleteCategoriesTasks($user_id, $category_id, $conn){
  $categoryTasks = findCategoriesTasks($user_id, $category_id, $conn);

  $deleteCategoriesTask = $conn->prepare("DELETE FROM tasks WHERE user_id = ? AND category = ?");
  $deleteCategoriesTask->bindParam(1,$user_id, PDO::PARAM_STR);
  $deleteCategoriesTask->bindParam(2,$categoryTasks['name'], PDO::PARAM_STR);
  $deleteCategoriesTask->execute();
}

function deleteCategory($user_id, $category_id, $conn){

  deleteCategoriesTasks($user_id, $category_id, $conn);

  $deleteCategory = $conn->prepare("DELETE FROM category WHERE user_id = ? AND id = ?");
  $deleteCategory->bindParam(1,$user_id, PDO::PARAM_STR);
  $deleteCategory->bindParam(2,$category_id, PDO::PARAM_STR);
  $deleteCategory->execute();
}




?>
