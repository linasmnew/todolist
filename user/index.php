<?php
session_start();

if(!isset($_SESSION['user_id'])){
  header('location: ../register.php');
}

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
        <input type="text" name="date" id="datepicker" placeholder="click to choose date">
        <input type="text" name="time" placeholder="Enter time: e.g. 16:30">
        <select name="category">
          <option value="default">Choose category</option>
          <option value="general">General</option>
          <option value="personal">Personal</option>
          <option value="study">Study</option>
          <option value="work">Work</option>
          <option value="fitness">Fitness</option>
        </select>
        <input type="submit" value="Add" name="add_task">
      </form>
    </section>

    <aside class="todo_categories">
      <h2 class="categories_title">Categories:</h2>
      <ul>
          <li><a href="#">General</a></li>
          <li><a href="#">Personal</a></li>
          <li><a href="#">Study</a></li>
          <li><a href="#">Work</a></li>
          <li><a href="#">Fitness</a></li>
          <li><a class="last_category" href="#">Add another</a></li>
      </ul>
    </aside>

<?php require('../footer.php'); ?>
