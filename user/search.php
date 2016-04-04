<?php
require_once '../model/db.php';
session_start();
if(!isset($_SESSION['user_id'])){
  header('location: ../login.php');
}

require('../header.php');

require('searchFunctions.php');


if(isset($_GET['search'])){
  $keyword = $_GET['search'];

  $result = getTasksBySearch($_SESSION['user_id'], $keyword, $conn);

}
?>


<ul class="task_actions">
  <li><a id="complete_task_link" href="javascript:;">Mark as completed</a></li>
  <li><a id="remove_task_link" href="javascript:;">Delete task</a></li>
</ul>

<section>
  <?php if(is_string($result)){
    echo '<p class="not_found">Nothing matched the search criteria</p>';
  }else{ ?>

    <?php foreach($result as $task) : ?>
      <?php
      //process date and time
      $date = substr($task['date_due'],0, 10);
      $time = substr($task['date_due'],11, 5);
      ?>
      <div class="tasks_div_view_page">
        <p class="title"><?php echo($task['title']); ?> </p>
        <p class="date_due"><?php echo $task['category']; ?> <span class="date"><?php echo $date;?> <span style="padding-left:5px"><?php echo $time; ?></span></span></p>
      </div>

    <?php endforeach; ?>
    <?php  }  ?>
</section>

<p id="notice"></p>

<script src="../js/ajax-requests.js"></script>


<?php require('../footer.php'); ?>
