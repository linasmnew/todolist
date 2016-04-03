<!doctype html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width">
  <meta charset="UTF-8">
  <title>Todo list</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <?php if(!isset($_SESSION['user_id'])) : ?>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
  <?php else: ?>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
  <?php endif; ?>
</head>
<body>
  <div id="wrapper">
    <header>

      <?php if(isset($_SESSION['user_id'])) : ?>
      <div id="profile_link_container">
        <a href="profile.php">Profile</a>
        <a class="logout" href="logout.php">Logout</a>
      </div>
      <?php endif; ?>

      <div id="logo">
        <a href="index.php">TodoList Manager</a>
      </div>
      <?php if(!isset($_SESSION['user_id'])) : ?>
        <ul>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        </ul>
      <?php endif; ?>

      <?php if(isset($_SESSION['user_id'])) : ?>
      <form id="search_form" action="search.php" method="GET">
        <input type="text" name="search" placeholder="search...">
        <input type="submit" value="search">
      </form>
    <?php endif; ?>

    </header>
