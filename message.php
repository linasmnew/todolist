<?php
  $error = $_SESSION['status'];
  unset($_SESSION['status']);

echo "<div id='alert'>" . $error ."</div>";

?>
