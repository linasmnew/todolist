<?php require('header.php');
session_start();

if(isset($_SESSION['user_id'])){
    header('location: index.php');
}

?>

<section>
  <h1>Register</h1>

  <form action="registerScript.php" method="POST">
    <input type="text" name="username" placeholder="username">
    <input type="text" name="email" placeholder="email">
    <input type="text" name="password" placeholder="password">
    <input type="submit" value="register">
  </form>

  <?php if(isset($_SESSION['status'])) : ?>
    <?php require_once('message.php'); ?>
  <?php endif; ?>

</section>

<?php require('footer.php'); ?>
