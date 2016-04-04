<?php
require_once '../model/db.php';

session_start();

if(!isset($_SESSION['user_id'])){
  header('location: ../login.php');
}
require('profileFunctions.php');


$result = getUserDetails($_SESSION['user_id'], $conn);
require('../header.php');
?>

<section>
  <nav id="profile_navigation">
    <ul id="profile_actions">
      <li><a id="completed_tasks_link" href="completed_tasks.php">Completed tasks</a></li>
      <li><a id="account_details_link" href="profile.php">Account details</a></li>
    </ul>
  </nav>


  <form id="update_details_form" action="update_details.php" method="POST">
    <input type="email" name="email" value="<?php echo $result['email']; ?>">
    <input type="submit" value="update email" name="update_email">
  </form>

  <form id="update_details_form" action="update_details.php" method="POST">
    <input type="password" name="oldpassword" placeholder="Enter current password">
    <input type="password" name="newpassword" placeholder="Enter new password">
    <input type="submit" value="update password" name="update_password">
  </form>

  <?php if(isset($_SESSION['status'])) : ?>
    <?php require_once('../message.php'); ?>
  <?php endif; ?>

</section>


<?php require('../footer.php'); ?>
