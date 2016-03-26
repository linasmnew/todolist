<?php
session_start();

if(isset($_SESSION['user_id'])){
  header('location: user/index.php');
}

require('header.php');

?>

<section>
  <h1>Register</h1>

  <form action="loginScript.php" method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <input type="submit" value="login" name="login">
  </form>

  <?php if(isset($_SESSION['status'])) : ?>
    <?php require_once('message.php'); ?>
  <?php endif; ?>

</section>



<?php require('footer.php'); ?>
