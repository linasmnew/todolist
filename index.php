<?php
session_start();

if(isset($_SESSION['user_id'])){
  header('location: user/index.php');
}

require('header.php');

?>

    <section>
      <h1>Todo List Manager</h1>
    </section>

<?php require('footer.php'); ?>
