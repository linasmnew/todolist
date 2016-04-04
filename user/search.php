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
  <table class="tasks_table">
    <th>Title</th>
    <th>Date due</th>
    <th>Time due</th>
    <th>Select</th>

    <?php foreach($result as $task) : ?>
      <tr>
        <td class="title"><?php echo($task['title']); ?></td>
        <td class="date_due"><?php echo($task['date_due']); ?></td>
        <td class="time_due"><?php echo date('H:i', $task['time_due']); ?></td>
        <td class="select"><input type="checkbox" name="selected_task" class="selected_task" value="<?php echo $task['id']; ?>"></td>
      </tr>
    <?php endforeach; ?>
    <?php  }  ?>
  </table>
</section>

<p id="notice"></p>

<script src="../js/ajax-requests.js"></script>


<?php require('../footer.php'); ?>
