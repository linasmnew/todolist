<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header('location: ../register.php');
}
require('../header.php');

?>


<section>
  <h2 class="add_category_title">Add a category:</h2>
  <form id="add_category_form" method="post">
    <input type="text" name="category_name" placeholder="Enter category name...">
    <input type="submit" value="Add" name="add_category">
  </form>
</section>



<?php require('../footer.php'); ?>




<?php
if(isset($_POST['add_category'])){
  require_once('../model/db.php');
  //capture input into variables here
  $category = $_POST['category_name'];

  //process the form here
  $add_category = $conn->prepare("INSERT INTO category(name, user_id) VALUES(?, ?)");
  $add_category->bindParam(1, $category, PDO::PARAM_STR);
  $add_category->bindParam(2, $_SESSION['user_id'], PDO::PARAM_STR);
  $add_category->execute();
  $add_category->closeCursor();

  header('location: add-category.php');

}
?>
