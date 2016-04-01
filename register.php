<?php
session_start();

if(isset($_SESSION['user_id'])){
  header('location: user/index.php');
}

require('header.php');

?>

<section>
  <h1 class="login_register_titles">Register</h1>

  <form id="login_register_forms" action="registerScript.php" method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="text" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="submit" value="register" name="register">
  </form>

  <?php if(isset($_SESSION['status'])) : ?>
    <?php require_once('message.php'); ?>
  <?php endif; ?>

</section>

<?php require('footer.php'); ?>
