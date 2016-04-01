<?php
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: ../login.php');
}

require_once('../model/db.php');
require('categoryFunctions.php');
$result = getCategories($_SESSION['user_id'],$conn);

require('../header.php');
?>

<script>
  $(function(){
    $("#datepicker").datepicker();
  });
</script>
    <section>
      <h2 class="add_task_title">Add a task:</h2>
      <form id="add_task_form" method="post">
        <input type="text" name="task" placeholder="Add task...">
        <input type="text" name="date" id="datepicker" placeholder="Click to choose date">
        <input type="text" name="time" placeholder="Enter time: e.g. 16:30">

        <select id="categories_options" name="category">
          <option value="default">Choose category</option>
          <option value="general">General</option>
          <option value="personal">Personal</option>
          <option value="study">Study</option>
          <option value="work">Work</option>
          <option value="fitness">Fitness</option>

          <script src="../js/categories.js"></script>

        </select>
        <input type="submit" value="Add" name="add_task">
      </form>
    </section>

    <aside class="todo_categories">
      <h2 class="categories_title">Categories:</h2>
      <ul>
          <li><a href="view-tasks.php?category=general">General</a></li>
          <li><a href="view-tasks.php?category=personal">Personal</a></li>
          <li><a href="view-tasks.php?category=study">Study</a></li>
          <li><a href="view-tasks.php?category=work">Work</a></li>
          <li><a href="view-tasks.php?category=fitness">Fitness</a></li>

          <?php if($result){
            foreach ($result as $category) : ?>
              <li><a class="new_categories" href="view-tasks.php?category=<?php echo($category['name']); ?>"><?php echo($category['name']); ?></a>
                <a class="delete_category_link" href="<?php echo($category['id']); ?>">X</a>
              </li>
          <?php endforeach;
          }?>

          <li><a class="last_category" href="add-category.php">Add another</a></li>
      </ul>
    </aside>


<?php require('../footer.php'); ?>

<script src="../js/ajax-requests.js"></script>


<?php
if(isset($_POST['add_task'])){
  //capture input into variables here
  $task = $_POST['task'];
  $date_due = $_POST['date'];
  $time_due = $_POST['time'];
  $category = $_POST['category'];

  $time_due = strtotime($time_due);

  //process the form here
  $add_task = $conn->prepare("INSERT INTO tasks(title, date_due, time_due, category, user_id) VALUES(?, ?, ?, ?, ?)");
  $add_task->bindParam(1, $task, PDO::PARAM_STR);
  $add_task->bindParam(2, $date_due, PDO::PARAM_STR);
  $add_task->bindParam(3, $time_due, PDO::PARAM_STR);
  $add_task->bindParam(4, $category, PDO::PARAM_STR);
  $add_task->bindParam(5, $_SESSION['user_id'], PDO::PARAM_STR);
  $add_task->execute();
  $add_task->closeCursor();


  header('location: index.php');

}//end form submission check
?>
