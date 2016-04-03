<?php
$db_options = array(
    PDO::ATTR_EMULATE_PREPARES => false                     // important! use actual prepared statements (default: emulate prepared statements)
, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION           // throw exceptions on errors (default: stay silent)
, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC      // fetch associative arrays (default: mixed arrays)
);
$conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);    // important! specify the character encoding in the DSN string, don't use SET NAMES
?>
