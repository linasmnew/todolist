<?php
require_once 'model/db.php';
session_start();

if(isset($_SESSION['user_id'])){
  header('location: user/index.php');
}

require('header.php');
?>

    <section id="homepage">
      <p>The best cloud solution <br><span style="padding-left:40px">for managing your tasks</span></p>

      <img src="img/bg.png" width="900">
    </section>

<?php require('footer.php'); ?>
