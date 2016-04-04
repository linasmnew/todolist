<?php
require_once '../model/db.php';

session_start();
if(!isset($_SESSION['user_id'])){
  header('location: ../register.php');
}
require('../header.php');
require('taskFunctions.php');

if(isset($_GET['category']) && $_GET['category'] !== ''){
  $category_tasks =  getTasks($_SESSION['user_id'], $_GET['category'], $conn);

?>

<ul class="task_actions">
  <li><a id="complete_task_link" href="javascript:;">Mark as completed</a></li>
  <li><a id="remove_task_link" href="javascript:;">Delete task</a></li>
</ul>

<section>
  <?php if(is_string($category_tasks)){
    echo '<p class="not_found">No tasks added</p>';
  }else{ ?>

    <?php foreach($category_tasks as $task) : ?>
      <?php
      //process date and time
      $date = substr($task['date_due'],0, 10);
      $time = substr($task['date_due'],11, 5);
      ?>
      <div class="tasks_div_view_page">
        <p class="title"><?php echo($task['title']); ?> <input type="checkbox" name="selected_task" class="selected_task" value="<?php echo $task['id']; ?>"></p>
        <p class="date_due"><?php echo $task['category']; ?> <span class="date"><?php echo $date;?> <span style="padding-left:5px"><?php echo $time; ?></span></span></p>
      </div>

    <?php endforeach; ?>
    <?php  }  ?>
  </table>
</section>


<p id="notice"></p>

<script src="../js/ajax-requests.js"></script>


<?php

}



?>


<?php require('../footer.php'); ?>
