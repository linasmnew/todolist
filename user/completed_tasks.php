<?php
require_once '../model/db.php';

session_start();

if(!isset($_SESSION['user_id'])){
  header('location: ../login.php');
}
require_once('../model/db.php');
require('taskFunctions.php');

$completed_tasks_result = getCompletedTasks($_SESSION['user_id'], $conn);

require('../header.php');
?>

<section>
  <nav id="profile_navigation">
    <ul id="profile_actions">
      <li><a id="completed_tasks_link" href="completed_tasks.php">Completed tasks</a></li>
      <li><a id="account_details_link" href="profile.php">Account details</a></li>
    </ul>
  </nav>
  <?php if(is_string($completed_tasks_result)){
    echo '<p class="not_found">No tasks added</p>';
  }else{ ?>

    <?php foreach($completed_tasks_result as $task) : ?>

      <div class="tasks_div_view_page">
        <p class="title"><?php echo($task['task_title']); ?></p>
        <p class="date_completed"><?php echo $task['category']; ?> <span class="date"><?php echo $task['date_completed'];?></span></p>
      </div>

    <?php endforeach; ?>
    <?php  }  ?>
  </table>

</section>

<?php require('../footer.php'); ?>
