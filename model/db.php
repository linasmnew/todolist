<?php

$db_options = array(
    PDO::ATTR_EMULATE_PREPARES => false                     // important! use actual prepared statements (default: emulate prepared statements)
, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION           // throw exceptions on errors (default: stay silent)
, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC      // fetch associative arrays (default: mixed arrays)
);

$conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);

function open($path, $name){
  GLOBAL $db_options;
  // echo '<p>session open fired</p>';
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);
  $sess_id =  session_id();
  $initialData = '';

  $setupSession = $conn->prepare("INSERT INTO session(id, data) VALUES(?,?) ON DUPLICATE KEY UPDATE lastaccessed = NOW()");
  $setupSession->bindParam(1, $sess_id, PDO::PARAM_STR);
  $setupSession->bindParam(2, $initialData, PDO::PARAM_STR);
  $setupSession->execute();
}


function read($sess_id){
   GLOBAL $db_options;
   // echo '<p>session read fired</p>';
   $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);

   $readSession = $conn->prepare("SELECT data FROM session where id = ? ");
   $readSession->bindParam(1, $sess_id, PDO::PARAM_STR);
   $readSession->execute();
   $data = $readSession->fetchColumn();
   $readSession->closeCursor();
   return $data;
}


function write($sess_id, $data){
  GLOBAL $db_options;
  // echo '<p>session write fired</p>';
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);

  $writeToSession = $conn->prepare("INSERT INTO session(id, data) VALUES(?,?) ON DUPLICATE KEY UPDATE data = ?");
  $writeToSession->bindParam(1, $sess_id, PDO::PARAM_STR);
  $writeToSession->bindParam(2, $data, PDO::PARAM_STR);
  $writeToSession->bindParam(3, $data, PDO::PARAM_STR);
  $writeToSession->execute();
}


function close() {
  GLOBAL $db_options;
  // echo '<p>session close fired</p>';
  $sess_id = session_id();
}


function destroy($sess_id) {
  GLOBAL $db_options;
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);

  $sessionCleanUp = $conn->prepare("DELETE FROM session WHERE id = ?");
  $sessionCleanUp->bindParam(1, $sess_id, PDO::PARAM_STR);
  $sessionCleanUp->execute();

  setcookie(session_name(), "", time() - 9999);
}


function gc($sessionLifetime) {
  GLOBAL $db_options;
  $conn = new PDO('mysql:host=127.0.0.1;dbname=todo;charset=utf8', 'root', '', $db_options);

  $sessionCleanUp = $conn->prepare("DELETE FROM session WHERE lastaccessed < DATE_SUB(NOW(), INTERVAL ? SECOND)");
  $sessionCleanUp->bindParam(1, $sess_id, PDO::PARAM_STR);
  $sessionCleanUp->bindParam(2, $sessionLifetime, PDO::PARAM_STR);
  $sessionCleanUp->execute();
}


session_set_save_handler("open", "close", "read", "write", "destroy", "gc");


?>
