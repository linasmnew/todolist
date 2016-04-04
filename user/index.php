<?php
require_once '../model/db.php';

session_start();

if(!isset($_SESSION['user_id'])){
  header('location: ../login.php');
}

require('categoryFunctions.php');
require('taskFunctions.php');
$result = getCategories($_SESSION['user_id'],$conn);
$overDueTasksResult = getOverdueTasks($_SESSION['user_id'], $conn);

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

    <section id="notifications_section">
      <h2 class="notifications_title">Notifications:</h2>
      <p id="overdue_tasks">Overdue tasks</p>

      <?php if(is_string($overDueTasksResult)){
        echo '<p>no notifications</p>';
      }else{ ?>


          <?php foreach($overDueTasksResult as $task) : ?>
            <?php
            //process date and time
            $date = substr($task['date_due'],0, 10);
            $time = substr($task['date_due'],11, 5);
            ?>
            <div class="tasks_div">
              <p class="title"><?php echo($task['title']); ?></p>
              <p class="date_due"><?php echo $task['category']; ?> <span class="date"><?php echo $date;?> <span style="padding-left:5px"><?php echo $time; ?></span></span></p>
            </div>
          <?php endforeach; ?>
          <?php  }  ?>
    </section>


<?php require('../footer.php'); ?>

<script src="../js/ajax-requests.js"></script>


<?php
if(isset($_POST['add_task'])){
  //capture input into variables here
  $time_due = strtotime($time_due);
  $time_due = date('H:i:s', $time_due);
  echo $time_due;

  $task = $_POST['task'];
  $date_due = $_POST['date'];
  $time_due = $_POST['time'];
  $category = $_POST['category'];

  //format time
  $time_due = strtotime($time_due);
  $time_due = date('H:i:s', $time_due);
  //format date
  $date_due = strtotime($date_due);
  $date_due = date('Y-m-d', $date_due);
  $combinedDateTime = date('Y-m-d H:i:s', strtotime("$date_due $time_due"));
  //process the form here
  $add_task = $conn->prepare("INSERT INTO tasks(title, date_due, category, user_id) VALUES(?, ?, ?, ?)");
  $add_task->bindParam(1, $task, PDO::PARAM_STR);
  $add_task->bindParam(2, $combinedDateTime, PDO::PARAM_STR);
  $add_task->bindParam(3, $category, PDO::PARAM_STR);
  $add_task->bindParam(4, $_SESSION['user_id'], PDO::PARAM_STR);
  $add_task->execute();
  $add_task->closeCursor();


  header('location: index.php');

}//end form submission check
?>
